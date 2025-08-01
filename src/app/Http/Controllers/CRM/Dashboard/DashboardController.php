<?php

namespace App\Http\Controllers\CRM\Dashboard;

use App\Filters\CRM\Dashboard\DashboardFilter;
use App\Http\Controllers\Controller;
use App\Models\CRM\Deal\Deal;
use App\Services\CRM\Dashboard\DashboardService;

class DashboardController extends Controller
{
    public function __construct(DashboardService $service, DashboardFilter $filter)
    {
        $this->service = $service;
        $this->filter = $filter;
    }

    public function index()
    {

        //Okrs 
        $totalOkr = 0;
        $okrs = [];
        list($totalOkr, $okrs) = $this->okrInformation($totalOkr,$okrs);

        //Actions 

        
        $ActionbarChartLabel = [];
        $ActionbarChartData = [];

        $actionsData = $this->service->getActions();

        // Extract month labels
        $actionLabels = array_column($actionsData, 'month');
    
        // Extract the data for each category
        $newActionsData = array_column($actionsData, 'new_actions');
        $activeCurrentActionsData = array_column($actionsData, 'active_current_actions');
        $dueActionsData = array_column($actionsData, 'due_actions');
    


        // Deal Both
        $dealChart = [];
        $totalDealsChartElement = [];
        $totalDeal = 0;

        list($dealChart, $totalDealsChartElement, $totalDeal) =
            $this->dealChartElement($dealChart, $totalDealsChartElement, $totalDeal);

        //Contact
        $totalContact = 0;
        $contacts = [];
        list($totalContact, $contacts) = $this->contactInformation($totalContact, $contacts);
        // Both Employees
        $totalEmployee = 0;
        $employees = [];
        list($totalEmployee, $employees) = $this->employeeInformation($totalEmployee, $employees);

        //keyResults info 

        $keyResultsMonths = [];
        $keyResultsdata = [];

        $keyResults = $this->service->getLastSixMonthsKeyResults();

        // Extract month labels
        $keyResultsLabels = array_column($keyResults, 'month');
    
        // Extract the data for each category
        $initialEqualsCurrentData = array_column($keyResults, 'initial_equals_current');
        $currentGt0AndLtTargetData = array_column($keyResults, 'current_gt_0_and_lt_target');
        $currentEqualsTargetData = array_column($keyResults, 'current_equals_target');
    
        $keyResultsdata = $keyResults;

        $netConfidenceScore = $this->getNetConfidenceScore();
        $formattedNetConfidenceScore = $netConfidenceScore !== null ? number_format($netConfidenceScore, 2) : null;

        // dd($netConfidenceScore);

        // Pipeline

        $totalProposal = $this->service->bothProposal();
        $totalAcceptedProposal = $this->service->bothProposal($this->service->statuses['status_accepted']);
        $totalSendProposal =
            $this->service->bothProposal($this->service->statuses['status_sent']) + $totalAcceptedProposal;

        // Sending Rate

        $sendingRate = $totalProposal > 0 ? intval(($totalSendProposal / $totalProposal) * 100) : 0;
        $acceptanceRate = $totalSendProposal > 0 ? intval(($totalAcceptedProposal / $totalSendProposal) * 100) : 0;

        // Objective Progress 
        $objectivesProgress = $this->service->getObjectivesProgress();
        $overallProgress = $objectivesProgress['overall_progress'];
        $formattedProgress = $overallProgress !== null ? number_format($overallProgress, 2) : null;

        // get actions rate 
        $actionsRate = $this->service->getActionsRates();
        $actioncreatedPerWeek = $actionsRate['rateActionsCreatedPerWeek'];
        $actionDonePerWeek = $actionsRate['rateActionsDonePerWeek'];
        $actionRatePerWeek = (($actioncreatedPerWeek + $actionDonePerWeek)/2)*100;

        $rateActionsCreatedPerDayArray = $actionsRate['rateActionsCreatedPerDay'];
        $rateActionsDonePerDayArray =  $actionsRate['rateActionsDonePerDay'];
        $rateActionsCreatedPerWeekArray =  $actionsRate['rateActionsCreatedPerWeek'];
        $rateActionsDonePerWeekArray =  $actionsRate['rateActionsDonePerWeek'];
        $rateActionsCreatedPerMonthArray =  $actionsRate['rateActionsCreatedPerMonth'];
        $rateActionsDonePerMonthArray =  $actionsRate['rateActionsDonePerMonth'];
        $rateActionsCreatedPerYearArray =  $actionsRate['rateActionsCreatedPerYear'];
        $rateActionsDonePerYearArray =  $actionsRate['rateActionsDonePerYear'];

        list( $rateActionsCreatedPerDayArray,$rateActionsDonePerDayArray, $rateActionsCreatedPerWeekArray, $rateActionsDonePerWeekArray,$rateActionsCreatedPerMonthArray,
        $rateActionsDonePerMonthArray,$rateActionsCreatedPerYearArray,$rateActionsDonePerYearArray) = 
        $this->getActionRatesOverview($rateActionsCreatedPerDayArray, $rateActionsDonePerDayArray,  $rateActionsCreatedPerWeekArray, $rateActionsDonePerWeekArray, $rateActionsCreatedPerMonthArray, $rateActionsDonePerMonthArray, $rateActionsCreatedPerYearArray,$rateActionsDonePerYearArray,);

        // Pipeline
        $pipelineName = [];
        $pipelineTotalDeals = [];
        $pipelineBackgroundColor = [];
      

        $totalPipeline = $this->service->pipeline();
        

        list($pipelineName, $pipelineTotalDeals, $pipelineBackgroundColor) =
            $this->dealPipeline($pipelineName, $pipelineTotalDeals, $pipelineBackgroundColor);

        // Top Five owners
        $topFiveOwners = $this->service->topFiveOwners($this->service->statuses['status_active']);

        $fiveOwnerName = [];
        $fiveOwnerDeals = [];
        foreach ($topFiveOwners as $value) {
            array_push($fiveOwnerName, $value->full_name);
            array_push($fiveOwnerDeals, $value->deals_count);
        }


        if (auth()->user()->can('manage_public_access')) {

            return [
                'deals_chart' => $dealChart,
                'total_deals_chart_element' => $totalDealsChartElement,
                'total_deal' => $totalDeal,
                'total_contact' => $totalContact,
                'contacts' => $contacts,
                'total_employee' => $totalEmployee,
                'employees' => $employees,
                'total_send_proposal' => $totalSendProposal,
                'total_accepted_proposal' => $totalAcceptedProposal,
                'sending_rate' => $sendingRate,
                'acceptance_rate' => $acceptanceRate,
                'total_pipeline' => $totalPipeline,
                'deals_on_pipeline_name' => $pipelineName,
                'pipeline_total_deals' => $pipelineTotalDeals,
                'background_color' => $pipelineBackgroundColor,
                'top_five_owners_name' => $fiveOwnerName,
                'five_owner_deal' => $fiveOwnerDeals,
                'action_barchart_labels' => $actionLabels,
                'new_actions_data' => $newActionsData,
                'active_current_actions_data' => $activeCurrentActionsData,
                'due_actions_data' => $dueActionsData,
                'net_Confidence_Score' => $formattedNetConfidenceScore,
                'total_Deals_Chart_Element' => $totalDealsChartElement,
                'total_okr' => $totalOkr,
                'okrs' => $okrs,
                'objectives_Progress' => $formattedProgress,
                'actionRatePerWeek' => $actionRatePerWeek,
                'keyResults_barchart_labels' => $keyResultsLabels,
                'keyResults_barchart_labels' => $keyResultsLabels,
                'initial_equals_current_data' => $initialEqualsCurrentData,
                'current_gt_0_and_lt_target_data' => $currentGt0AndLtTargetData,
                'current_equals_target_data' => $currentEqualsTargetData,
                'rateActionsCreatedPerDay' => $rateActionsCreatedPerDayArray,
                'rateActionsDonePerDayArray' => $rateActionsDonePerDayArray,
                'rateActionsCreatedPerWeek' => $rateActionsCreatedPerWeekArray,
                'rateActionsDonePerWeek' => $rateActionsDonePerWeekArray,
                'rateActionsCreatedPerMonth' => $rateActionsCreatedPerMonthArray,
                'rateActionsDonePerMonth' => $rateActionsDonePerMonthArray,
                'rateActionsCreatedPerYear' => $rateActionsCreatedPerYearArray,
                'rateActionsDonePerYear' => $rateActionsDonePerYearArray,
                

            ];
        } else {
            return [
                'deals_chart' => $dealChart,
                'total_deals_chart_element' => $totalDealsChartElement,
                'total_deal' => $totalDeal,
            ];
        }
    }

    //get actions rates 

    public function getActionRatesOverview($rateActionsCreatedPerDay, $rateActionsDonePerDay, $rateActionsCreatedPerWeek,  $rateActionsDonePerWeek, $rateActionsCreatedPerMonth,
                                    $rateActionsDonePerMonth,$rateActionsCreatedPerYear,$rateActionsDonePerYear,)
    {
        $rateActionsCreatedPerDayArray= [];
        $rateActionsDonePerDayArray = [];
        $rateActionsCreatedPerWeekArray = [];
        $rateActionsDonePerWeekArray = [];
        $rateActionsCreatedPerMonthArray = [];
        $rateActionsDonePerMonthArray = [];
        $rateActionsCreatedPerYearArray = [];
        $rateActionsDonePerYearArray = [];

        array_push($rateActionsCreatedPerDayArray, round($rateActionsCreatedPerDay, 2));
        array_push($rateActionsDonePerDayArray, round($rateActionsDonePerDay, 2));
        array_push($rateActionsCreatedPerWeekArray, round($rateActionsCreatedPerWeek, 2));
        array_push($rateActionsDonePerWeekArray, round($rateActionsDonePerWeek, 2));
        array_push($rateActionsCreatedPerMonthArray, round($rateActionsCreatedPerMonth, 2));
        array_push($rateActionsDonePerMonthArray, round($rateActionsDonePerMonth, 2));
        array_push($rateActionsCreatedPerYearArray, round($rateActionsCreatedPerYear, 2));
        array_push($rateActionsDonePerYearArray, round($rateActionsDonePerYear, 2));

        
        return [ $rateActionsCreatedPerDayArray,$rateActionsDonePerDayArray, $rateActionsCreatedPerWeekArray, $rateActionsDonePerWeekArray,$rateActionsCreatedPerMonthArray,$rateActionsDonePerMonthArray,$rateActionsCreatedPerYearArray,$rateActionsDonePerYearArray,];

    }


             public function getNetConfidenceScore()
        {
            $objectivesProgress = $this->service->getNetConfidencescore();

            // Calculate the Net Confidence Score as the average of all objectives' average weighted confidence
            $netConfidenceScore = $objectivesProgress->avg('average_weighted_confidence');

            return $netConfidenceScore;
        }


            public function getActionsdata(array $data)
            {
                $actionsRates = $this->service->getActions();
                
                // Extract data from the collections
                $totalActions = $actionsRates['allActions']->count();
                $newActions = $actionsRates['newActions']->count();
                $activeCurrentActions = $actionsRates['activeCurrentActions']->count();
                $dueActions = $actionsRates['dueActions']->count();
                
                // Prepare labels and data as percentages
                $labels = ['New Actions', 'Active Actions', 'Due Actions'];
                array_push(
                    $data , [
                    'Actions  New' => $totalActions > 0 ? ($newActions / $totalActions) * 100 : 0,
                    'Actions  Active ' =>  $totalActions > 0 ? ($activeCurrentActions / $totalActions) * 100 : 0,
                    'Actions  Due '  =>  $totalActions > 0 ? ($dueActions / $totalActions) * 100 : 0
                    ]);
                
                // Return labels and data for chart
                return [
                    'labels' => $labels,
                    'data' => $data,
                ];
            }

    
    
    
    public function dealChartElement(array $dealChart, array $totalDealsChartElement, $totalDeal)
    {
        $openDeal = $this->service->dealsCountByStatus($this->service->statuses['status_open']);
        $wonDeal = $this->service->dealsCountByStatus($this->service->statuses['status_won']);
        $lostDeal = $this->service->dealsCountByStatus($this->service->statuses['status_lost']);

        // Total Deals Chart Element
        array_push(
            $dealChart,
            $openDeal,
            $wonDeal,
            $lostDeal
        );

        array_push(
            $totalDealsChartElement,
            ['value' => $openDeal, 'key' => 'open'],
            ['value' => $wonDeal, 'key' => 'won'],
            ['value' => $lostDeal, 'key' => 'lost']
        );

        $totalDeal = ($openDeal + $wonDeal + $lostDeal);

        return [$dealChart, $totalDealsChartElement, $totalDeal];

    }

    public function contactInformation($totalContact, array $contacts)
    {
        $totalOrganization = $this->service->totalOrganization();
        $totalPeople = $this->service->totalPeople();
        $totalParticipation = $this->service->totalParticipation();
        $totalContact = ($totalOrganization + $totalPeople);

        array_push(
            $contacts,
            ['value' => $totalOrganization, 'key' => 'organization'],
            ['value' => $totalPeople, 'key' => 'people'],
            ['value' => $totalParticipation, 'key' => 'participation']
        );

        return [$totalContact, $contacts];
    }

    public function okrInformation($totalOkr, array $okrs)
    {
        $totalObjectives = $this->service->totalObjectives();
        $totalkeyResults = $this->service->totalKeyResults();
        $totalActions = $this->service->totalActions();
        $totalUsers = $this->service->getTotalUsers();
        $totalOkr = $totalObjectives;

        array_push(
            $okrs,
            ['value' => $totalObjectives, 'key' => 'objectives'],
            ['value' => $totalkeyResults, 'key' => 'keyResults'],
            ['value' => $totalActions, 'key' => 'actions'],
            ['value' => $totalUsers, 'key' => 'users']
        );

        return [$totalOkr, $okrs];
    }

    public function employeeInformation($totalEmployee, array $employees)
    {
        $totalEmployee = $this->service->totalEmployee();

        $totalOwner = $this->service->totalOwner();

        $totalCollaborator = $this->service->totalCollaborator()->pluck('user_id');

        $totalBothOwnerCollaborator = $totalOwner->values()->intersect($totalCollaborator->values());

        array_push(
            $employees,
            ['value' => $totalOwner->count(), 'key' => 'works_as_owner'],
            ['value' => $totalCollaborator->count(), 'key' => 'works_as_collaborators'],
            ['value' => $totalBothOwnerCollaborator->count(), 'key' => 'works_as_boot_owner_collaborators']
        );

        return [$totalEmployee, $employees];
    }

    public function dealPipeline($pipelineName, $pipelineTotalDeals, $pipelineBackgroundColor)
    {


        // Deals on pipeline
        $dealsOnPipeline = $this->service->pipeline($this->service->statuses[\request()->status]);

        if (count($dealsOnPipeline)) {
            $dealsOnPipeline->push(['name' => trans('custom.average'),
                'deals_count' => $dealsOnPipeline->avg('deals_count'),]);
            $sorted = $dealsOnPipeline->sortByDesc('deals_count');

            foreach ($sorted as $key => $value) {
                if ($value['name'] == 'Average') {
                    array_push($pipelineBackgroundColor, '#00C754');
                } else {
                    array_push($pipelineBackgroundColor, '#4466F2');
                }

                array_push($pipelineName, $value['name']);
                array_push($pipelineTotalDeals, $value['deals_count']);
            }
        }
        return [$pipelineName, $pipelineTotalDeals, $pipelineBackgroundColor];
    }

    public function dealOverView(): array
    {

        $deals = Deal::filters($this->filter)->get();
        

        return $this->service->dealOverView($deals);
    }

    public function okrOverview() : array
    {
        $okrs = KeyResult::all()->get();

        return $this->service->okrOverview($okrs);
    }
}