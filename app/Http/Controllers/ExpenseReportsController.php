<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\Employee;
use App\Models\GraphData;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Schema;

class ExpenseReportsController extends Controller
{
    // view page
    /** employee-reports page */
    public function employeeReportsIndex()
    {
        $departments = department::all();
        return view('reports.employee-reports', compact('departments'));
    }

    public function getGraphData(Request $request)
{
    $inputColumn = strtolower(str_replace(' ', '_', $request->input('column')));
    $dbColumns = Schema::getColumnListing('employees');
    $validColumns = array_map(fn($col) => strtolower($col), $dbColumns);

    // Add the 'employment_status' and 'leave_status' columns to the valid columns list
    $validColumns[] = 'employment_status'; // From employee_employment
    $validColumns[] = 'leave_status'; // Alias for leaves.status

    $bestMatch = null;
    $highestSimilarity = 0;

    // Check for the best match
    foreach ($validColumns as $column) {
        similar_text($inputColumn, $column, $percent);
        if ($percent > $highestSimilarity) {
            $highestSimilarity = $percent;
            $bestMatch = $column;
        }
    }

    if ($highestSimilarity < 60) {
        return response()->json(['error' => 'Column not found'], 400);
    }

    $realColumnName = $bestMatch;

    // Get the department from the request if available
    $department = $request->input('department');

    // Start building the query
    $query = Employee::select(
            // If the matched column is leave_status, alias it from leaves table
            $realColumnName == 'leave_status' ? 'leaves.status as leave_status' : $realColumnName, 
            DB::raw('count(*) as count')
        )
        ->join('employee_job_details', 'employee_job_details.emp_id', '=', 'employees.emp_id')
        ->join('departments', 'employee_job_details.department_id', '=', 'departments.id')
        ->leftJoin('employee_employment', 'employee_employment.emp_id', '=', 'employees.emp_id')  // Left join with employee_employment
        ->leftJoin('leaves', 'leaves.staff_id', '=', 'employees.emp_id')  // Left join with leaves
        ->groupBy($realColumnName);

    // Filter out records where leave_status is null
    if ($realColumnName == 'leave_status') {
        $query->whereNotNull('leaves.status');
    }

    // Filter by department if available
    if ($department) {
        $query->where('departments.id', $department);
    }

    // Get the data
    $data = $query->get();

    $graphData = [
        'labels' => $data->pluck($realColumnName)->toArray(),
        'values' => $data->pluck('count')->toArray()
    ];

    // Save the graph data to the database
    $graph = GraphData::create([
        'graph_type' => $request->input('graph_type'),
        'filter_column' => $realColumnName,
        'department_filter_column' => $department,
        'data' => json_encode($graphData),
    ]);

    // Get department name if available
    $departmentName = $department ? department::find($department)->department : null;

    \Log::info('Department Name: ' . $departmentName);

    return response()->json([
        'message' => 'Graph saved successfully!',
        'graph_id' => $graph->id,
        'labels' => $graphData['labels'],
        'values' => $graphData['values'],
        'department' => $departmentName,
        'filter_column' => $realColumnName
    ]);
}




    public function deleteGraph($graphId)
    {
        $graph = GraphData::findOrFail($graphId);
        $graph->delete();

        return response()->json(['message' => 'Graph deleted successfully']);
    }

    public function getAllStoredGraphs()
    {
        $graphs = GraphData::all();

        return response()->json($graphs->map(function ($graph) {
            $formattedColumn = ucwords(str_replace('_', ' ', $graph->filter_column));
            $departmentId = $graph->department_filter_column;

            $departmentName = null;
            if ($departmentId && is_numeric($departmentId)) {

                $department = Department::find($departmentId);
                if ($department) {
                    $departmentName = $department->department;
                }
            } else {

                $departmentName = $departmentId;
            }

            \Log::info('Department Name Other: ' . $departmentName);

            return [
                'id' => $graph->id,
                'graph_type' => $graph->graph_type,
                'labels' => json_decode($graph->data, true)['labels'] ?? [],
                'values' => json_decode($graph->data, true)['values'] ?? [],
                'department_filter_column' => $departmentName,
                'filter_column' => $formattedColumn
            ];
        }));
    }
}
