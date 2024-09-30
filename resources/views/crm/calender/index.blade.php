@extends('layouts.crm')
@section('title','個人行事曆')

@section('script')
<!-- Moment.js v2.23.0 -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.23.0/moment.min.js" defer></script>
<!-- FullCalendar v3.10.0 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js" defer></script>
<!-- FullCalendar.js -->
<script src="{{ asset('js/calendar.js') }}" defer></script>
@endsection

@section('stylesheet')
<!-- FullCalendar v3.10.0 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.print.css" rel="stylesheet" media="print">
@endsection

@section('content')
<div class="container">
    <div classs="row">
        @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(Session::has('success'))
        <div>
            <p>{{Session::get('success')}}</p>
        </div>
        @endif
    </div>
    <select class="btn btn-primary mb-2" id="school_selector">
        <option class="btn-light" value="all">All</option>
        <option class="btn-light" value="1">Objective</option>
        <option class="btn-light" value="2">Action</option>
        <option class="btn-light" value="3">Activity</option>
    </select>
    <button id="copyBT" class="btn btn-secondary mb-2 btn-sm">Copy the ical calendar website</button>
    <a id="icalcontent" href="{{route('calendar.ical')}}">{{route('calendar.ical')}}</a>
   
    <div id="calendar" data-uid="{{auth()->user()->id}}"></div>
    <form action="{{route('calendar.create', auth()->user()->id) }}" method="post">
        @csrf
        <div class="modal fade" tabindex="-1" role="dialog" id="mdlEvent">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New itinerary</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-md-12">
                            <label for="title">content</label>
                            <input type="text" class="form-control" name="title" id="title" placehoder="Input stroke" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="started_at">Starting day</label>
                            <input autocomplete="off" class="form-control" name="st_date" id="started_at">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="st_time">Start time</label>
                            <input type="time" class="form-control" name="st_time" id="st_time">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="finished_at">Completion date</label>
                            <input autocomplete="off" class="form-control" name="fin_date" id="finished_at">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="fin_time">Completion time</label>
                            <input type="time" class="form-control" name="fin_time" id="fin_time">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="color">choose the color</label>
                            <input type="color" class="form-control" name="color" id="color" placehoder="choose the color" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary " type="submit" name="submit">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
