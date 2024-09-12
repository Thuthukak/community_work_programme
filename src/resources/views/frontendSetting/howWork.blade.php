
<div class="container-fluid">
    <h4 class="mb-4">{{ __('theme.how_we_work_setting') }}</h4>
    @include('tickets.flash')
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
                                <input class="form-control form-control-lg mb-3 {{ $errors->has('how_work_title') ? ' is-invalid' : '' }}" name="how_work_title" value=""  type="text" required>
                                <input class="form-control form-control-lg mb-3" name="id" value=""  type="hidden">
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
                                <textarea class="form-control" id="how_work_details" rows="2" name="how_work_details" required></textarea>
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
                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

