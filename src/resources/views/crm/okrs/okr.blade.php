<!-- this is the card for okr starting with date on top then objective and key result -->
<div class="container-fluid " style="margin-top: 40px;">
<span class="anchor" id="oid-{{ $okr['objective']->id }}"></span>
<div class="card m-4 okr-card">
    <div class="card-header bg-transparent" style="border-bottom: none;">
        {{-- Card time --}}
        <div class="row">
            <div class="col-md-12 ml-auto text-right">
                <span class="font-weight-light pl-2 pr-4">{{ $okr['objective']->started_at }} ~ {{ $okr['objective']->finished_at }}</span>
                @can('storeObjective', $owner)
                <a class="close okr-close-btn">
                <i class="far fa-edit"></i>       
                </a>
                @endcan
            </div>
        </div>
    </div>
    <div class="card-body">

        {{-- Card target --}}
        <div class="row align-items-center">
            <div class="col-md-2 font-weight-bold text-md-right pr-0" style="margin-top: 10px;">
                <h4 style="font-size:18px;">Objective:</h4>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-5 col-sm-5" style="line-height: 32px; font-size: 16px;">{{
                        $okr['objective']->title }}</div>
                    <div class="col-md-7 col-sm-7 row justify-content-end">
                        <div class="pt-2" style="display:inline-block; width:60%;">
                            <div class="progress" style="height:20px;">
                                @if($okr['objective']->getScore()<0) 
                                    <div class="progress-bar bg-danger" role="progressbar" style="width:{{ abs($okr['objective']->getScore()) }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ $okr['objective']->getScore() }}%</div>
                                @else
                                    <div class="progress-bar" role="progressbar" style="width:{{ $okr['objective']->getScore() }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ $okr['objective']->getScore() }}%</div>
                                @endif
                            </div>
                        </div>
                        @can('storeObjective', $owner)
                        <div class="pt-2 pl-3 pr-2 btn-edit-group" style="display:none;">
                            {{-- Edit O button--}}
                            <a href="#" data-toggle="modal" data-target="#objectiveEdit{{ $okr['objective']->id }}" class="pl-2 pr-2 text-info"><i class="fas btn-lg fa-edit btn btn-warning btn-xs edit-project-btn u-margin-4"></i></a>        
                            {{-- Edit o modal --}}
                            <div class="modal" id="objectiveEdit{{ $okr['objective']->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-12 text-center">
                                                <h4>Edit Objective</h4>
                                            </div>
                                            <form method="POST" action="{{ route('okr.update',$okr['objective']->id) }}">
                                                @csrf
                                                {{ method_field('PATCH') }}
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label for="objective_title">Objective</label>
                                                        <input type="text" class="form-control" name="obj_title" id="objective_title" value="{{ $okr['objective']->title }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label for="started_at">Starting day</label>
                                                        <input autocomplete="off" class="form-control started_at" name="st_date" id="" value="{{ $okr['objective']->started_at }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label for="finished_at">Completion date</label>
                                                        <input autocomplete="off" class="form-control finished_at" name="fin_date" id="" value="{{ $okr['objective']->finished_at }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-row mb-4 mt-3 justify-content-center">
                                                    <div class="col-6">
                                                        <button class="btn btn-primary btn-sm col-md-12 mt-3" type="submit">Add</button>  
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" data-toggle="dropdown" class="text-info"><i class="fas btn btn-danger btn-xs edit-project-btn fa-trash-alt"></i></a>
                            <form method="POST" id="deleteKR{{ $okr['objective']->id }}" action="{{ route('objective.destroy', $okr['objective']->id) }}">
                                @csrf
                                {{ method_field('DELETE') }}
                                <div class="dropdown-menu u-padding-16">
                                    <div class="row justify-content-center mb-2">
                                        <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-center">
                                            After deleting Objective,<br>
                                            You will lose KR and ACTION under Objective section<br>
                                            Do you confirm that you want to delete Objective?<br>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mt-3">
                                        <div class="col-auto text-center pr-2"><button class="btn btn-danger pl-4 pr-4" type="submit">delete</button></div>
                                        <div class="col-auto text-center pl-2"><a class="btn btn-secondary text-white pl-4 pr-4">Cancel</a></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <hr class="u-mb-16">
        {{-- Card indicator --}}
        <div class="row">
            <div class="col-md-2 font-weight-bold text-md-right align-self-center pr-0">
                <h4 style="font-size:18px;">Key Results</h4>
            </div>
            <div class="col-md-10">
                @foreach ($okr['keyresults'] as $kr)
                <div class="row pt-2 kr">
                    <span class="col-md-5 col-sm-5 ml-sm-4 pt-2 pr-0" style="border-left: 5px solid {{ $kr->color() }} "> no.{{ $kr->id }} : {{ $kr->title }} </span>
                    <div class="col-md-7 col-sm-7 row justify-content-end value pl-0 pr-sm-5">
                        <span class="pt-2 pr-4">{{ $kr->confidence }} / 10 <i class="fas fa-heart" style="color: #FFB5B1;"></i></span>
                        <div class="pt-3" style="display:inline-block; width:60%;">
                            <div class="progress">
                                @if($kr->accomplishRate()<0) 
                                    <div class="progress-bar bg-danger" data-toggle="tooltip" data-placement="top" title="current:{{ $kr->current_value }} Target:{{ $kr->target_value }} Weights:{{ $kr->weight }}"
                                    role="progressbar" style="width:{{ abs($kr->accomplishRate()) }}%" aria-valuenow="25">
                                    {{ $kr->accomplishRate() }}%
                                    </div>
                                @else
                                    <div class="progress-bar" data-toggle="tooltip" data-placement="top" title="current:{{ $kr->current_value }} Target:{{ $kr->target_value }} Weights:{{ $kr->weight }}"
                                        role="progressbar" style="width:{{ $kr->accomplishRate() }}%" aria-valuenow="25">
                                        {{ $kr->accomplishRate() }}%
                                    </div>
                                @endif
                            </div>
                        </div>
                        @can('storeObjective', $owner)
                        <div class="pt-2 pl-3 pr-2 btn-edit-group" style="display:none;">
                            {{-- Edit KR button --}}
                            <a href="#" data-toggle="modal" data-target="#keyresult{{ $kr->id }}" class="pl-2 pr-2 text-info"><i class="fas btn-lg fa-edit btn btn-warning btn-xs edit-project-btn u-margin-4"></i></a>        
                            {{-- Edit Kr Modal --}}
                            <div class="modal" id="keyresult{{ $kr->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-12 text-center">
                                                <h4>Edit KeyResult</h4>
                                            </div>
                                            <form method="POST" action="{{ route('okr.update', $okr['objective']->id) }}">
                                                @csrf
                                                {{ method_field('PATCH') }}
                                                <div class="form-row mt-4">
                                                    <div class="form-group col-12 mt-4">
                                                        <label for="keyresult_title">KeyResult</label>
                                                        <input type="text" class="form-control" name="krs_title{{ $kr->id }}" id="keyresult_title" value="{{ $kr->title }}">
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <label for="keyresult_confidence">Reaching rate</label>
                                                        <input type="text" class="js-range-slider kr-slider" id="keyresult_slider" name="krs_now{{ $kr->id }}" value="{{ $kr->current_value }}"
                                                            data-min="{{ $kr->initial_value }}"
                                                            data-max="{{ $kr->target_value }}"
                                                            data-from="{{ $kr->current_value }}"
                                                            data-grid= true 
                                                        />
                                                    </div>
                                                    <div class="form-group col-4">
                                                        <label for="keyresult_initaial">Start value</label>
                                                        <input type="number" class="form-control kr-init" name="krs_init{{ $kr->id }}" id="keyresult_initaial" value="{{ $kr->initial_value }}">
                                                    </div>
                                                    <div class="form-group col-4">
                                                        <label class="text-primary" for="keyresult_target">Current value</label>
                                                        <input type="number" class="form-control kr-now" name="krs_now{{ $kr->id }}" id="keyresult_now" value="{{ $kr->current_value }}">
                                                    </div>
                                                    <div class="form-group col-4">
                                                        <label for="keyresult_target">Target value</label>
                                                        <input type="number" class="form-control kr-target" name="krs_tar{{ $kr->id }}" id="keyresult_target" value="{{ $kr->target_value }}">
                                                    </div>

                                                    <div class="form-group col-6">
                                                        <label for="keyresult_weight">Weights</label>
                                                        <input type="text" class="js-range-slider" name="krs_weight{{ $kr->id }}" value="{{ $kr->weight }}"
                                                            data-min="0.1"
                                                            data-max="2"
                                                            data-from="{{ $kr->weight }}"
                                                            data-step="0.1"
                                                            data-grid= true 
                                                        />
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label for="keyresult_confidence">Confidence</label>
                                                        <input type="text" class="js-range-slider" name="krs_conf{{ $kr->id }}" value="{{ $kr->confidence }}"
                                                            data-min="0"
                                                            data-max="10"
                                                            data-from="{{ $kr->confidence }}"
                                                            data-step="1" 
                                                            data-grid= true 
                                                        />
                                                    </div>
                                                </div>
                                                <div class="form-row mb-4 mt-3 justify-content-center">
                                                    <div class="col-6">
                                                        <button class="btn btn-primary btn-sm col-md-12 mt-3" type="submit">Modify</button>  
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" data-toggle="dropdown" class="text-info"><i class="fas btn btn-danger btn-xs edit-project-btn fa-trash-alt"></i></a>
                            <form method="POST" id="deleteKR{{ $kr->id }}" action="{{ route('kr.destroy', $kr->id) }}">
                                @csrf
                                {{ method_field('DELETE') }}
                                <div class="dropdown-menu u-padding-16">
                                    <div class="row justify-content-center mb-2">
                                        <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-center">
                                            After deleting keyresult,<br>
                                            You will lose the action under KeyResult section<br>
                                            Do you confirm that you want to delete KeyResult?<br>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mt-3">
                                        <div class="col-auto text-center pr-2"><button class="btn btn-danger pl-4 pr-4" type="submit">delete</button></div>
                                        <div class="col-auto text-center pl-2"><a class="btn btn-secondary text-white pl-4 pr-4">Cancel</a></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endcan
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @can('storeObjective', $owner)
        <div class="col-md-10 offset-md-2">
            <div class="row">
                @include('crm.okrs.newkr',$okr['objective'])
            </div>
        </div>
        @endcan
    </div>

    <div id="objective{{ $okr['objective']->id }}" class="card-footer text-muted mt-3">
        <div class="row text-center mb-3">
            <div class="col-4 align-self-center pl-0 pr-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#Action{{ $okr['objective']->id }}">
                    <i class="fas fa-bullseye"></i> Actions
                </button>
            </div>
            <div class="col-4 align-self-center pl-0 pr-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#Msg{{ $okr['objective']->id }}">
                    <i class="far fa-comments"></i> message
                </button>
            </div>
            <div class="col-4 align-self-center pl-0 pr-0">
                <button class="btn btn-link historybtn" type="button" data-toggle="collapse" data-target="#History{{ $okr['objective']->id }} " data-oid="{{ $okr['objective']->id }}">
                    <i class="fas fa-chart-line"></i> historical data
                </button>
            </div>
        </div>
        {{-- ACTION content --}}
        <div id="Action{{ $okr['objective']->id }}" class="collapse" data-parent="#objective{{ $okr['objective']->id }}">
            <div class="card-body">
                @can('storeObjective', $owner)
                @if($okr['keyresults']->toArray())
                <div class="text-right">
            <button class="btn btn-primary btn-sm mb-2 p-2 fa fa-sm add-action-btn" data-id="{{ $okr['objective']->id }}" data-toggle="modal" data-target="#createActionModal" style="font-family: 'Poppins', sans-serif;">
                Add Action
            </button>
        </div>
               @else
                <button type="button" class="btn btn-secondary w-100" disabled><i class="fa fa-lock fa-sm"></i> Please add Key Results first
                (Key indicators)</button>
                @endif
                @include('crm.okrs.listaction',$okr)
                @endcan
            </div>
        </div>
        {{-- Message content --}}
        <div id="Msg{{ $okr['objective']->id }}" class="collapse comment" data-parent="#objective{{ $okr['objective']->id }}">
            @comments(['model' => $okr['objective']])
            @endcomments
        </div>
        {{-- History chart content --}}
        <div id="History{{ $okr['objective']->id }}" class="collapse" data-parent="#objective{{ $okr['objective']->id }}">
            <div class="row">
                <div class="col-12">
                    {{-- <div class="card card-body" style="position: relative;"> --}}
                        <canvas id="speedChart{{$okr['objective']->id}}"></canvas>
                        <div class="alert alert-info" role="alert" style="display: none;" id="ChartShow{{ $okr['objective']->id }}">
                            This target has no historical record, so there is no chart。
                        </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>


<!-- Modal -->
<div id="createActionModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-height: 100%;">
        <!-- Modal content-->
        <div class="modal-content" style="max-height: calc(100vh - 210px); overflow-y: auto;">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Add Action') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route' => 'actions.store', 'method' => 'POST', 'class' => 'p-4', 'id' => 'createActionForm']) !!}

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="action_title">Action</label>
                    <input type="text" class="form-control" name="act_title" id="action_title" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="priority">Priority</label>
                    <select id="priority" class="form-control" name="priority" required>
                        <option value="">Select Priority</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="started_at">Starting day</label>
                    <input autocomplete="off" class="form-control" name="st_date" id="started_at" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="finished_at">Completion date</label>
                    <input autocomplete="off" class="form-control" name="fin_date" id="finished_at" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="keyresult">Associated KR</label>
                    <select class="form-control" name="krs_id" id="keyresult" required>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="model_type">Action On</label>
                    <select id="model_type" class="form-control" name="model_type" required>
                        <option value="">Select Action On</option>
                        <option value="Onboarding">Onboarding</option>
                        <option value="Project">Project</option>
                        <option value="Proposal">Proposal</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="model_id">Target</label>
                    <select id="model_id" class="form-control" name="model_id" required>
                    </select>
                </div>

                <input type="hidden" name="full_model_type" id="full_model_type">

            </div>


            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="action_content">Content</label>
                    <textarea class="form-control" id="action_content" rows="7" name="act_content" style="resize: none;" required></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="files">Upload Attachment</label>
                    <input type="file" class="form-control-file" name="files[]" id="files" multiple>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12 text-right">
                    <button class="btn btn-primary" type="submit">Send out</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.cancel') }}</button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

</div>
<br />
</div>


