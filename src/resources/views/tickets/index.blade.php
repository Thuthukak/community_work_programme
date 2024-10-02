@extends('layouts.home')

@section('title', 'Post Opportunities')

@section('style')
<!-- Add your custom styles if any -->
@endsection

@section('contents')
@include('tickets.banner')
@include('Apply.postOpportunity')
@include('Apply.newOpportunity')

<div class="container">

    <h2 class="center">Recently Posted Opportunities</h2>
    

    <div class="create-project-btn ml-auto" style="left:0">
         <button class="btn btn-warning btn-sm p-2" data-toggle="modal" data-target="#postOpportunityModal">{{ trans('Post Opportunity') }}</button>
    </div>
    <!-- Opportunities Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Position</th>
                <th>Organization</th>
                <th>Type</th>
                <th>Vacancies</th>
                <th>Salary</th>
                <th>Experience (Years)</th>
                <th>Last Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($opportunities as $opportunity)
            <tr>
                <!-- Link the opportunity title to the opportunity's detailed view -->
                <td>
                    <a href="{{ route('opportunity.show', $opportunity->id) }}">
                        {{ $opportunity->title }}
                    </a>
                </td>
                
                <td>{{ $opportunity->position }}</td>
                
                <!-- Link the organization name to the organization detail view -->
                <td>
                    @if($opportunity->organization)
                        <a href="{{ route('organizations.show', $opportunity->organization_id) }}">
                            {{ $opportunity->organization->name }}
                        </a>
                    @else
                        N/A
                    @endif
                </td>
                
                <td>{{ ucfirst($opportunity->type) }}</td>
                <td>{{ $opportunity->number_of_vacancy }}</td>
                <td>{{ $opportunity->salary }}</td>
                <td>{{ $opportunity->experience }}</td>
                <td>{{ $opportunity->last_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Job Posts Section -->
    <h2 class="center">Recent Job Posts</h2>


    <div class="create-project-btn ml-auto" style="left:0">
         <button class="btn btn-warning btn-sm p-2" data-toggle="modal" data-target="#newOpportunityModal">{{ trans('Create a new opportunity') }}</button>
    </div>
    <!-- Job Posts Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobPosts as $jobPost)
            <tr>
                <!-- Link the job post title to the job post's detailed view -->
                <td>
                <a href="{{ route('adminPosts', $jobPost->id) }}">
                    {{ $jobPost->title }}
                </a>
                </td>
                
                <td>{{ Str::limit($jobPost->description, 50) }}</td>
                <td>{{ ucfirst($jobPost->status) }}</td>
                <td>{{ $jobPost->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
