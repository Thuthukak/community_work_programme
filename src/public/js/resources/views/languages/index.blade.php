@extends('dashboard.master')
@section('title', __('translation.languages'))
@section('main-section')

    <div class="container-fluid">
        <h4 class="page-title">{{ __('translation.languages') }}
            @include('languages.publish-action')
            @if(!count($languages))
                <form id="import-form" method="post" action="{{ route('language.translations.import') }}" style="display: none">
                    {{csrf_field()}}
                    {{ method_field('post') }}
                </form>
                <a href="javascript:void(0)"
                   class="btn btn-warning float-right mr-2" onclick="
                       if(confirm('Are you sure, You want to Import Languages?? If yes old database language table replaced by new.'))
                        {
                            event.preventDefault();
                            document.getElementById('import-form').submit();
                        }
                        else {
                            event.preventDefault();
                        }
                    ">
                    <i class="la la-exclamation"></i>  {{ __('translation.import_translation') }}</i>
                </a>
            @endif
        </h4>
        @include('includes.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('translation.languages') }}
                        @if(count($languages))
                        <a href="{{ route('languages.create') }}" class="btn btn-primary btn-md float-right">
                            <i class="fa fa-plus"></i>  {{ __('translation.add') }}
                        </a>
                        @endif
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th>{{ __('translation.language_name') }}</th>
                                    <th>{{ __('translation.locale') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($languages as $key => $name)
                                    <tr>
                                        <td>
                                            {{ optional($name->laraLanguage)->name }}
                                        </td>
                                        <td>
                                            <a href="{{ route('language.translations.index', $name->locale) }}">
                                                <i class="la la-language"></i> {{ $name->locale }}
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="2" class="text-center">{{ __('theme.no_data_found') }}</td>
                                @endforelse
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection