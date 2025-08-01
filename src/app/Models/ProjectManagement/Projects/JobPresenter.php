<?php

namespace App\Models\ProjectManagement\Projects;

use Laracasts\Presenter\Presenter;

class JobPresenter extends Presenter
{
    public function workerNameAndEmail()
    {
        return $this->worker_id ? $this->worker->name.' ('.$this->worker->email.')' : '-';
    }

    public function personNameAndEmail()
    {
        return $this->person_id ? $this->person->name.' ('.$this->person->name.')' : '-';
    }

    public function projectLink()
    {
        return link_to_route('projects.show', $this->project->name, [$this->project_id]);
    }

    public function projectJobsLink()
    {
        return link_to_route('projects.jobs.index', __('project.jobs'), [$this->project_id]);
    }
}
