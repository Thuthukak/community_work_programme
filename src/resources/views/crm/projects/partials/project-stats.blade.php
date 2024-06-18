<div class="row stats">
    <div class="col-lg-6 col-md-12">
        <a href="{{ route('projects.jobs.index',[$project->id]) }}" title="Progress">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row stat-box">
                    <div class="col-xs-3"><i class="fas fa-spinner  fa-3x "></i></div>
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
        <a href="{{ route('projects.jobs.index',[$project->id]) }}" title="Total Job dan Task">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row stat-box">
                    <div class="col-xs-3"><i class="fas fa-briefcase fa-3x"></i></div>
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
        <a href="{{ route('projects.jobs.index',[$project->id]) }}" title="Collectible Earnings">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row stat-box">
                <div class="col-xs-3"><i class="fas fa-envelope fa-3x"></i></div>
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
