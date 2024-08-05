@php
    // Because I need to identify which KR's error is on which O, but I don't know how to write it into $errors
    $isError = false;
    if(count($errors) > 0) {
        $isError = $okr['objective']->id == $errors->first('krs_owner');
    }
@endphp
<!-- +KR form on Objective card in okr.blade -->
<a class="btn btn-success btn-sm ml-2 mb-3 mt-3" data-toggle="collapse" href="#collapse{{ $okr['objective']->id }}" role="button" aria-expanded="false" aria-controls="collapse{{ $okr['objective']->id }}">
     <i class="fa fa-plus fa-sm"></i> KR
</a>

<div class="collapse {{ $isError ? 'show' : '' }}" id="collapse{{ $okr['objective']->id }}">
    <div class="card card-body mr-md-5">
        <form method="POST" action="{{ route('kr.store') }}">
                @csrf
            <div class="form-row">
                <input type="hidden" class="form-control" name="krs_owner" id="keyresult_owner" value="{{ $okr['objective']->id }}">
                <div class="form-group col-md-12">
                    <label for="keyresult_title"> Key Performance Indicator (KeyResult) <strong class="text-danger">{{ $isError ? $errors->first('krs_title') : '' }}</strong></label>
                    <input type="text" class="form-control" name="krs_title" id="keyresult_title" value="{{ old('krs_title') }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="keyresult_confidence"> Achievement Rate <strong class="text-danger">{{ $isError ? $errors->first('krs_now') : '' }}</strong></label>
                    <input type="number" class="form-control" id="keyresult_confidence" name="krs_now" value="{{ old('krs_now') ? old('krs_now') : '0' }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="keyresult_weight">Weight <strong class="text-danger">{{ $isError ? $errors->first('krs_weight') : '' }}</strong></label>
                    <input type="number" class="form-control" name="krs_weight" value="{{ old('krs_weight') ? old('krs_weight') : '1' }}" step="0.1" min="0.1" max="2">
                </div>
                <div class="form-group col-md-3">
                    <label for="keyresult_confidence_level">Confidence Level <strong class="text-danger">{{ $isError ? $errors->first('krs_conf') : '' }}</strong></label>
                    <input type="number" class="form-control" name="krs_conf" value="{{ old('krs_conf') ? old('krs_conf') : '5' }}" step="1" min="0" max="10">
                </div>
                <div class="form-group col-md-2">
                    <label for="keyresult_initial">Initial Value <strong class="text-danger">{{ $isError ? $errors->first('krs_init') : '' }}</strong></label>
                    <input type="number" class="form-control" name="krs_init" id="keyresult_initial" value="{{ old('krs_init') ? old('krs_init') : '0' }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="keyresult_now">Current Value <strong class="text-danger">{{ $isError ? $errors->first('krs_now') : '' }}</strong></label>
                    <input type="number" class="form-control" name="krs_now" id="keyresult_now" value="{{ old('krs_now') ? old('krs_now') : '0' }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="keyresult_target">Target Value <strong class="text-danger">{{ $isError ? $errors->first('krs_tar') : '' }}</strong></label>
                    <input type="number" class="form-control" name="krs_tar" id="keyresult_target" value="{{ old('krs_tar') ? old('krs_tar') : '100' }}">
                </div>
                <div class="form-group col-md-6 u-text-right">
                    <button class="btn btn-primary u-mt-16" type="submit" style="width:100px;">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>
