@extends('layouts.master')
@section('content')
<style>
    #calendar {
        max-width: 100%;
        margin: 0 auto;
    }

    .fc {
        background-color: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 20px;
    }

    .fc .fc-toolbar-title {
        font-size: 1.8rem;
        color: #0d6efd;
        font-weight: 600;
    }

    .fc-button {
        background-color: #0d6efd !important;
        border: none !important;
        border-radius: 4px !important;
        padding: 6px 12px !important;
    }

    .fc-button:hover {
        background-color: #0b5ed7 !important;
    }

    .fc-daygrid-event {
        background-color: rgb(255, 255, 255) !important;
        color: #000 !important;
        border-radius: 4px !important;
        padding: 4px;
        font-size: 0.85rem;
        border: none !important;
        /* Ensure no border */
    }


    .fc-daygrid-day-number {
        font-weight: 600;
        color: #333;
    }

    .fc-col-header-cell-cushion {
        font-weight: bold;
        font-size: 0.95rem;
    }

    /* Custom SweetAlert2 Popup Styles */
    /* Custom Dark SweetAlert2 Popup Styles */
    .popup-dark {
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .title-dark {
        font-size: 1.6rem;
        color: rgb(255, 255, 255);
        font-weight: 700;
        text-align: center;
    }

    .content-dark {
        font-size: 1.2rem;
        color: rgb(255, 255, 255);
        text-align: center;
    }

    .confirm-dark {
        background-color: rgb(255, 255, 255) !important;
        /* Soft green button */
        color: rgb(0, 0, 0) !important;
        /* White text */
        font-weight: 600;
        border-radius: 4px;
        padding: 10px 20px;
        border: none;
        font-size: 1rem;
    }

    .confirm-dark:hover {
        background-color: rgb(1, 42, 88);
        cursor: pointer;
    }

    .swal2-popup {
        color: #ffffff !important;
        /* Apply white color to all content */
    }

    .fc-daygrid-event .event-title {
        font-size: 0.9 rem !important;
        /* Smaller event title on mobile */
    }

    @media (max-width: 767px) {

        /* Adjust the title font size */
        .fc .fc-toolbar-title {
            font-size: 1.4rem;
            /* Slightly smaller title */
        }

        /* Adjust button size */
        .fc-button {
            padding: 4px 8px !important;
            font-size: 0.75rem !important;
            /* Smaller buttons on mobile */
        }

        /* Adjust event font size */
        .fc-daygrid-event {
            font-size: 0.75rem !important;
            /* Smaller text for events */
            padding: 2px !important;
            /* Reduced padding */
        }

        /* Adjust column headers for smaller screens */
        .fc-col-header-cell-cushion {
            font-size: 0.85rem !important;
            /* Smaller column header text */
        }

        /* Adjust event title font size for mobile */
        .fc-daygrid-event .event-title {
            font-size: 0.5rem !important;
            /* Smaller event title on mobile */
        }
    }

    /* Further adjustments for very small screens (e.g., phones in portrait mode) */
    @media (max-width: 480px) {

        /* Further reduce the font sizes */
        .fc .fc-toolbar-title {
            font-size: 1.2rem;
        }

        /* Adjust the holiday event font size further */
        .fc-daygrid-event {
            font-size: 0.65rem !important;
            /* Even smaller text for events */
            padding: 1px !important;
            /* Further reduce padding */
        }

        /* Adjust event title font size for small screens */
        .fc-daygrid-event .event-title {
            font-size: 0.30rem !important;
            /* Even smaller event title */
        }

        .fc-button {
            padding: 3px 6px !important;
            font-size: 0.65rem !important;
        }
    }

</style>
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Calendar <span id="year"></span></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Calendar</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @include('sidebar.sidebarleave')
            </div>
        </div>
        <!-- Leave Statistics -->

        <div class="row">
            <div class="container mt-5">
                <div class="card shadow rounded-4">
                    <div class="card-body">
                        <h4 class="mb-4 text-center text-primary">Holiday Calendar</h4>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /Leave Statistics -->
    </div>
    <!-- /Page Content -->


</div>
<!-- /Page Wrapper -->
@section('script')

<!--Calendar-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        var events = @json($formattedHolidays);

        // List of Bootstrap background color classes
        var bootstrapColors = [
            'bg-primary'
            , 'bg-secondary'
            , 'bg-success'
            , 'bg-danger'
            , 'bg-warning'
            , 'bg-info'
        ];

        // Randomly select a Bootstrap color class
        function getRandomBootstrapColor() {
            return bootstrapColors[Math.floor(Math.random() * bootstrapColors.length)];
        }

        // For each event, assign a random Bootstrap color if no color exists
        events.forEach(function(event) {
            event.backgroundColor = event.color || getRandomBootstrapColor(); // Assign random color if no color
        });

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
            , events: events
            , eventClick: function(info) {
                const formattedDate = info.event.start.toLocaleDateString('en-GB', {
                    year: 'numeric'
                    , month: 'short'
                    , day: 'numeric'
                });

                Swal.fire({
                    title: info.event.title
                    , text: 'This is a holiday on ' + formattedDate
                    , icon: 'info'
                    , confirmButtonText: 'Got it!'
                    , background: '#2a52be'
                    , iconColor: '#3498db'
                    , confirmButtonColor: '#1abc9c'
                    , customClass: {
                        popup: 'popup-dark'
                        , title: 'title-dark'
                        , content: 'content-dark'
                        , confirmButton: 'confirm-dark'
                    , }
                });
            }
            , eventContent: function(info) {
                // FullCalendar 5+ returns a DOM node in eventContent (not in domNodes)
                var eventElement = document.createElement('div');
                eventElement.innerHTML = `<span class="event-title">${info.event.title}</span>`;

                // Apply Bootstrap color class to the event
                var eventColorClass = info.event.backgroundColor || 'bg-primary'; // Fallback to primary if undefined
                eventElement.classList.add(eventColorClass); // Add Bootstrap color class

                // Set the border color to match the background color
                var eventBackgroundColor = window.getComputedStyle(eventElement).backgroundColor; // Get the background color

                // Apply additional custom styles (no border)
                eventElement.style.color = '#000'; // Text color
                eventElement.style.padding = '4px';
                eventElement.style.fontSize = '0.85rem';
                eventElement.style.borderRadius = '4px'; // Optional border-radius for rounded corners

                // Return the modified event element wrapped in an array (FullCalendar 5+)
                return {
                    domNodes: [eventElement]
                };
            }
        });

        calendar.render();
    });

</script>




@endsection
@endsection
