<?php

namespace App\Models\ProjectManagement\Projects;

use Laracasts\Presenter\Presenter;
use ProjectStatus;

class ProjectPresenter extends Presenter
{
    public function customerNameAndEmail()
    {
        return $this->customer_id ? $this->customer->name.' ('.$this->customer->email.')' : '-';
    }

    public function OrganizationNameAndEmail()
    {
        return $this->organization_id ? $this->Organization->name.' ('.$this->Organization->email.')' : '-';
    }

    public function projectLink()
    {
        return link_to_route('projects.show', $this->name, [$this->id]);
    }

    public function status()
    {
        return ProjectStatus::getNameById($this->entity->status_id);
    }
}
