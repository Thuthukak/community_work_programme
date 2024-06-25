<?php

namespace App\Models\ProjectManagement\Projects;

use App\Models\ProjectManagement\BaseRepository;
use App\Models\ProjectManagement\Partners\Customer;
use App\Models\CRM\Organization\Organization;
use App\Models\CRM\Person\Person;
use App\Models\Core\Auth\User;
use DB;
use ProjectStatus;

/**
 * Projects Repository Class.
 */
class ProjectsRepository extends BaseRepository
{
    protected $model;

    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    public function getProjects($q, $statusId, User $user)
    {

        $statusIds = array_keys(ProjectStatus::toArray());



        if ($user->hasRole('admin') == true) {
            return $user->projects()
                ->where(function ($query) use ($q, $statusId, $statusIds) {
                    $query->where('projects.name', 'like', '%'.$q.'%');

                    if ($statusId && in_array($statusId, $statusIds)) {
                        $query->where('status_id', $statusId);
                    }
                })
                ->latest()
                ->with(['Organization', 'jobs'])
                ->paginate($this->_paginate);
        }

        return $this->model->latest()
            ->where(function ($query) use ($q, $statusId, $statusIds) {
                $query->where('name', 'like', '%'.$q.'%');

                if ($statusId && in_array($statusId, $statusIds)) {
                    $query->where('status_id', $statusId);
                }
            })
            ->with('organization')
            ->paginate($this->_paginate);
    }

    public function create($projectData)
    {
        $projectData['project_value'] = $projectData['proposal_value'] ?: 0;
        DB::beginTransaction();

        if (isset($projectData['organization_id']) == false || $projectData['organization_id'] == '') {
            $Organization = $this->createNewOrganization($projectData['organization_name'], $projectData['organization_email']);
            $projectData['organization_id'] = $customer->id;
        }
        unset($projectData['organization_name']);
        unset($projectData['organization_email']);

        $project = $this->storeArray($projectData);
        DB::commit();

        return $project;
    }

    public function getStatusName($statusId)
    {
        return ProjectStatus::getNameById($statusId);
    }

    public function createNewCustomer($customerName, $customerEmail)
    {
        $newCustomer = new Customer();
        $newCustomer->name = $customerName;
        $newCustomer->email = $customerEmail;
        $newCustomer->save();

        return $newCustomer;
    }

    public function createNewOrganization($OrganizationName, $OrganizationEmail)
    {
        $newOrganization = new Organization();
        $newOrganization->name = $organizationName;
        $newOrganization->email = $organizationEmail;
        $newOrganization->save();

        return $newOrganization;
    }

    public function delete($projectId)
    {
        $project = $this->requireById($projectId);

        DB::beginTransaction();


        // Delete jobs tasks
        $jobIds = $project->jobs->pluck('id')->all();
        DB::table('tasks')->whereIn('project_job_id', $jobIds)->delete();

        // Delete jobs
        $project->jobs()->delete();

        // Delete project
        $project->delete();

        DB::commit();

        return 'deleted';
    }

    public function updateStatus($statusId, $projectId)
    {
        $project = $this->requireById($projectId);
        $project->status_id = $statusId;
        $project->save();

        return $project;
    }

    public function jobsReorder($sortedData)
    {
        $jobOrder = explode(',', $sortedData);
        foreach ($jobOrder as $order => $jobId) {
            $job = $this->requireJobById($jobId);
            $job->position = $order + 1;
            $job->save();
        }

        return $jobOrder;
    }
}
