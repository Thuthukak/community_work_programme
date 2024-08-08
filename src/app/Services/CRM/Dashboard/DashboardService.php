<?php

namespace App\Services\CRM\Dashboard;

use App\Filters\CRM\Dashboard\DashboardFilter;
use App\Models\Core\Status;
use App\Models\CRM\Deal\Deal;
use App\Models\CRM\Organization\Organization;
use App\Models\CRM\Person\Person;
use App\Models\CRM\Pipeline\Pipeline;
use App\Models\CRM\Objective\Objective;
use App\Models\CRM\KeyResult\KeyResult;
use App\Models\CRM\KeyResultRecord\KeyResultRecord;
use App\Models\CRM\Action\Action;
use App\Models\CRM\Proposal\Proposal;
use App\Models\CRM\User\User;
use App\Services\ApplicationBaseService;
use Carbon\Carbon;

class DashboardService extends ApplicationBaseService
{
    public $filter;
    public function __construct(DashboardFilter $filter)
    {
        $this->statuses = $this->getStatus();
        $this->filter = $filter;
    }

    public function dealOverView($deals)
    {
        // Deals Overview

        $weekContainer = array_fill(0, 7, 0);
        $openWeekMap = $weekContainer;
        $wonWeekMap = $weekContainer;
        $lostWeekMap = $weekContainer;

        $totalWeekMap = $weekContainer;

        // Month of Year Section
        $yearContainer = array_fill(0, 12, 0);
        $openYearMap = $yearContainer;

        $wonYearMap = $yearContainer;

        $lostYearMap = $yearContainer;

        $totalYearMap = $yearContainer;
        $checkLastOrThisMonth = request()->has('last_month')
            ? now()->subMonth()->daysInMonth
            : now()->daysInMonth;
        $monthContainer = array_fill(1, $checkLastOrThisMonth, 0);
        $month = $monthContainer;
        $monthWon = $monthContainer;
        $monthLost = $monthContainer;
        $monthTotal = $monthContainer;


        // Total Deal Count
        $totalDeal = $this->dealStatusCount($deals);

        // Deal Count
        $openDeal = $this->dealStatusCount($deals, $this->statuses['status_open']);


        // Total Won Deal
        $wonDeal = $this->dealStatusCount($deals, $this->statuses['status_won']);

        // Total Lost Deal
        $lostDeal = $this->dealStatusCount($deals, $this->statuses['status_lost']);


        // Status Open Filter
        $statusOpenFilter = $this->dealStatusPluckFilter($deals, $this->statuses['status_open']);

        list($openWeekMap, $month, $openYearMap)
            = $this->statusFilters($statusOpenFilter, $openWeekMap, $month, $openYearMap);

        // Status Won Filter
        $statusWonFilter = $this->dealStatusPluckFilter($deals, $this->statuses['status_won']);

        list($wonWeekMap, $monthWon, $wonYearMap)
            = $this->statusFilters($statusWonFilter, $wonWeekMap, $monthWon, $wonYearMap);

        // Status Lost Filter
        $statusLostFilter = $this->dealStatusPluckFilter($deals, $this->statuses['status_lost']);

        list($lostWeekMap, $monthLost, $lostYearMap)
            = $this->statusFilters($statusLostFilter, $lostWeekMap, $monthLost, $lostYearMap);


        // Total Filter
        $totalFilter = $this->dealStatusPluckFilter($deals);

        list($totalWeekMap, $monthTotal, $totalYearMap)
            = $this->statusFilters($totalFilter, $totalWeekMap, $monthTotal, $totalYearMap);


        $dealsOverview = [];

        if (\request()->has('last_seven_days') || \request()->has('this_week') || \request()->has('last_week')) {
            array_push(
                $dealsOverview,
                $openWeekMap,
                $wonWeekMap,
                $lostWeekMap,
                $totalWeekMap
            );
        } elseif (\request()->has('this_month') || \request()->has('last_month')) {
            array_push(
                $dealsOverview,
                collect($month)->values(),
                collect($monthWon)->values(),
                collect($monthLost)->values(),
                collect($monthTotal)->values()
            );
        } elseif (\request()->has('this_year') || \request()->has('total')) {
            array_push(
                $dealsOverview,
                $openYearMap,
                $wonYearMap,
                $lostYearMap,
                $totalYearMap
            );
        }

        return [
            'deal_over_view' => $dealsOverview,
            'total_deal_overview' => $totalDeal,
            'open_deal' => $openDeal,
            'won_deal' => $wonDeal,
            'lost_deal' => $lostDeal,
        ];
    }

    public function dealStatusCount($deals, $status = null)
    {
        return $deals
            ->when($status, function ($query) use ($status) {
                return $query->where('status_id', $status);
            })->when(!$status, function ($query) use ($status) {
                return $query->whereNotNull('status_id');
            })->count();
    }

    public function dealStatusPluckFilter($deals, $status = null)
    {
        return $deals
            ->when($status, function ($query) use ($status) {
                return $query->where('status_id', $status);
            })->pluck('created_at');
    }

    public function statusFilters($filters, $WeekMap, $month, $YearMap)
    {

        foreach ($filters as $value) {
            if (\request()->has('last_seven_days') || \request()->has('this_week') || \request()->has('last_week')) {
                ++$WeekMap[Carbon::parse($value)->dayOfWeek];
            } elseif (\request()->has('this_month') || \request()->has('last_month')) {
                ++$month[Carbon::parse($value)->day];
            } elseif (\request()->has('this_year') || \request()->has('total')) {
                ++$YearMap[Carbon::parse($value)->month - 1];
            }
        }
        return [$WeekMap, $month, $YearMap];
    }

    public function dealsCountByStatus($status)
    {
        return Deal::filters($this->filter)->where('status_id', $status)->count();
    }

    public function getEachObjectivesProgress()
    {
        // Fetch all objectives with their key results
        $objectives = Objective::with('keyResults')->get();

        // dd($objectives);
        // Calculate progress for each objective
        $objectivesProgress = $objectives->map(function ($objective) {
            // Calculate the progress of each key result
            $keyResultsProgress = $objective->keyResults->map(function ($keyResult) {
                $initial = $keyResult->initial_value;
                $target = $keyResult->target_value;
                $current = $keyResult->current_value;

                // Avoid division by zero
                if ($target - $current == 0) {
                    $progress = 100;
                } else {
                    $progress = (($current - $initial) / ($target - $initial)) * 100;
                }

                return $progress;
            });



            // Calculate the average progress for the objective
            $objectiveProgress = $keyResultsProgress->avg();

            return [
                'objective' => $objective,
                'progress' => $objectiveProgress,
                'title' => $objective->title, // Add objective name here
            ];
        });

        return $objectivesProgress;
    }


             function getLastSixMonthsKeyResults()
        {
            // Define the time period for the past 6 months
            $startDate = Carbon::now()->subMonths(6)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
            
            // Get the names of the last 6 months
            $months = [];
            for ($i = 5; $i >= 0; $i--) {
                array_push($months, Carbon::now()->subMonths($i)->format('M'));
            }
        
            // Query the KeyResult table for entries created within the last 6 months
            $keyResults = KeyResult::whereBetween('created_at', [$startDate, $endDate])->get();
        
            // Initialize an empty array to hold key results with completion percentages
            $keyResultsWithCompletion = [];
        
            // Calculate the completion percentage for each key result
            foreach ($keyResults as $keyResult) {
                $initialValue = $keyResult->initial_value;
                $targetValue = $keyResult->target_value;
                $currentValue = $keyResult->current_value;
        
                $completionPercentage = 0;
                if ($targetValue > $initialValue) {
                    $completionPercentage = (($currentValue - $initialValue) / ($targetValue - $initialValue)) * 100;
                }
        
                array_push($keyResultsWithCompletion, [
                    'title' => $keyResult->title,
                    'completion_percentage' => $completionPercentage
                ]);
            }
        
            // Return the month names and the key results with their completion percentages
            return [
                'months' => $months,
                'keyResults' => $keyResultsWithCompletion
            ];
        }
            public function getActionsRates()
        {
            // Define the time period for the past 6 months
            $startDate = Carbon::now()->subMonths(6)->startOfDay();
            $endDate = Carbon::now()->endOfDay();

            // Calculate the total number of actions created and completed in the specified period
            $totalActionsCreated = Action::whereBetween('created_at', [$startDate, $endDate])->count();
            $totalActionsDone = Action::whereNotNull('isdone')->whereBetween('isdone', [$startDate, $endDate])->count();

            // Calculate the number of days, weeks, months, and years in the specified period
            $totalDays = $startDate->diffInDays($endDate);
            $totalWeeks = $startDate->diffInWeeks($endDate);
            $totalMonths = $startDate->diffInMonths($endDate);
            $totalYears = $startDate->diffInYears($endDate);

            // Calculate the rates per day, per week, per month, and per year
            $rateActionsCreatedPerDay = $totalDays > 0 ? $totalActionsCreated / $totalDays : 0;
            $rateActionsDonePerDay = $totalDays > 0 ? $totalActionsDone / $totalDays : 0;

            $rateActionsCreatedPerWeek = $totalWeeks > 0 ? $totalActionsCreated / $totalWeeks : 0;
            $rateActionsDonePerWeek = $totalWeeks > 0 ? $totalActionsDone / $totalWeeks : 0;

            $rateActionsCreatedPerMonth = $totalMonths > 0 ? $totalActionsCreated / $totalMonths : 0;
            $rateActionsDonePerMonth = $totalMonths > 0 ? $totalActionsDone / $totalMonths : 0;

            $rateActionsCreatedPerYear = $totalYears > 0 ? $totalActionsCreated / $totalYears : 0;
            $rateActionsDonePerYear = $totalYears > 0 ? $totalActionsDone / $totalYears : 0;

            // Return the rates
            return [
                'rateActionsCreatedPerDay' => round($rateActionsCreatedPerDay, 2),
                'rateActionsDonePerDay' => round($rateActionsDonePerDay, 2),
                'rateActionsCreatedPerWeek' => round($rateActionsCreatedPerWeek, 2),
                'rateActionsDonePerWeek' => round($rateActionsDonePerWeek, 2),
                'rateActionsCreatedPerMonth' => round($rateActionsCreatedPerMonth, 2),
                'rateActionsDonePerMonth' => round($rateActionsDonePerMonth, 2),
                'rateActionsCreatedPerYear' => round($rateActionsCreatedPerYear, 2),
                'rateActionsDonePerYear' => round($rateActionsDonePerYear, 2),
            ];
        }

 
    public function getObjectivesProgress()
    {
        // Fetch all objectives with their key results
        $objectives = Objective::with('keyResults')->get();

        // Initialize a collection to hold all key results progress
        $allKeyResultsProgress = collect();

        // Calculate progress for each objective and accumulate key result progress
        $objectives->each(function ($objective) use (&$allKeyResultsProgress) {
            if ($objective->keyResults->isEmpty()) {
                // Log if no key results are found for the objective
                \Log::info('No Key Results for Objective:', ['objective_id' => $objective->id]);
                return;
            }

            // Calculate the progress of each key result
            $keyResultsProgress = $objective->keyResults->map(function ($keyResult) {
                $initial = $keyResult->initial_value;
                $target = $keyResult->target_value;
                $current = $keyResult->current_value;

               

                // Avoid division by zero
                if ($target - $current == 0) {
                    return 100;
                } else {
                    return (($current - $initial) / ($target - $initial)) * 100;
                }
            });

            // Filter out any null or invalid progress values
            $validKeyResultsProgress = $keyResultsProgress->filter(function ($progress) {
                return !is_null($progress) && $progress >= 0;
            });

          

            // Merge the valid key results progress into the overall collection
            $allKeyResultsProgress = $allKeyResultsProgress->merge($validKeyResultsProgress);
        });


        // Calculate the overall progress
        $overallProgress = $allKeyResultsProgress->isEmpty() ? null : $allKeyResultsProgress->avg();

        // Log overall progress for debugging
        \Log::info('Overall Progress:', ['overall_progress' => $overallProgress]);

        return [
            'overall_progress' => $overallProgress,
        ];
    }

    public function totalOrganization()
    {
        return Organization::count();
    }
    public function totalObjectives()
    {
        return Objective::count();
    }
    public function totalKeyResults()
    {
        return KeyResult::count();
    }
    public function totalActions()
    {
        return Action::count();
    }



    public function totalPeople()
    {
        return Person::count();
    }

    public function totalParticipation()
    {
        return \DB::table('activity_participant')->distinct('person_id')->count();
    }

    public function totalEmployee()
    {
        return User::where('status_id', '=', '1')->get()->count();
    }

    public function totalOwner()
    {
        return Deal::distinct('owner_id')->pluck('owner_id');
    }

    public function totalCollaborator()
    {
        return \DB::table('activity_collaborator')->distinct('user_id');
    }

    public function bothProposal($status = null)
    {
        return Proposal::when($status, function ($query) use ($status) {
            return $query->where('status_id', $status);
        })->count();
    }

    public function pipeline($request = null)
    {
        return $request ?
            Pipeline::withCount(['deals' => function ($query) use ($request) {
                $query->where('status_id', $request);
            }])->get()
            :
            Pipeline::count();
    }

    public function topFiveOwners($status)
    {
        return User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'Client');
        })
            ->withCount(['deals'])
            ->where('status_id', $status)
//            ->orwhereNotNull('first_name')
//            ->orwhereNotNull('last_name')
            ->limit(5)
            ->orderBy('deals_count', 'DESC')
            ->get();
    }

    public function getStatus()
    {
        return Status::where('type', 'deal')
            ->orWhere('type', 'proposal')
            ->orWhere('type', 'user')
            ->pluck('id', 'name');
    }
}
