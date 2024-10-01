<!-- Apply Modal -->
<div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyModalLabel">Apply for Opportunity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <!-- Short Opportunity Info Section -->
                <div class="p-4 mb-3 bg-white">
                    <h3 class="h5 text-black mb-3">Short Opportunity Info</h3>
                    <p>Company name: {{$opportunity->organization->name ?? ''}}</p>
                    <p>Address: {{$opportunity->address}}</p>
                    <p>Employment Type: {{ Str::ucfirst($opportunity->type) }}</p>
                    <p>Position: {{ Str::ucfirst($opportunity->position) }}</p>
                    <p>Posted: {{$opportunity->created_at->diffForHumans()}}</p>
                    <p>Last date to apply: {{ date('F d, Y', strtotime($opportunity->last_date)) }}</p>
                </div>

                <!-- Job Requirements Section -->
                <div class="p-4 mb-3 bg-light">
                    <h3 class="h5 text-black mb-3">Job Requirements</h3>
                    @if(!empty($opportunity->requirements))
                        <ul>
                            @foreach($opportunity->requirements as $requirement)
                                <li>{{ $requirement }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>No specific requirements mentioned.</p>
                    @endif
                </div>

                <!-- Confirmation Section -->
                <div class="alert alert-warning">
                    <strong>Note:</strong> Please confirm that you meet the above requirements before applying.
                </div>

                <!-- Application Form -->
                <form id="applyForm" method="POST" action="{{ route('opportunity.apply', ['id' => $opportunity->id]) }}">
                    @csrf

                    <!-- Title -->
                    <div class="form-group">
                        <label for="opportunityTitle">{{ __('Title') }}</label>
                        <input type="text" name="title" class="form-control" id="opportunityTitle" value="{{ $opportunity->title }}" readonly>
                    </div>

                    <!-- Organization -->
                    <div class="form-group">
                        <label for="opportunityOrganization">{{ __('For This Organization') }}</label>
                        <input type="text" name="organization" class="form-control" id="opportunityOrganization" value="{{ $opportunity->organization->name ?? '' }}" readonly>
                    </div>

                    <!-- Position -->
                    <div class="form-group">
                        <label for="opportunityPosition">{{ __('Position') }}</label>
                        <input type="text" name="position" class="form-control" id="opportunityPosition" value="{{ $opportunity->position }}" readonly>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="opportunityDescription">{{ __('Description') }}</label>
                        <textarea name="description" class="form-control" id="opportunityDescription" readonly>{{ $opportunity->description }}</textarea>
                    </div>

                    <!-- Salary -->
                    <div class="form-group">
                        <label for="opportunitySalary">{{ __('Salary') }}</label>
                        <input type="text" name="salary" class="form-control" id="opportunitySalary" value="${{ $opportunity->salary }}" readonly>
                    </div>

                    <!-- Roles -->
                    <div class="form-group">
                        <label for="opportunityRoles">{{ __('Roles') }}</label>
                        <input type="text" name="roles" class="form-control" id="opportunityRoles" value="{{ $opportunity->roles }}" readonly>
                    </div>

                    <!-- Experience -->
                    <div class="form-group">
                        <label for="opportunityExperience">{{ __('Experience') }}</label>
                        <input type="text" name="experience" class="form-control" id="opportunityExperience" value="{{ $opportunity->experience }}" readonly>
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label for="opportunityAddress">{{ __('Address') }}</label>
                        <input type="text" name="address" class="form-control" id="opportunityAddress" value="{{ $opportunity->address }}" readonly>
                    </div>

                    <!-- Number of Vacancies -->
                    <div class="form-group">
                        <label for="opportunityVacancies">{{ __('Number of Vacancies') }}</label>
                        <input type="text" name="number_of_vacancy" class="form-control" id="opportunityVacancies" value="{{ $opportunity->number_of_vacancy }} vacancies" readonly>
                    </div>

                    <!-- Confirm Application Checkbox -->
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="confirmCheck" required>
                        <label class="form-check-label" for="confirmCheck">I confirm that I meet the job requirements.</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>
