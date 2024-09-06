@extends('dashboard.master')
@section('title', __('translation.add_language'))
@section('main-section')

    <div class="container-fluid">
        <h4 class="page-title">{{ __('translation.add_language') }}</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('translation.add_language') }}
                        <a href="{{ route('languages.index') }}" class="btn btn-dark btn-sm pull-right">{{ __('translation.back') }}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('languages.store') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="mb-3">
                                <label>{{ __('translation.language_name') }}</label>
                                <select name="language_name" class="form-control" required>
                                    <option value="">{{ __('theme.select_once') }}</option>
                                    @foreach($languages as $language)
                                        <option value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('translation.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection