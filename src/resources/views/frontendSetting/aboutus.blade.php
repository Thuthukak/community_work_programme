
<div class="container-fluid">
    <div class="mb-4">
        <div class="card-body">
            <form action="{{ route('updateAboutUs.Setting') }}" method="post" enctype="multipart/form-data" onsubmit="submitForm(event, this)">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="aboutus_title text-uppercase"><strong>{{ __('theme.about_us_title') }}</strong></label>
                                    <input id="aboutus_title" class="form-control mb-3 {{ $errors->has('aboutus_title') ? ' is-invalid' : '' }}" name="aboutus_title" value=""  type="text" required>
                                    <input class="form-control mb-3" name="id" value=""  type="hidden">
                                    @if ($errors->has('aboutus_title'))
                                        <span class="invalid-feedback d-block">
                                            <strong>{{ $errors->first('aboutus_title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>    
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="aboutus_details strong"><strong>{{ __('theme.about_us_details') }}</strong></label>
                                    <textarea class="form-control {{ $errors->has('aboutus_title') ? ' is-invalid' : '' }}" id="aboutus_details" rows="8" name="aboutus_details" required></textarea>
                                    @if ($errors->has('aboutus_details'))
                                        <span class="invalid-feedback d-block">
                                            <strong>{{ $errors->first('aboutus_details') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>    
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="aboutus_image"><strong>{{ __('theme.about_us_image') }}</strong></label>
                            <input id="aboutus_image" class="form-control mb-3" type="file" name="aboutus_image">
                            <small class="text-danger">{{ __('theme.image_will_be_resize_at') }} 530*482 [{{ __('theme.image_format') }}: JPG,JPEG]</small>
                        </div>
                        <img class="thumbnail img-thumbnail" src="{{asset('images/bg/about_details.jpg')}}"/>
                    </div>
                </div>
                <div class="col-md-12 my-4">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('theme.update') }}</button>
                </div>
            </form>
        </div>
    </div>

</div>
