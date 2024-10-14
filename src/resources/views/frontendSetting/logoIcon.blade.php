<div class="container-fluid">
    <div class="mb-4">
        <div class="card-body">
            <form action="{{ route('logoIconUpdate.Setting') }}" method="post" enctype="multipart/form-data" onsubmit="submitForm(event, this)">
                @csrf
                @method('PUT')
                
                <div class="row container-fluid">
                    <!-- Logo Input -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo">{{ __('theme.logo') }}</label>
                            <input id="logo" class="form-control mb-3" type="file" name="logo" accept="image/png" onchange="previewImage(event, 'logoPreview')">
                            @if ($errors->has('logo'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('logo') }}</strong>
                                </span>
                            @endif
                            <small class="text-danger">[{{ __('theme.image_format') }}: PNG]</small>
                        </div>

                       
                        <!-- Display current logo and preview of the uploaded image -->
                        <img id="logoPreview" class="thumbnail img-responsive" src="{{ isset($settings['company_logo']) ? asset('src/' . $settings['company_logo']) : '#' }}" alt="Current Logo" width="100"/>
                        </div>
                    
                    <!-- Favicon Icon Input -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="favicon_icon">{{ __('theme.favicon_icon') }}</label>
                            <input id="favicon_icon" class="form-control" type="file" name="favicon_icon" accept="image/png" onchange="previewImage(event, 'faviconPreview')">
                            @if ($errors->has('favicon_icon'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('favicon_icon') }}</strong>
                                </span>
                            @endif
                            <small class="text-danger">[{{ __('theme.image_format') }}: PNG]</small>
                        </div>
                        <!-- Display current favicon and preview of the uploaded image -->
                        <img id="faviconPreview" class="thumbnail img-responsive" src="{{ isset($settings['company_icon']) ? asset('src/' . $settings['company_icon']) : '#' }}" alt="Current Favicon" width="32"/>
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
