
<div class="container-fluid">
        <a href="#" class="btn btn-primary btn-md float-right" data-toggle="modal" data-target="#addNew">
            <i class="fa fa-plus"></i> {{ __('theme.add_new') }}
        </a>
    </h4>
    <div class="row">
        <div class="col-md-4">
            <div class="mb-4">
                <div class="card-body">
                    <form action="{{ route('setting.testimonialUpdate') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="testimonial_title"><strong>{{ __('theme.title') }}</strong></label>
                                <input class="form-control mb-3 {{ $errors->has('testimonial_title') ? ' is-invalid' : '' }}" name="testimonial_title" value=""  type="text" required>
                                <input class="form-control mb-3" name="id" value=""  type="hidden">
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
                                <textarea class="form-control" id="join_us_details" rows="2" name="testimonial_details"></textarea>
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
                        </tbody>
                    </table>
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
</div>
