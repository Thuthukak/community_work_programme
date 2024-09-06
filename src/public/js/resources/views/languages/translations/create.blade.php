@extends('dashboard.master')
@section('title', __('translation.translations'))

@section('main-section')
    <div class="container-fluid">
        <h4 class="page-title">{{ __('translation.translations') }}
            @include('languages.publish-action')
        </h4>
        @include('includes.flash')

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    {{ __('translation.add_translation') }}
                        <a href="{{ route('language.translations.index', $language) }}" class="ml-2 btn btn-dark btn-sm pull-right">{{ __('translation.back') }}</a>

                    </div>
                    <div class="card-body">
                        <form action="{{ route('language.translations.store', $language) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="key">Key</label>
                                <input type="text" name="key" class="form-control">
                                @if ($errors->has('key'))
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('key') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="key">Value</label>
                                <input type="text" name="value" class="form-control">
                                @if ($errors->has('value'))
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('value') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary">
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