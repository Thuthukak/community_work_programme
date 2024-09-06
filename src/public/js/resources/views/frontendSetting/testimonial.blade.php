@inject('permission', 'App\Http\Controllers\PermissionController')
@extends('dashboard.master')
@section('title', __('theme.testimonial_setting'))

@section('main-section')
<div class="container-fluid">
    @if($permission->manageTestimonial() == 1)
    <h4 class="page-title">{{ __('theme.testimonial_setting') }}
        <a href="#" class="btn btn-primary btn-md float-right" data-toggle="modal" data-target="#addNew">
            <i class="fa fa-plus"></i> {{ __('theme.add_new') }}
        </a>
    </h4>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('setting.testimonialUpdate') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="testimonial_title"><strong>{{ __('theme.title') }}</strong></label>
                                <input class="form-control mb-3 {{ $errors->has('testimonial_title') ? ' is-invalid' : '' }}" name="testimonial_title" value="{{ $setting->testimonial_title ?? old('testimonial_title') }}"  type="text" required>
                                <input class="form-control mb-3" name="id" value="{{ $setting->id }}"  type="hidden">
                                @if ($errors->has('testimonial_title'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('testimonial_title') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="testimonial_details"><strong>{{ __('theme.details') }}</strong></label>
                                <textarea class="form-control" id="join_us_details" rows="2" name="testimonial_details">{{ $setting->testimonial_details ?? old('testimonial_details') }}</textarea>
                                @if ($errors->has('testimonial_details'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('testimonial_details') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block text-uppercase">{{ __('theme.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="page-title">{{ __('theme.testimonials') }}</div>
                </div>
                <div class="card-body table-responsive">
                    <table id="testimonialTable" class="table table-sm table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('theme.sl_no') }}</th>
                                <th>{{ __('theme.name') }}</th>
                                <th>{{ __('theme.image') }}</th>
                                <th>{{ __('theme.comment') }}</th>
                                <th>{{ __('theme.role') }}</th>
                                <th>{{ __('theme.role') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $key=>$testimonial)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $testimonial->name }}</td>
                                <td>
                                    <img class="thumbnail img-responsive img-thumbnail w-50" src="@if($testimonial->image){{ asset(symImagePath().$testimonial->image) }} @else {{ asset($publicPath.'/testimonials/testimonial.png') }} @endif"/>
                                </td>
                                <td>
                                    {!! str_limit(clean($testimonial->comment), 15) !!}
                                    @if(str_word_count($testimonial->comment) > 5)
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#commentDetails{{ $testimonial->id }}" title="Details">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <div class="modal fade" id="commentDetails{{ $testimonial->id }}" role="dialog" aria-labelledby="#commentDetails" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-uppercase">&nbsp; {{ __('theme.comment_details') }} </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>{!! clean($testimonial->comment) !!}</strong></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                                <td>{{ $testimonial->designation ?? 'No Information' }}</td>
                                <td class="d-flex">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editTestimonial{{ $testimonial->id }}" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <div class="modal fade" id="editTestimonial{{ $testimonial->id }}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editTestimonialModalLabel"><i class="fa fa-share-square"></i> {{ __('theme.edit_testimonial') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <form method="POST" action="{{ route('testimonial.update',$testimonial->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group mt-0">
                                                            <label for="image" class="ml-3 mb-2"><strong>Image :</strong> </label>
                                                            <div class="col-sm-12 mb-2">
                                                                <input type="file" class="form-control has-error bold " id="image" name="image">
                                                                <div>
                                                                <small class="text-danger">{{ __('theme.image_will_be_resize_at') }} 352*352 [Image format: JPG,JPEG]</small>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 mb-2">
                                                                @if($testimonial->image)
                                                                    <img class="thumbnail img-responsive img-thumbnail w-25" src="@if($testimonial->image){{ asset(symImagePath().$testimonial->image) }} @else {{ asset($publicPath.'/testimonials/testimonial.png') }} @endif"/>
                                                                @endif
                                                            </div>
                                                        
                                                            <label for="name" class="ml-3 mb-2"><strong>{{ __('theme.name') }} :</strong> </label>
                                                            <div class="col-sm-12 mb-2">
                                                                <input id="name" type="text" name="name" value="{{ $testimonial->name ?? old('name') }}" class="form-control" required="">
                                                            </div>
                                                        
                                                            <label for="designation" class="ml-3 mb-2"><strong>{{ __('theme.designation') }} :</strong></label>
                                                            <div class="col-md-12 mb-2">
                                                                <input id="designation" type="text" class="form-control has-error bold" value="{{ $testimonial->designation ?? old('designation') }}" name="designation" placeholder="Designation [ Optional ]" required>
                                                            </div>
                                                        
                                                            <label for="comment" class="ml-3"><strong>{{ __('theme.comment') }} :</strong> </label>
                                                            <div class="col-md-12">
                                                                <textarea class="form-control w-100" id="comment" rows="3" name="comment" required>{{ $testimonial->comment ?? old('comment') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('theme.close') }}</button>
                                                        <button type="submit" class="btn btn-primary bold uppercase"><i class="fas fa-arrow-alt-circle-up"></i> {{ __('theme.update') }}</button>
                                                    </div>
                                                </form>
                                            </div>   
                                        </div>
                                    </div> 

                                    <button type="button" class="btn btn-danger btn-sm delete_button" data-toggle="modal" data-target="#delete{{ $testimonial->id }}" title="DELETE">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="modal fade" id="delete{{ $testimonial->id }}" role="dialog" aria-labelledby="#delete{{ $testimonial->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form method="POST" action="{{ route('testimonial.destroy',$testimonial->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="delete"><i class="fa fa-trash"></i>&nbsp;{{ __('theme.delete') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>{{ __('theme.are_you_sure_you_want_to_delete') }}</strong></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('theme.no') }}</button>
                                                        <button type="submit" class="btn btn-danger">{{ __('theme.delete') }}</button>
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
                    {{ $testimonials->links() }}
                </div>
            </div>
        </div>
    </div>
        <!-- add new modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-share-square"></i> {{ __('theme.add_new_testimonial') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <form method="POST" action="{{ route('testimonial.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="image" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.image') }} :</strong> </label>
                                <div class="col-sm-12">
                                    <input type="file" class="form-control has-error bold " id="image" name="image">
                                    <small class="text-danger h6">{{ __('theme.image_will_be_resize_at') }} 352*352 [Image format: JPG,JPEG]</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.name') }} :</strong> </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control has-error bold " id="name" name="name" placeholder="Full name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="designation" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.designation') }} :</strong></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control has-error bold " id="designation" name="designation" placeholder="Designation [ Optional ]" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="comment" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.comment') }} :</strong> </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control has-error bold " id="comment" name="comment" placeholder="Comment" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('theme.close') }}</button>
                            <button type="submit" class="btn btn-primary bold uppercase"><i class="fas fa-arrow-alt-circle-up"></i> {{ __('theme.save_testimonial') }}</button>
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