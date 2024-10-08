@extends('layouts.crm')
@section('title','My OKR')
@section('content')
<div class="container">
<div class="row justify-content-center">
    <div class="col-md-10">
         <h4><a href="{{url()->previous()}}" class="btn btn-primary btn-sm float-right">return</a>
         Modify OKR</h4>
    </div>
    @include('crm.actions.error',[$errors]) 
    <form method="POST" action="{{ route('okr.update',$objective->id) }}">
        @csrf
        {{ method_field('PATCH') }}
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="objective_title">Objective</label>
                <input type="text" class="form-control" name="obj_title" id="objective_title" value="{{ $objective->title }}" required>
            </div>
            <div class="form-group col-md-4">
                <label for="started_at">Starting day</label>
                <input autocomplete="off" class="form-control" name="st_date" id="started_at" value="{{ $objective->started_at }}" required>
                </div>
            <div class="form-group col-md-4">
                <label for="finished_at">Completion date</label>
                <input autocomplete="off" class="form-control" name="fin_date" id="finished_at" value="{{ $objective->finished_at }}" required>
            </div>
        </div>
        
        @foreach($keyresults as $keyresult)
        <div class="form-row mt-4">
            <div class="form-group col-md-12 mt-4">
                <label for="keyresult_title">KeyResult</label>
                <input type="text" class="form-control" name="krs_title{{ $keyresult->id }}" id="keyresult_title" value="{{ $keyresult->title }}">
            </div>
            <div class="form-group col-md-6">
                <label for="keyresult_confidence">Reaching rate</label>
                <input type="text" class="js-range-slider kr-slider" id="keyresult_slider" name="krs_now{{ $keyresult->id }}" value="{{ $keyresult->current_value }}"
                    data-min="{{ $keyresult->initial_value }}"
                    data-max="{{ $keyresult->target_value }}"
                    data-from="{{ $keyresult->current_value }}"
                    data-grid= true 
                />
            </div>
            <div class="form-group col-md-3">
                <label for="keyresult_weight">Weights</label>
                <input type="text" class="js-range-slider" name="krs_weight{{ $keyresult->id }}" value="{{ $keyresult->weight }}"
                    data-min="0.1"
                    data-max="2"
                    data-from="{{ $keyresult->weight }}"
                    data-step="0.1"
                    data-grid= true 
                />
            </div>
            <div class="form-group col-md-3">
                <label for="keyresult_confidence">Confidence</label>
                <input type="text" class="js-range-slider" name="krs_conf{{ $keyresult->id }}" value="{{ $keyresult->confidence }}"
                    data-min="0"
                    data-max="10"
                    data-from="{{ $keyresult->confidence }}"
                    data-step="1" 
                    data-grid= true 
                />
            </div>
            <div class="form-group col-md-2">
                <label for="keyresult_initaial">Start value</label>
                <input type="number" class="form-control kr-init" name="krs_init{{ $keyresult->id }}" id="keyresult_initaial" value="{{ $keyresult->initial_value }}">
            </div>
            <div class="form-group col-md-2">
                <label class="text-primary" for="keyresult_target">The current value</label>
                <input type="number" class="form-control kr-now" name="krs_now{{ $keyresult->id }}" id="keyresult_now" value="{{ $keyresult->current_value }}">
            </div>
            <div class="form-group col-md-2">
                <label for="keyresult_target">Target value</label>
                <input type="number" class="form-control kr-target" name="krs_tar{{ $keyresult->id }}" id="keyresult_target" value="{{ $keyresult->target_value }}">
            </div>
        </div>
        @endforeach
        <button class="btn btn-primary btn-sm col-md-12 mt-3" type="submit">Modify</button>  
    </form>
    @foreach ($keyresults as $keyresult)
        <form method="POST" id="deleteKR{{ $keyresult->id }}" action="{{ route('kr.destroy', $keyresult->id) }}">
            @csrf
            {{ method_field('DELETE') }}
        </form>
    @endforeach
</div>
@endsection

