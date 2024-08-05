
<div class="custom-container-wrapper pt-5" style="margin:20px;margin-left:50px; margin-right:50px; background: white;
    justify-content:left;
    padding-bottom: 50px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); ">
<div class="row justify-content-center">
    <div class="col-md-4 u-padding-16">
        <div class="row">
            <div class="col-auto">
                <a class="u-ml-8 u-mr-8" href="{{ route('company.okr') }}">
                    <img src="storage/logo/6683fbf19b192.png" alt="" class="avatar text-center bg-white">
                </a>
            </div>
            <div class="col align-self-center text-truncate">
                <a href="{{ route('company.okr') }}">
                    <p class="mb-0 font-weight-bold text-black-50 text-truncate">{{ $company->name }}</p>
                    <p class="mb-0 text-black-50 text-truncate">{{ $company->description }}</p>
                </a>
                @for ($i = 0; $i < count($company->users) && $i < 5; $i++) 
                    <a href="{{ route('user.okr', $company->users[$i]) }}" class="d-inline-block pt-2" data-toggle="tooltip" data-placement="bottom" title="{{ $company->users[$i]->name }}">
                        <img src="{{ $company->users[$i]->getAvatar() }}" alt="" class="avatar-xs">
                    </a>
                    @if (count($company->users)>5 && $i == 4)
                    <a class="d-inline-block pt-2" href="{{ route('company.member') }}" data-toggle="tooltip" data-placement="bottom" title="with other {{ count($company->users)-5 }} members">
                        <img src="{{ asset('img/icon/more/gray.svg') }}" alt="" class="avatar-xs">
                    </a>
                    @endif
                @endfor
            </div>
        </div>
    </div>
    <div class="col-md-6 u-padding-16">
        <div class="row">
            @if ($company->okrs)
                @for ($i = 0; $i < 4 && $i < count($company->okrs); $i++)
                <div class="col-3 align-self-center">
                    <div class="circle" data-value="{{ $company->okrs[$i]['objective']->getScore()/100 }}">
                        <div>{{ $company->okrs[$i]['objective']->getScore() }}%</div>
                    </div>
                    <div class="circle-progress-text">{{ $company->okrs[$i]['objective']->title }}</div>
                </div>
                @endfor
            @endif
        </div>
    </div>
</div>

<div class="row justify-content-end mr-4">
    <div class="col text-right align-self-end">
        @can('update', $company)
            <a href="#" data-toggle="modal" data-target="#editCompany" class="tooltipBtn text-info" data-placement="top" title="Edit Organization"><i class="fas btn-lg fa-edit btn btn-warning btn-xs edit-project-btn u-margin-4"></i></a>            
        @endcan
        @can('delete', $company)
            <a href="#" data-toggle="dropdown" class="tooltipBtn text-info" data-placement="top" title="Delete Organization"><i class="fas btn-lg btn btn-danger btn-xs edit-project-btn fa-trash-alt"></i></a>
            <form method="POST" id="companyDelete" action="{{ route('company.destroy') }}">
                @csrf
                {{ method_field('DELETE') }}
                <div class="dropdown-menu u-padding-16">
                    <div class="row justify-content-center mb-2">
                        <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                            <div class="row">
                            <div class="col text-center">
                                After deleting the organization,<br>
                                all data within the organization will be lost!!<br>
                                Are you sure you want to delete the organization?<br>
                            </div>

                            </div>
                            <div class="row justify-content-center mt-3">
                                <div class="col-auto text-center pr-2"><button class="btn btn-danger pl-4 pr-4" type="submit">Delete</button></div>
                                <div class="col-auto text-center pl-2"><a class="btn btn-secondary text-white pl-4 pr-4">Cancel</a></div>
                            </div>
                        </div>
                    </form>
                    @endcan
                </div>
        </div>
</div>


@can('update', $company)
{{-- 編輯公司modal --}}
@include('crm.organization.company.edit')
@endcan

