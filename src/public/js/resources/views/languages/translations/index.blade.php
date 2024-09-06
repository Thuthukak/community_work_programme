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
                        {{ __('translation.translations') }} - <strong>{{ $lang->name }}</strong>
                        <div class="pull-right d-flex mr-2">
                            <form action="{{ route('language.translations.index', request()->language) }}">
                                <input type="search" name="search" value="{{ request()->search }}" class="form-control" placeholder="Search">
                            </form>
                            <a href="{{ route('language.translations.create', request()->language) }}" class="ml-2 btn btn-primary btn-sm pull-right">{{ __('translation.add') }}</a>
                            <a href="{{ route('languages.index') }}" class="ml-2 btn btn-dark btn-sm pull-right">{{ __('translation.back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <th width="50">{{ __('translation.key') }}</th>
                                <th class="w-25">EN</th>
                                <th>{{ __('translation.value') }}</th>
                                <th class="text-right" width="60">{{ __('translation.action') }}</th>
                                </thead>
                                <tbody>
                                @foreach($translations as $translation)
                                <tr>
                                    <td>{{ $translation->group }}.{{ $translation->key }} @if(request()->search) ({{ $translation->locale }}) @endif</td>
                                    <td>{{ $translation->getEnLanguage($translation->key) }}</td>
                                    <td>
                                        <textarea class="form-control" id="{{ $translation->key }}-{{$translation->id}}">{{ $translation->value }}</textarea>
                                    </td>
                                    <td class="text-right">
                                        <a href="javascript:void(0)" class="badge badge-primary" onclick="updateLanguageValue(`{{ $translation->key }}`, `{{ $translation->id }}`)">
                                            <i class="la la-language"></i> {{ __('translation.update') }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $translations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection