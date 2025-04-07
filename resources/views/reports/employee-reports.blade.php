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
                    <h3 class="page-title">Employee Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee Report</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <div class="input-group">
                        <button class="btn btn-success" id="addGraphBtn" data-toggle="modal" data-target="#selectGraphModal">Add Graph</button>
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
<div class="modal fade" id="selectGraphModal" tabindex="-1" role="dialog" aria-labelledby="selectGraphModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectGraphModalLabel">Select Graph Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="graphTypeSelect">Select Graph Type:</label>
                    <select id="graphTypeSelect" class="form-control">
                        <option value="Bar">Bar Chart</option>
                        <option value="Bar-stacked">Bar Stacked Chart</option>
                        <option value="Line">Line Chart</option>
                        <option value="Pie">Pie Chart</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="filterColumn">Enter Column Name:</label>
                    <input type="text" id="filterColumn" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitGraphBtn">Select</button>
            </div>
        </div>
    </div>
</div>



@section('script')
<script>
    $(document).ready(function() {
        let graphCounter = 0;

        // Load stored graphs when the page loads
        function loadStoredGraphs() {
            $.ajax({
                url: "{{ route('all/employee/storedgraph/data') }}", // Adjust route as needed
                method: "GET",
                success: function(graphs) {
                    graphs.forEach(graph => {
                        createGraph(graph.graph_type, graph.id, graph.labels, graph.values, graph.filter_column); // Ensure 'filter_column' is passed from the backend
                    });
                },
                error: function(xhr) {
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

            if (!graphType || !filterColumn) {
                alert("Please select a graph type and enter a column name.");
                return;
            }

            // Send selected graph type and filter column to the backend
            $.ajax({
                url: "{{ route('all/employee/graph/data') }}", // Adjust route
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    column: filterColumn,
                    graph_type: graphType
                },
                success: function(data) {
                    if (data.labels.length > 0) {
                        createGraph(graphType, data.graph_id, data.labels, data.values, filterColumn); // Pass filterColumn to createGraph
                        $('#selectGraphModal').modal('hide'); // Close modal
                    } else {
                        alert("No data found for the given column.");
                    }
                },
                error: function(xhr) {
                    console.error("Error fetching graph data:", xhr.responseText);
                }
            });
        });

        // Function to create a graph card dynamically
        function createGraph(graphType, graphId = null, labels = [], values = [], filterColumn) {
            graphCounter++;
            const id = graphId ? `employee-chart-${graphId}` : `employee-chart-${graphCounter}`;
            const title = filterColumn ? `Graph for ${filterColumn}` : `Graph #${graphCounter}`;

            // Create card and wrap it with col-md-6 for responsiveness
            $('#graphsContainer').append(`
                <div class="col-md-6 mt-3" id="card-${id}">
                    <div class="card">
                        <div class="card-body">
                            <!-- Update the card title to display the filterColumn -->
                            <h3 class="card-title">${title}</h3>
                            <div id="${id}" class="graph-container">
                                <div id="${id}-chart"></div>
                            </div>
                            <div class="mt-auto text-right">
                                <a href="javascript:void(0);" class="delete-icon" data-id="${graphId}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            if (labels.length > 0 && values.length > 0) {
                renderGraph(id, labels, values, graphType, filterColumn);
            }
        }

        // Function to render the graph using Morris.js
        function renderGraph(graphId, labels, values, graphType) {
            // Adjusting the chart data structure to match the ykey setup
            const chartData = labels.map((label, index) => ({
                label: label, // This will be the x-axis value
                value: values[index] // This will be the value to plot
            }));

            setTimeout(() => {
                if (graphType.toLowerCase() === "bar") {
                    Morris.Bar({
                        element: `${graphId}-chart`,
                        data: chartData,
                        xkey: 'label', // 'label' as x-axis value
                        ykeys: ['value'], // 'value' is the corresponding data for y-axis
                        labels: ['Count'], // Adjust the label to something appropriate
                        barColors: ['#f43b48', '#453a94'],
                        resize: true,
                        redraw: true
                    });
                } else if (graphType.toLowerCase() === "line") {
                    Morris.Line({
                        element: `${graphId}-chart`,
                        data: chartData,
                        xkey: 'label', // 'label' as x-axis value
                        ykeys: ['value'], // 'value' as the y-axis value
                        labels: ['Count'], // Adjust the label to something appropriate
                        lineColors: ['#f43b48', '#453a94'],
                        resize: true,
                        redraw: true
                    });
                } else if (graphType.toLowerCase() === "pie") {
                    Morris.Donut({
                        element: `${graphId}-chart`,
                        data: chartData,
                        resize: true,
                        redraw: true,
                        colors: ['#f43b48', '#453a94', '#34d399', '#ffb700', '#ff5733'] // Add more colors if needed
                    });
                } else if (graphType.toLowerCase() === "bar-stacked") {
                    Morris.Bar({
                        element: `${graphId}-chart`,
                        data: chartData,
                        xkey: 'label', // 'label' as x-axis value
                        ykeys: ['value'], // 'value' as the y-axis value
                        labels: ['Count'], // Adjust the label to something appropriate
                        barColors: ['#f43b48', '#453a94', '#ffcc00'],
                        stacked: true,
                        resize: true,
                        redraw: true
                    });
                }
            }, 100);
        }

        // Handle Delete Graph Button Click
        $(document).on('click', '.delete-icon', function() {
            const graphId = $(this).data('id');

            if (!graphId) {
                $(this).closest('.card').remove();
                return;
            }

            $.ajax({
                url: "{{ route('all/employee/delete-graph', '') }}" + "/" + graphId,
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    $(`#card-employee-chart-${graphId}`).remove();
                },
                error: function(xhr) {
                    console.error("Error deleting graph:", xhr.responseText);
                }
            });
        });
    });
</script>




@endsection
@endsection
