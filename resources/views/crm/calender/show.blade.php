@extends('layouts.crm')
@section('title','個人行程')
@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col-md-12">
            <h5> <a href="{{ route('calendar.index') }}" class="btn btn-primary">return</a> Modify the itinerary </h5>
        </div>
    </div>
    <form action="{{route('calendar.update', $activity->id) }}" method="post">
        @csrf
        {{ method_field('PATCH') }}
        <div class="row">
            <div class="form-group col-md-8">
                <label for="title">journey</label>
                <input type="text" class="form-control" name="title" id="title" placehoder="Enter itinerary" required value="{{$activity->title}}">
            </div>
            <div class="form-group col-md-4">
                <label for="color">choose the color</label>
                <input type="color" class="form-control" name="color" id="color" placehoder="Color choice" required value="{{$activity->color}}">
            </div>
        </div>
        <div class="row mb-2">
            <div class="form-group col-md-3">
                <label for="started_at">Starting day</label>
                <input class="form-control" name="st_date" id="started_at" value="{{str_split($activity->started_at,11)[0]}}">
            </div>
            <div class="form-group col-md-3">
                <label for="fin_time">End Time</label>
                <input type="time" class="form-control" name="st_time" id="st_time" value="{{str_split($activity->started_at,11)[1]}}">
            </div>
            <div class="form-group col-md-3">
                <label for="finished_at">Completion date</label>
                <input class="form-control" name="fin_date" id="finished_at" value="{{$activity->finished_at ? str_split($activity->finished_at,11)[0]:''}}">
            </div>
            <div class="form-group col-md-3">
                <label for="fin_time">Completion time</label>
                <input type="time" class="form-control" name="fin_time" id="fin_time" value="{{$activity->finished_at ? str_split($activity->finished_at,11)[1]:''}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <button class="btn btn-primary " type="submit" name="submit">Modify</button>
                <a href="#" class="btn btn-danger " onclick="document.getElementById('activityDelete').submit()"
                    data-toggle="tooltip" data-placement="bottom">delete</a>
            </div>
        </div>
    </form>

    <form method="POST" id="activityDelete" action="{{ route('calendar.destroy', $activity) }}">
        @csrf
        {{ method_field('DELETE') }}
    </form>
</div>
@endsection
