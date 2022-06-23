@push('styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endpush
@extends('layouts.master')
@section('title','Dashboard')
@section('content')
<section class="content">

    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-4">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$teachers}}</h3>
                        <p>Teacher Account</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fas fa"></i></a>
                </div>
            </div>

            <div class="col-lg-4">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$parents}}<sup style="font-size: 20px"></sup></h3>
                        <p>Parent Account</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-alt"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fas fa"></i></a>
                </div>
            </div>

            <div class="col-lg-4">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$students}}</h3>
                        <p>Students Registered</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fas fa"></i></a>
                </div>
            </div>

        </div>

    </div>
    @endif

    <div class="card">
        <h5 class="card-header bg-info">Calendar</h5>
        <div class="container-fluid">
            <div class="container">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</section>


<script>
    $(document).ready(function () {

        const SITEURL = "{{ url('/') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const calendar = $('#calendar').fullCalendar({
            events: SITEURL + "/calender",
            displayEventTime: false,
            editable: {{ auth()->user()->hasRole('admin') ? 'true' : 'false' }},
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            @if(auth()->user()->hasRole('admin'))
            select: function (start, end, allDay) {
                var title = prompt('Event Title:');
                if (title) {
                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                    $.ajax({
                        url: SITEURL + "/calender",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            type: 'add'
                        },
                        type: "POST",
                        success: function (data) {
                            displayMessage("Event Created Successfully");

                            calendar.fullCalendar('renderEvent',
                                {
                                    id: data.id,
                                    title: title,
                                    start: start,
                                    end: end,
                                    allDay: allDay
                                },true);

                            calendar.fullCalendar('unselect');
                        }
                    });
                }
            },
            eventResize: function (event, delta) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");

                $.ajax({
                    url: SITEURL + '/calender',
                    data: {
                        title: event.title,
                        start: start,
                        end: end,
                        id: event.id,
                        type: 'update'
                    },
                    type: "POST",
                    success: function (response) {
                        displayMessage("Event Updated Successfully");
                    }
                });
            },
            eventDrop: function (event, delta) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");

                $.ajax({
                    url: SITEURL + '/calender',
                    data: {
                        title: event.title,
                        start: start,
                        end: end,
                        id: event.id,
                        type: 'update'
                    },
                    type: "POST",
                    success: function (response) {
                        displayMessage("Event Updated Successfully");
                    }
                });
            },
            eventClick: function (event) {
                var deleteMsg = confirm("Do you really want to delete?");
                if (deleteMsg) {
                    $.ajax({
                        type: "POST",
                        url: SITEURL + '/calender',
                        data: {
                            id: event.id,
                            type: 'delete'
                        },
                        success: function (response) {
                            calendar.fullCalendar('removeEvents', event.id);
                            displayMessage("Event Deleted Successfully");
                        }
                    });
                }
            }
            @endif
        });

    });

    function displayMessage(message) {
        toastr.success(message, 'Event');
    }
</script>
@endsection
