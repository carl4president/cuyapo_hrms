<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Session;

class Leave extends Model
{
    use HasFactory;
    protected $fillable = [
        'staff_id',
        'employee_name',
        'leave_type',
        'remaining_leave',
        'date_from',
        'date_to',
        'number_of_day',
        'leave_date',
        'leave_day',
        'status',
        'reason',
        'approved_by',
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
            if (!empty($request->employee_name)) {
                $employee_name = $request->employee_name;
                $employee_id   = $request->employee_id;
            } else {
                $employee_name = Session::get('name');
                $employee_id   = Session::get('user_id');
            }

            Leave::updateOrCreate(
                [
                    'id' => $request->id_record, // Unique attribute(s) to check for existing record
                ],
                [
                    'staff_id'        => $employee_id,
                    'employee_name'   => $employee_name,
                    'leave_type'      => $request->leave_type,
                    'remaining_leave' => $request->remaining_leave,
                    'date_from'       => $request->date_from,
                    'date_to'         => $request->date_to,
                    'number_of_day'   => $request->number_of_day,
                    'leave_date'      => json_encode($request->leave_date),
                    'leave_day'       => json_encode($request->select_leave_day),
                    'status'          => 'Pending',
                    'reason'          => $request->reason,
                    'approved_by'     => Session::get('line_manager'),
                ]
            );

            flash()->success('Apply Leave successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            \Log::error($e); // Log the error
            flash()->error('Failed Apply Leave :)');
            return redirect()->back();
        }
    }


    public function editLeave(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'leave_id'               => 'required|integer',
            'leave_type'             => 'required|string',
            'date_from'              => 'required|string',
            'date_to'                => 'required|string',
            'reason'                 => 'required|string',
            'remaining_leave'        => 'nullable|numeric',
            'number_of_day'          => 'nullable|numeric',
            'edit_leave_date'        => 'nullable|array', // Validate edit_leave_date as an array
            'edit_select_leave_day'  => 'nullable|array', // Validate edit_select_leave_day as an array
        ]);

        try {
            // Debug: Check incoming request data
            \Log::info('editLeave request data:', $request->all());

            // Process edit_leave_date and edit_select_leave_day
            $leave_date = $request->has('edit_leave_date') && is_array($request->edit_leave_date) && count($request->edit_leave_date) > 0
                ? json_encode($request->edit_leave_date)
                : json_encode([]);

            $select_leave_day = $request->has('edit_select_leave_day') && is_array($request->edit_select_leave_day) && count($request->edit_select_leave_day) > 0
                ? json_encode($request->edit_select_leave_day)
                : json_encode([]);

            // Log processed data for debugging
            \Log::info('Processed data:', [
                'leave_date' => $leave_date,
                'select_leave_day' => $select_leave_day,
            ]);

            // Update or create the leave record
            $leave = Leave::find($request->leave_id);

            if ($leave) {
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
                ]);

            } else {
                flash()->error('Leave record not found.');
            }

            flash()->success('Leave updated successfully!');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            // Log error for debugging
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
            Leave::destroy($request->id_record);
            flash()->success('Leaves deleted successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Leaves delete fail :)');
            return redirect()->back();
        }
    }
}
