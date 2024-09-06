@inject('permission', 'App\Http\Controllers\PermissionController')
@extends('dashboard.master')
@section('title', __('theme.how_we_work_setting'))

@section('main-section')
<div class="container-fluid">
    @if($permission->manageHowWork() == 1)
    <h4 class="mb-4">{{ __('theme.how_we_work_setting') }}</h4>
    @include('includes.flash')
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('setting.howWorkUpdate') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="how_work_title"><strong>{{ __('theme.how_work_title') }}</strong></label>
                                <input class="form-control form-control-lg mb-3 {{ $errors->has('how_work_title') ? ' is-invalid' : '' }}" name="how_work_title" value="{{ $setting->how_work_title ?? old('how_work_title') }}"  type="text" required>
                                <input class="form-control form-control-lg mb-3" name="id" value="{{ $setting->id }}"  type="hidden">
                                @if ($errors->has('how_work_title'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('how_work_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="how_work_details"><strong>{{ __('theme.how_work_details') }}</strong></label>
                                <textarea class="form-control" id="how_work_details" rows="2" name="how_work_details" required>{{ $setting->how_work_details ?? old('how_work_details') }}</textarea>
                                @if ($errors->has('how_work_details'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('how_work_details') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('theme.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="page-title">{{ __('theme.how_we_work') }}</div>
                </div>
                <div class="card-body table-responsive">
                    <table id="testimonialTable" class="table table-sm table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('theme.sl_no') }}</th>
                                <th>{{ __('theme.name') }}</th>
                                <th>{{ __('theme.icon') }}</th>
                                <th>{{ __('theme.details') }}</th>
                                <th>{{ __('theme.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($works as $key=>$work)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $work->title }}</td>
                                <td><i class="{{ $work->icon }}"></i></td>
                                <td>
                                    {!! str_limit(clean($work->details), 15,'') !!}
                                    @if(str_word_count(clean($work->details)) > 5)
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#commentDetails{{ $work->id }}" title="View Details">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <div class="modal fade" id="commentDetails{{ $work->id }}" role="dialog" aria-labelledby="#commentDetails" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">&nbsp; {{ __('theme.how_work_details') }} </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>{!! clean($work->details) !!}</strong></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('theme.close') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                                <td class="d-flex">
                                    <button type="button" class="btn btn-primary btn-sm mr-1" data-toggle="modal" data-target="#editService{{ $work->id }}" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <div class="modal fade" id="editService{{ $work->id }}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="editServiceModalLabel"><i class="fa fa-share-square"></i> {{ __("theme.edit_how_work") }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <form method="POST" action="{{ route('how-we-work.update',$work->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <div class="col-md-12 mb-2">
                                                                    <label for="title" class="float-left ml-0">
                                                                    <strong>{{ __('theme.title') }} :</strong>
                                                                </label>
                                                                    <input type="text" class="form-control has-error bold " id="name" name="title" value="{{ $work->title ?? old('title') }}" placeholder="{{ __('theme.how_work_title') }}">
                                                                </div>

                                                                <label for="icon" class="ml-3">
                                                                    <strong>{{ __('theme.icon_code') }} :</strong>
                                                                </label>
                                                                <div class="col-md-12 mb-2">
                                                                    <input type="text" class="form-control has-error bold demo" id="icon" value="{{ $work->icon ?? old('icon') }}" name="icon" placeholder="Enter Fontawesome icon like fa fa-facebook">
                                                                    <small class="text-danger"><strong>{{ __('theme.for_fontawesome_code_visit') }} : https://fontawesome.com/v4.7.0/icons/</strong><br>
                                                                        {{ __('theme.enter_fontawesome_icon_like') }} fa fa-facebook
                                                                    </small>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <label for="details" class="float-left ml-0"><strong>{{ __('theme.details') }} :</strong>
                                                                </label>
                                                                    <textarea class="form-control" id="details" rows="2" name="details">{{ $work->details ?? old('details') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('theme.close') }}</button>
                                                        <button type="submit" class="btn btn-primary bold uppercase"><i class="fas fa-arrow-alt-circle-up"></i> {{ __('theme.update_how_work') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>                 
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $works->links() }}
                </div>
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
