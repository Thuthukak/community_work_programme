@extends('dashboard.master')
@inject('permission', 'App\Http\Controllers\PermissionController')
@section('title', __('theme.add_new_knowledge_base'))

@section('style')
    
@stop
@section('title', __('theme.add_new_knowledge_base'))

@section('main-section')
    <div class="container-fluid">
        @if($permission->manageKB() == 1)
        <h4 class="page-title">{{ __('theme.add_new_knowledge_base') }}
            <a href="{{ route('knowledge-base.index') }}" class="btn btn-primary btn-md pull-right">{{ __('theme.back') }}</a>
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @include('includes.flash')
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" class="" method="POST" action="{{ route('kb.store') }}">
                        {!! csrf_field() !!}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Department</label>
                                <select id="department" type="text" class="form-control" name="department" required>
                                    <option> {{ __('theme.select_department') }}</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department') == $department->id ? 'selected' : '' }}>{{ $department->title }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('department'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('department') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="title">{{ __('theme.title') }}</label>
                                <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" placeholder="{{ __('theme.enter_title') }}">

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="description">{{ __('theme.description') }}</label>
                                <div class="box-body pad">
                                <textarea class="kb-desc textarea my-editor {{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" id="description" placeholder="{{ __('theme.place_of_description') }}">{{ old('content') }}</textarea>
                                @if ($errors->has('content'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title">Status</label><br>
                                <div class="form-check-inline">
                                    <label class="customradio"><span class="radiotextsty">{{ __('theme.published') }}</span>
                                      <input type="radio" checked="checked" name="status" value="1" required>
                                      <span class="checkmark"></span>
                                    </label>        
                                    <label class="customradio"><span class="radiotextsty">{{ __('theme.unpublished') }}</span>
                                      <input type="radio" name="status" value="0" required>
                                      <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('theme.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @else
            <div class="callout callout-warning">
                <h4>{{ __('theme.access_denied') }}</h4>

                <p>{{ __("theme.don't_have_permission") }}</p>
            </div>
        @endif
    </div>

@endsection

@section('js')
    <script src="{{asset('src/public/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('tinymce/script.js')}}"></script>
@stop
