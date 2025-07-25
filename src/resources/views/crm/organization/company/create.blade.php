<div class="row justify-content-md-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row u-margin-16 u-mt-32 u-ml-32">
                    <div class="col-md-12"><h5>Establish a new organization?</h5></div>
                </div>
                <form method="POST" action="{{ route('company.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row u-ml-16 u-mr-16">
                        <div class="col-md-12 align-self-center">
                            <input name="avatar" type="file" class="u-hidden imgUpload" accept="image/*"/>
                            <img class="avatar u-hidden u-margin-16 avatarImg" src="" alt="">
                            <img class="avatar u-hidden u-margin-16 avatarImgUpload" src="/img/icon/upload/gray.svg" alt="">
                            <div id="companyIcon" class="avatar text-center uploadIcon">
                                <i class="fas fa-building text-white"></i>
                                <i class="fas fa-upload text-white"></i>
                            </div>
                            <div class="form-group u-ml-16 w-25" style="display:inline-block">
                                <label for="company_name">Organization Name<strong class="invalid-feedback"></strong></label>
                                <input type="text" name="company_name" id="company_name" value="" placeholder="Organization Name" class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row u-ml-32 u-mr-32">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="company_description">Organization Overview<strong class="invalid-feedback"></strong></label>
                                    <textarea type="text" name="company_description" id="company_description" value="" placeholder="Please enter the organization overview" class="form-control {{ $errors->has('company_description') ? ' is-invalid' : '' }}" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row u-ml-32 u-mr-32 u-mb-32 justify-content-end">
                        <div class="form-group u-pl-16 u-pr-16">
                            <button class="btn btn-primary" type="submit">Establish</button>   
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>