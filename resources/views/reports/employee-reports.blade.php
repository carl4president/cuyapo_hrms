@extends('layouts.master')
@section('content')
{{-- message --}}

<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Chart Configuration</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chart Configuration</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <div class="input-group">
                        <button class="btn add-btn" id="addGraphBtn" data-toggle="modal" data-target="#selectGraphModal"><i class="fa fa-plus"></i> Add Graph</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->
        <div class="row">
            <div class="col-md-12">
                <div class="card-group m-b-30" id="graphsContainer">
                </div>
            </div>
        </div>
        <!-- /Content End -->
    </div>

    <!-- /Page Content -->
</div>

<!-- Modal for Categorizing Graph Data -->
<div class="modal custom-modal fade" id="selectGraphModal" tabindex="-1" role="dialog" aria-labelledby="selectGraphModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectGraphModalLabel">Select Graph Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="graphTypeSelect">Select Graph Type:</label>
                        <select id="graphTypeSelect" class="form-control">
                            <option value="Bar">Bar Chart</option>
                            <option value="Bar-stacked">Bar Stacked Chart</option>
                            <option value="Pie">Pie Chart</option>
                            <option value="Line">Line Chart</option>
                            <option value="Radar">Radar Chart</option>
                            <option value="Doughnut">Doughnut Chart</option>
                            <option value="PolarArea">Polar Area Chart</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="departmentName">Department:</label>
                        <select id="departmentName" class="form-control">
                            <!-- Dynamically populate departments -->
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filterColumn">Filter by:</label>
                        <select id="filterColumn" class="form-control">
                            <option value="Gender">Gender</option>
                            <option value="Civil Status">Civil Status</option>
                            <option value="Nationality">Nationality</option>
                            <option value="Blood Type">Blood Type</option>
                            <option value="Employment Status">Employment Status</option>
                            <option value="Leave Status">Leave Status</option>
                        </select>
                    </div>
                </form>
                <div class="submit-section">
                    <button type="submit" class="btn btn-primary submit-btn" id="submitGraphBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>




@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        let graphCounter = 0;

        // Load stored graphs when the page loads
        function loadStoredGraphs() {
            $.ajax({
                url: "{{ route('all/employee/storedgraph/data') }}", // Adjust route as needed
                method: "GET"
                , success: function(graphs) {
                    graphs.forEach(graph => {
                        createGraph(graph.graph_type, graph.id, graph.labels, graph.values, graph.department_filter_column, graph.filter_column); // Ensure 'filter_column' is passed from the backend
                    });
                }
                , error: function(xhr) {
                    console.error("Error loading stored graphs:", xhr.responseText);
                }
            });
        }

        loadStoredGraphs(); // Load graphs on page load

        // Handle 'Add Graph' button click to open the modal
        $('#addGraphBtn').on('click', function(e) {
            e.preventDefault();
            $('#selectGraphModal').modal('show');
        });

        // Handle 'Submit' button inside the modal to save the graph
        $('#submitGraphBtn').on('click', function() {
            const graphType = $('#graphTypeSelect').val();
            const filterColumn = $('#filterColumn').val().trim();
            const departmentName = $('#departmentName').val();

            if (!graphType || !filterColumn) {
                alert("Please select a graph type and enter a column name.");
                return;
            }

            // Send selected graph type and filter column to the backend
            $.ajax({
                url: "{{ route('all/employee/graph/data') }}", // Adjust route
                method: 'POST'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , column: filterColumn
                    , graph_type: graphType
                    , department: departmentName
                }
                , success: function(data) {
                    createGraph(graphType, data.graph_id, data.labels, data.values, data.department, filterColumn); // Change to data.department
                    $('#selectGraphModal').modal('hide');
                }
                , error: function(xhr) {
                    console.error("Error fetching graph data:", xhr.responseText);
                }
            });
        });

        // Function to create a graph card dynamically
        function createGraph(graphType, graphId = null, labels = [], values = [], departmentName, filterColumn) {
            graphCounter++; // Increment only once

            const id = graphId ? `employee-chart-${graphId}` : `employee-chart-${graphCounter}`;
            const title = filterColumn ? `Graph for ${filterColumn}` : `Graph #${graphCounter}`;
            const department = departmentName ? `Department: ${departmentName}` : `Department: All Department`; // Renamed to departmentName

            // Create card and wrap it with col-md-6 for responsiveness
           $('#graphsContainer').append(`
                <div class="col-md-6 mt-3" id="card-${id}">
                    <div class="card" style="max-height: 435px; overflow: auto;">
                        <div class="card-body">
                            <div style="display: flex; justify-content: space-between; align-items: center;margin-bottom: 10px;">
                                <!-- Title and Delete Icon in Same Row -->
                                <h3 class="card-title" style="margin: 0;">${title}</h3>
                                <div style="display: inline-block;">
                                    <a href="javascript:void(0);" class="delete-icon" data-id="${graphId}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- Add department name below the title -->
                            ${department ? `<h5 class="card-subtitle text-muted">${department}</h5>` : ''}
                            <div id="${id}" class="graph-container">
                                <!-- Canvas will be added here -->
                            </div>
                        </div>
                    </div>
                </div>
            `);


            // Check if labels and values are provided and non-empty
            if (Array.isArray(labels) && Array.isArray(values) && labels.length > 0 && values.length > 0) {
                renderGraph(id, labels, values, graphType, departmentName, filterColumn);
            }
        }


        function renderGraph(graphId, labels, values, graphType) {
            // Select the correct container for the chart
            const graphContainer = document.getElementById(graphId);

            // Check if the graphContainer exists
            if (!graphContainer) {
                console.error(`Graph container with id ${graphId} not found.`);
                return; // Exit if the container is not found
            }

            // Create a new canvas element for the graph
            const canvasElement = document.createElement("canvas");
            canvasElement.id = `${graphId}-chart`; // Set a unique ID for the canvas
            canvasElement.width = 400; // Optional: Set canvas width
            canvasElement.height = 300; // Optional: Set canvas height
            graphContainer.appendChild(canvasElement); // Add the canvas to the container

            // Get the 2D context to render the graph
            const ctx = canvasElement.getContext("2d");

            // Prepare chart data for rendering
            const data = {
                labels: labels, // X-axis labels
                datasets: [{
                    label: 'Count', // Label for the bars
                    data: values, // The data for the bars
                    backgroundColor: [
                        '#FF6F61', // Soft Red
                        '#6B5B95', // Lavender
                        '#88B04B', // Olive Green
                        '#F2C77F', // Light Gold
                        '#F76C6C', // Coral
                        '#00BFAE', // Turquoise
                        '#FFB6B9', // Light Pink
                        '#9B59B6', // Amethyst
                        '#1ABC9C', // Aqua Green
                        '#F39C12' // Golden Yellow
                    ], // Updated dynamic colors
                    borderColor: [
                        '#E74C3C', // Red
                        '#8E44AD', // Purple
                        '#27AE60', // Green
                        '#F39C12', // Yellow
                        '#F1C40F', // Golden
                        '#1ABC9C', // Aqua
                        '#D75B5B', // Deep Pink
                        '#8E44AD', // Purple
                        '#2980B9', // Blue
                        '#F4D03F' // Yellow
                    ], // Updated border colors
                    borderWidth: 1
                }]
            };



            const commonOptions = {
                responsive: true
                , scales: {
                    y: {
                        beginAtZero: true
                    }
                    , x: {
                        title: {
                            display: true
                            , text: 'Label'
                        }
                    }
                }
            };

            // Render the graph based on the selected graph type
            if (graphType.toLowerCase() === "bar") {
                new Chart(ctx, {
                    type: 'bar'
                    , data: data
                    , options: commonOptions
                }); // Render Bar chart
            } else if (graphType.toLowerCase() === "pie") {
                const pieConfig = {
                    type: 'pie'
                    , data: {
                        labels: labels
                        , datasets: [{
                            data: values
                            , backgroundColor: ['#f43b48', '#453a94', '#34d399', '#ff5733', '#ffb700']
                        }]
                    }
                    , options: {
                        responsive: true
                    }
                };
                new Chart(ctx, pieConfig); // Render Pie chart
            } else if (graphType.toLowerCase() === "bar-stacked") {
                // Stacked Bar Chart
                commonOptions.scales = {
                    x: {
                        stacked: true
                        , title: {
                            display: true
                            , text: 'Label'
                        }
                    }
                    , y: {
                        stacked: true
                        , beginAtZero: true
                    }
                };
                new Chart(ctx, {
                    type: 'bar'
                    , data: data
                    , options: commonOptions
                }); // Render Stacked Bar chart
            } else if (graphType.toLowerCase() === "line") {
                const lineConfig = {
                    type: 'line'
                    , data: data
                    , options: commonOptions
                };
                new Chart(ctx, lineConfig); // Render Line chart
            } else if (graphType.toLowerCase() === "radar") {
                const radarConfig = {
                    type: 'radar'
                    , data: data
                    , options: commonOptions
                };
                new Chart(ctx, radarConfig); // Render Radar chart
            } else if (graphType.toLowerCase() === "doughnut") {
                const doughnutConfig = {
                    type: 'doughnut'
                    , data: data
                    , options: {
                        responsive: true
                    }
                };
                new Chart(ctx, doughnutConfig); // Render Doughnut chart
            } else if (graphType.toLowerCase() === "polararea") {
                const polarAreaConfig = {
                    type: 'polarArea'
                    , data: {
                        labels: labels
                        , datasets: [{
                            data: values
                            , backgroundColor: ['#f43b48', '#453a94', '#34d399', '#ff5733', '#ffb700']
                        }]
                    }
                    , options: {
                        responsive: true
                    }
                };
                new Chart(ctx, polarAreaConfig); // Render Polar Area chart
            }
        }



        // Handle Delete Graph Button Click
        $(document).on('click', '.delete-icon', function() {
            const graphId = $(this).data('id');

            if (!graphId) {
                $(this).closest('.card').remove();
                return;
            }

            $.ajax({
                url: "{{ route('all/employee/delete-graph', '') }}" + "/" + graphId
                , method: 'DELETE'
                , data: {
                    _token: "{{ csrf_token() }}"
                }
                , success: function() {
                    $(`#card-employee-chart-${graphId}`).remove();
                }
                , error: function(xhr) {
                    console.error("Error deleting graph:", xhr.responseText);
                }
            });
        });
    });

</script>




@endsection
@endsection
