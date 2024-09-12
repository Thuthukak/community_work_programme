
<div class="container-fluid">
   
    <h4 class="page-title">{{ __('theme.banner_text_setting') }}</h4>
    <div class="card mb-4">
        <div class="card-body">
            @include('includes.flash')
            <form action="{{ route('headerTextUpSetting'}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="header_title">{{ __('theme.banner_text_title') }}</label>
                        <input class="form-control mb-3" name="header_title" value=""  type="text" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="header_subtitle">{{ __('theme.banner_text_sub_title') }}</label>
                        <input class="form-control mb-3" name="header_subtitle" value=""  type="text" required>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('theme.update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

