<div class="row stats" style='margin:-20px 10px 10px 10px;
    background-color: white;
    border-radius:5px;
    padding: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);'>
    <div class="col-lg-6 col-md-12">
        <a href="{{ route('projects.jobs.index',[$project->id]) }}" class="job-link" title="Progress">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row stat-box" style="display: flex;
    justify-content: space-between;
    border: 1px solid #ccc;
    border-radius: 6px;
    padding:4px;">
                    <div class="col-xs-3"><i class="fas fa-spinner mt-3 ml-3 fa-3x "></i></div>
                    <div class="col-xs-9 text-right">
                    <div class="lead">{{ __('project.overall_progress') }}</div>
                        <div class="huge" style="font-size: 38px;">{{ format_decimal($project->getJobOveralProgress()) }} %</div> 
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-6 col-md-12">
    <a href="{{ route('projects.jobs.index',[$project->id]) }}" class="job-link" title="Total Job dan Task">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row stat-box" style="display: flex;
    justify-content: space-between;
    border: 1px solid #ccc;
    border-radius: 6px;
    padding:4px;">
                    <div class="col-xs-3"><i class="fas fa-briefcase mt-1 ml-4 fa-3x"></i></div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ $project->jobs->count() }} Job</div>
                        <div class="lead">{{ $project->tasks->count() }} Task</div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

    @can('see-pricings', $project)
    <div class="col-lg-6 col-md-12">
        <a href="{{ route('projects.jobs.index',[$project->id]) }}" class="job-link"title="Collectible Earnings">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row stat-box" style="display: flex;
    justify-content: space-between;
    border: 1px solid #ccc;
    border-radius: 6px;
    padding:4px;">
                <div class="col-xs-3"><i class="fas fa-envelope mt-3 ml-3 fa-3x"></i></div>
                    <div class="col-xs-12 text-right">
                        <div class="lead">Collectibe Earnings</div>
                        <div class="lead" style="font-size: 30px;">{{ format_money($project->getCollectibeEarnings()) }}</div>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
    @endcan
    <div class="clearfix"></div>
</div>
