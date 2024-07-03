<div class="row stats" style="margin-right:10px;">
    <div class="col-lg-4 col-md-12">
        <a href="{{ route('projects.jobs.index',[$project->id]) }}" class="job-link" title="Progress">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row stat-box">
                    <div class="col-xs-3"><i class="fas fa-spinner mt-2 ml-3 fa-2x"></i></div>
                    <div class="col-xs-9 text-right">
                    <div>{{ __('project.overall_progress') }}</div>
                        <div style="font-weight: bold;">{{ format_decimal($project->getJobOveralProgress()) }} %</div> 
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-4 col-md-12" >
    <a href="{{ route('projects.jobs.index',[$project->id]) }}" class="job-link" title="Total Job dan Task">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row stat-box" style="padding-bottom:5px;">
                    <div class="col-xs-3"><i class="fas fa-briefcase mt-2 ml-4 fa-2x"></i></div>
                    <div class="col-xs-9 text-right">
                        <div>{{ $project->jobs->count() }} Job</div>
                        <div >{{ $project->tasks->count() }} Task</div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

    @can('see-pricings', $project)
    <div class="col-lg-4 col-md-12">
        <a href="{{ route('projects.jobs.index',[$project->id]) }}" class="job-link"title="Collectible Earnings">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row stat-box">
                <div class="col-xs-3"><i class="fas fa-envelope mt-2 ml-3 fa-2x"></i></div>
                    <div class="col-xs-12 text-right">
                        <div >Collectibe Earnings</div>
                        <div  style="font-weight: bold;">{{ format_money($project->getCollectibeEarnings()) }}</div>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
    @endcan
    <div class="clearfix"></div>
</div>
