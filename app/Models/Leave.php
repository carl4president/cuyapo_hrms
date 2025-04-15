<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;

class Leave extends Model
{
    use HasFactory;
    protected $fillable = [
        'staff_id',
        'employee_name',
        'leave_type',
        'date_from',
        'date_to',
        'number_of_day',
        'leave_date',
        'leave_day',
        'status',
        'reason',
        'approved_by',
        'vacation_location',
        'abroad_specify',
        'sick_location',
        'illness_specify',
        'women_illness',
        'study_reason',
    ];
    



    /** Save Record Leave or Update */
    public function applyLeave(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|string',
            'date_from'  => 'required',
            'date_to'    => 'required',
            'reason'     => 'required',
        ]);

        try {
            // Get employee details
            if (!empty($request->employee_name)) {
                $employee_name = $request->employee_name;
                $employee_id   = $request->employee_id;
            } else {
                $employee_name = Session::get('name');
                $employee_id   = Session::get('user_id');
            }

            // Calculate the number of days for the leave
            $number_of_days = $request->number_of_day;  // No restriction for decimal or negative values

            // Retrieve the current leave balance for the employee and leave type
            $leave_balance = LeaveBalance::where('staff_id', $employee_id)
                ->where('leave_type', $request->leave_type)
                ->first();

            // If no leave balance exists, get the leave days from LeaveInformation table
            if (!$leave_balance) {
                // Fetch the leave policy for the employee's leave type
                $leavePolicy = LeaveInformation::where(function ($query) use ($employee_id) {
                    $query->whereJsonContains('staff_id', $employee_id);
                })
                    ->where('leave_type', $request->leave_type)
                    ->first();

                // If no policy is found, fallback to a default of 15 leave days
                $total_leave_days = $leavePolicy ? $leavePolicy->leave_days : 15;

                // Create the leave balance entry using the leave policy or default value
                $leave_balance = new LeaveBalance();
                $leave_balance->staff_id = $employee_id;
                $leave_balance->leave_type = $request->leave_type;
                $leave_balance->total_leave_days = $total_leave_days;  // Use leave days from policy
                $leave_balance->used_leave_days = 0;

                // Store remaining leave days as JSON with timestamp as the index
                $leave_balance->remaining_leave_days = json_encode([Carbon::now()->toDateTimeString() => [$total_leave_days, $total_leave_days]]);

                $leave_balance->save();
            }

            // Log the current balance for debugging
            \Log::info('Current leave balance:', [
                'staff_id' => $employee_id,
                'leave_type' => $request->leave_type,
                'remaining_leave_days' => $leave_balance->remaining_leave_days
            ]);

            // Check if the employee has enough leave balance
            $remaining_leave_days = json_decode($leave_balance->remaining_leave_days, true);

            // Get the latest remaining leave days by accessing the most recent timestamp in the JSON object
            $latest_timestamp = end($remaining_leave_days);  // Get the last (most recent) value
            $original_leave_days = $latest_timestamp[0]; // The leave days before deduction
            $latest_remaining_leave = $latest_timestamp[1]; // The most recent remaining leave

            // Allow negative or decimal leave days
            if ($original_leave_days >= $number_of_days || true) {  // no restriction for negative or decimal
                // Deduct the leave days from the remaining balance
                $remaining_leave_days[Carbon::now()->toDateTimeString()] = [
                    $latest_remaining_leave,  // Original leave days before deduction
                    $latest_remaining_leave - $number_of_days // Updated leave days after deduction
                ];

                // Save the updated remaining leave days
                $leave_balance->remaining_leave_days = json_encode($remaining_leave_days);
                $leave_balance->used_leave_days += $number_of_days;
                $leave_balance->save();

                // Create or update the leave record
                Leave::updateOrCreate(
                    [
                        'id' => $request->id_record, // Unique attribute(s) to check for existing record
                    ],
                    [
                        'staff_id'        => $employee_id,
                        'employee_name'   => $employee_name,
                        'leave_type'      => $request->leave_type,
                        'date_from'       => $request->date_from,
                        'date_to'         => $request->date_to,
                        'number_of_day'   => $number_of_days,
                        'leave_date'      => json_encode($request->leave_date),
                        'leave_day'       => json_encode($request->select_leave_day),
                        'status'          => 'Pending',
                        'reason'          => $request->reason,
                        'approved_by'     => null,
                        'vacation_location' => $request->vacation_location,
                        'abroad_specify'   => $request->abroad_specify,
                        'sick_location'    => $request->sick_location,
                        'illness_specify'  => $request->illness_specify,
                        'women_illness'    => $request->women_illness,
                        'study_reason'      => is_array($request->study_reason) ? json_encode($request->study_reason) : $request->study_reason,
                    ]
                );

                flash()->success('Apply Leave successfully :)');
                return redirect()->back();
            } else {
                // Log the error for insufficient balance
                \Log::error('Insufficient leave balance:', [
                    'staff_id' => $employee_id,
                    'leave_type' => $request->leave_type,
                    'remaining_leave_days' => $latest_timestamp,
                    'requested_days' => $number_of_days
                ]);

                // If not enough leave balance, show an error
                flash()->error('Insufficient leave balance.');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            \Log::error($e); // Log the error
            flash()->error('Failed Apply Leave :)');
            return redirect()->back();
        }
    }



    public function editLeave(Request $request)
    {
        $request->validate([
            'leave_id'               => 'required|integer',
            'leave_type'             => 'required|string',
            'date_from'              => 'required|string',
            'date_to'                => 'required|string',
            'reason'                 => 'required|string',
            'remaining_leave'        => 'nullable|numeric',
            'number_of_day'          => 'nullable|numeric',
            'edit_leave_date'        => 'nullable|array',
            'edit_select_leave_day'  => 'nullable|array',
        ]);

        try {
            \Log::info('editLeave request data:', $request->all());

            $leave_date = $request->has('edit_leave_date') && is_array($request->edit_leave_date)
                ? json_encode($request->edit_leave_date)
                : json_encode([]);

            $select_leave_day = $request->has('edit_select_leave_day') && is_array($request->edit_select_leave_day)
                ? json_encode($request->edit_select_leave_day)
                : json_encode([]);

            $leave = Leave::find($request->leave_id);

            if ($leave) {
                $leaveBalance = LeaveBalance::where('staff_id', $leave->staff_id)
                    ->where('leave_type', $leave->leave_type)
                    ->latest('created_at')
                    ->first();

                if ($leaveBalance) {
                    $remainingLeaveDays = json_decode($leaveBalance->remaining_leave_days, true);
                    \Log::info('Original balance:', $remainingLeaveDays);

                    if (count($remainingLeaveDays) > 0) {
                        ksort($remainingLeaveDays); // sort by time

                        $editTimestamp = $leave->created_at->format('Y-m-d H:i:s');

                        $newUsedDays = $request->number_of_day;

                        $previousValue = null;
                        $adjustment = 0;
                        $startedAdjusting = false;

                        foreach ($remainingLeaveDays as $timestamp => &$days) {
                            if (!$startedAdjusting && $timestamp === $editTimestamp) {
                                $originalBase = $days[0];
                                $originalUsed = $originalBase - $days[1];

                                $adjustment = $newUsedDays - $originalUsed; // + means more days used

                                $days[0] = $originalBase;
                                $days[1] = $originalBase - $newUsedDays;

                                $previousValue = $days[1];
                                $startedAdjusting = true;
                            } elseif ($startedAdjusting) {
                                // shift the next entries by the same adjustment
                                $oldBase = $days[0];
                                $oldUsed = $oldBase - $days[1];

                                $newBase = $previousValue;
                                $newRemaining = $newBase - $oldUsed;

                                $days[0] = $newBase;
                                $days[1] = $newRemaining;

                                $previousValue = $days[1];
                            }
                        }
                        unset($days);

                        \Log::info('Updated leave chain with adjusted values:', $remainingLeaveDays);

                        $leaveBalance->remaining_leave_days = json_encode($remainingLeaveDays);
                        $leaveBalance->save();
                    }
                }

                $study_reason = $request->has('study_reason') ? json_encode($request->study_reason) : null;

                $leave->update([
                    'leave_type'      => $request->leave_type,
                    'remaining_leave' => $request->remaining_leave ?? 0,
                    'date_from'       => $request->date_from,
                    'date_to'         => $request->date_to,
                    'number_of_day'   => $request->number_of_day ?? 0,
                    'leave_date'      => $leave_date,
                    'leave_day'       => $select_leave_day,
                    'status'          => 'Pending',
                    'reason'          => $request->reason,
                    'approved_by'     => Session::get('line_manager', null),

                    'vacation_location' => $request->vacation_location,
                    'abroad_specify'    => $request->abroad_specify,
                    'sick_location'     => $request->sick_location,
                    'illness_specify'   => $request->illness_specify,
                    'women_illness'     => $request->women_illness,
                    'study_reason'      => $study_reason,
                ]);

                flash()->success('Leave updated successfully!');
                return redirect()->back()->withInput();
            } else {
                flash()->error('Leave record not found.');
            }
        } catch (\Exception $e) {
            \Log::error('Error in editLeave:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

            flash()->error('Failed to update leave. Please try again later.');
            return redirect()->back()->withInput();
        }
    }





    /** Delete Record */
    public function deleteRecord(Request $request)
    {
        try {
            // Fetch the leave record
            $leave = Leave::find($request->id);

            if (!$leave) {
                flash()->error('Leave record not found.');
                return redirect()->back();
            }

            // Find the leave balance record for this leave
            $leaveBalance = LeaveBalance::where('staff_id', $leave->staff_id)
                ->where('leave_type', $leave->leave_type)
                ->latest('created_at')
                ->first();

            if (!$leaveBalance) {
                flash()->error('Leave balance not found.');
                return redirect()->back();
            }

            // Decode the current leave data
            $remainingLeaveDays = json_decode($leaveBalance->remaining_leave_days, true);

            // Check if the data exists
            if (count($remainingLeaveDays) > 0) {
                // Find the timestamp to be deleted
                $deletedTimestamp = $leave->created_at->format('Y-m-d H:i:s');

                // Check if the timestamp exists in the array
                if (isset($remainingLeaveDays[$deletedTimestamp])) {
                    // Find the index of the deleted timestamp
                    $deletedIndex = array_search($deletedTimestamp, array_keys($remainingLeaveDays));

                    // Get the range (difference) for the next timestamp
                    $nextTimestamp = array_keys($remainingLeaveDays)[$deletedIndex + 1] ?? null;

                    if ($nextTimestamp) {
                        // Calculate the range difference
                        $usedLeaveDiff = $remainingLeaveDays[$nextTimestamp][0] - $remainingLeaveDays[$nextTimestamp][1];

                        // Adjust the next timestamp to start from the previous end (deleted timestamp)
                        $remainingLeaveDays[$nextTimestamp][0] = $remainingLeaveDays[$deletedTimestamp][1];
                        $remainingLeaveDays[$nextTimestamp][1] = $remainingLeaveDays[$nextTimestamp][0] - $usedLeaveDiff;

                        // Log the adjustments
                        \Log::info('Adjusted next timestamp for sequence with diff:', [
                            'next_timestamp' => $nextTimestamp,
                            'new_values' => $remainingLeaveDays[$nextTimestamp]
                        ]);
                    }

                    // Remove the deleted timestamp from the array
                    unset($remainingLeaveDays[$deletedTimestamp]);

                    // Save the updated leave balance
                    $leaveBalance->remaining_leave_days = json_encode($remainingLeaveDays);
                    $leaveBalance->save();

                    // Log the successful removal and adjustment
                    \Log::info('Deleted timestamp and updated remaining leave days:', $remainingLeaveDays);

                    // Flash success message
                    flash()->success('Leave record deleted successfully!');
                } else {
                    flash()->error('Timestamp not found in the leave data.');
                }
            }

            // Delete the leave record from the Leave table
            Leave::destroy($request->id);

            return redirect()->back();
        } catch (\Exception $e) {
            \Log::error('Error during deleteRecord:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

            flash()->error('Failed to delete leave. Please try again later.');
            return redirect()->back();
        }
    }
}
