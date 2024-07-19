<div class="modal fade " id="editCompany" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-center font-weight-bold"><h5>Edit Organization</h5></div>
                </div>
                <form method="POST" action="{{ route('company.update') }}" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}
                    {{-- Upload Avatar --}}
                    <div class="row">
                        <div class="col-12 text-center">
                            <input name="avatar" type="file" class="u-hidden imgUpload" accept="image/*"/>
                            <img class="avatar u-margin-16 avatarImg" src="{{ $company->getAvatar() }}" alt="">
                            <img class="avatar u-hidden u-margin-16 avatarImgUpload" src="/img/icon/upload/gray.svg" alt="">
                        </div>
                    </div>
                    {{-- Company Name --}}    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="company_name"> Organization Name<strong class="invalid-feedback"></strong></label>
                                <input type="text" name="company_name" id="company_name" value="{{ $company->name }}" placeholder="Please enter the organization name" class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}" required>
                            </div>
                        </div>
                    </div>
                    {{-- Company Profile --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="company_description">Organization Overview<strong class="invalid-feedback"></strong></label>
                                    <textarea type="text" name="company_description" id="company_description" placeholder="Please enter the organization overview" class="form-control {{ $errors->has('company_description') ? ' is-invalid' : '' }}" required>{{ $company->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Establish Button --}}
                    <div class="form-row u-mt-16 u-mb-32 justify-content-end">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Save</button>   
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
