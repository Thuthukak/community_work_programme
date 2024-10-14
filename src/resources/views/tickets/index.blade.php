@extends('layouts.home')

@section('title', 'Post Opportunities')

@section('style')
<!-- Add your custom styles if any -->
@endsection

@section('contents')

@include('Apply.postOpportunity')
@include('Apply.newOpportunity')
@include('auth.register')
@include('auth.loginModal')

<div class="container my-5">

    <h2 class="center mb-3">Recently Posted Opportunities</h2>
    

    <div class="create-project-btn ml-auto " style="left:0">
    @auth
        <!-- If user is authenticated, show Post Opportunity button -->
        <button class="btn btn-primary btn-sm p-2" data-toggle="modal" data-target="#postOpportunityModal">{{ trans('Post Opportunity') }}</button>
    @else
        <!-- If user is not authenticated, show Login button -->
        <div class="nav-item nl-border">
          <a class="btn btn-warning btn-sm p-2 "href="javascript:void(0);" data-toggle="modal" data-target="#loginModal">{{ __('Login to Post') }}</a>
        </div>
        @endauth
    </div>

    <!-- Opportunities Table -->
    <div class="datatable mt-3 ">
    <div class="table-responsive">    
    <table class="table table-sm table-hover" style="width: 100%;">
        <thead>
        <tr style="border-bottom: 1px solid var(--default-border-color);">
                <th class="datatable-th">Title</th>
                <th class="datatable-th">Position</th>
                <th class="datatable-th">Organization</th>
                <th class="datatable-th">Type</th>
                <th class="datatable-th">Vacancies</th>
                <th class="datatable-th">Salary</th>
                <th class="datatable-th">Experience (Years)</th>
                <th class="datatable-th">Last Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($opportunities as $opportunity)
            <tr style="border-bottom: 1px solid var(--default-border-color);">
                <!-- Link the opportunity title to the opportunity's detailed view -->
                <td class="datatable-td">
                    <a href="{{ route('opportunity.show', $opportunity) }}">
                        {{ $opportunity->title }}
                    </a>
                </td>
                
                <td class="datatable-td">{{ $opportunity->position }}</td>
                
                <!-- Link the organization name to the organization detail view -->
                <td class="datatable-td">
                    @if($opportunity->organization)
                        <a href="{{ route('organizations.edit', $opportunity->organization_id) }}">
                            {{ $opportunity->organization->name }}
                        </a>
                    @else
                        N/A
                    @endif
                </td>
                
                <td class="datatable-td">{{ ucfirst($opportunity->type) }}</td>
                <td class="datatable-td">{{ $opportunity->number_of_vacancy }}</td>
                <td class="datatable-td">{{ $opportunity->salary }}</td>
                <td class="datatable-td">{{ $opportunity->experience }}</td>
                <td class="datatable-td">{{ $opportunity->last_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    </div>

    <div class="create-project-btn ml-auto mt-3" style="left:0">
         <button class="btn btn-info btn-sm p-2 text-white" >{{ trans('View more...') }}</button>
    </div>

    <!-- Job Posts Section -->
    <h2 class="center mt-5">Recent Job Posts</h2>


    @if(session('success'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif  



    <div class="create-project-btn ml-auto" style="left:0">
    @auth
        <!-- If user is authenticated, show Post Opportunity button -->
        <div class="create-opportunity-btn ml-auto" style="left:0">
         <button class="btn btn-warning btn-sm p-2" data-toggle="modal" data-target="#newOpportunityModal">{{ trans('Create a new opportunity') }}</button>
    </div>   
     @else
        <!-- If user is not authenticated, show Login button -->
        <div class="login nl-border">
         <a class="btn btn-warning btn-sm p-2 "href="javascript:void(0);" data-toggle="modal" data-target="#loginModal">{{ __('Login to create an Opportunity') }}</a>
    </div>
    @endauth
    </div>
    <!-- Job Posts Table -->
    <div class="datatable mt-3">
    <div class="table-responsive">
        <table class="table table-sm table-hover" style="width: 100%;">
        <thead>
            <tr style="border-bottom: 1px solid var(--default-border-color);">
                <th class="datatable-th">Title</th>
                <th class="datatable-th">Description</th>
                <th class="datatable-th">Status</th>
                <th class="datatable-th">Created At</th>
            </tr>
        </thead>
        <tbody>
    @if($jobPosts->isEmpty())
        <tr>
            <td colspan="4" style="text-align: center; padding: 20px;">
                No recent jobs
            </td>
        </tr>
    @else
        @foreach ($jobPosts as $jobPost)
            <tr style="border-bottom: 1px solid var(--default-border-color);">
                <td class="datatable-td">
                    <a href="{{ route('adminPostShow', $jobPost->id) }}">
                        {{ $jobPost->title }}
                    </a>
                </td>
                <td class="datatable-td">{{ Str::limit($jobPost->description, 50) }}</td>
                <td class="datatable-td">{{ ucfirst($jobPost->status) }}</td>
                <td class="datatable-td">{{ $jobPost->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    @endif
</tbody>

    </table>
    </div>
    </div>

    <div class="View-more-Posts-btn ml-auto" style="left:0">
         <button class="btn btn-warning btn-sm p-2"  >{{ trans('View more...') }}</button>
    </div>
</div>
@endsection

<script>
    // Automatically show the toast if it exists
    const toastElList = [].slice.call(document.querySelectorAll('.toast'));
    const toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl);
    });
    toastList.forEach(toast => toast.show());
</script>

<style>

@import "variables";
@import "theme-colors";

.datatable {
  .table-responsive {
    min-height: 400px;
    background-color: var(--default-card-bg);

    &::-webkit-scrollbar {
      height: 8px;
    }

    &::-webkit-scrollbar-thumb {
      background-color: lighten($brand-color, 20);

      &:hover {
        background-color: lighten($brand-color, 15);
      }
    }

    &::-webkit-scrollbar-track {
      background-color: var(--base-color);
    }
  }

  table {
    margin-bottom: 0;
    color: var(--default-font-color);

    thead {
      th {
        &.datatable-th {
          border: 0;
          padding: 2rem 1rem;
          color: #6c757d !important;
          vertical-align: top !important;

          &:first-child {
            padding-left: $default-padding-margin;
          }

          &:last-child {
            padding-right: $default-padding-margin;
          }

          .btn {
            width: 100%;
            padding: 0;

            &:hover {
              color: $brand-color !important;
            }

            svg {
              width: 14px;
              height: 14px;
            }
          }
        }
      }
    }

    tbody {
      tr {
        td {
          &.datatable-td {
            vertical-align: middle;
            padding: 1rem 1rem;
            border-color: var(--default-border-color);

            &:first-child {
              padding-left: $default-padding-margin;
            }

            &:last-child {
              padding-right: $default-padding-margin;
            }

            svg {
              height: 14px;
            }

            &.table-action {
              display: flex;
              justify-content: flex-end;
            }
          }
        }
        tfoot {
          tr {
            height: auto; /* Ensures the row auto-adjusts based on content */
          }
    
          th {
            padding: 1.5rem 1rem; /* Same padding as tbody rows */
            vertical-align: middle;
          }
        }

        /*&:last-child {
          td {
            &.datatable-td {
              padding-bottom: 0;
            }
          }
        }*/
      }
    }
  }
}

// Responsive Datatable
.table-view-responsive {
  @media only screen and (max-width: 767px) {
    table, thead, tbody, th, td, tr {
      display: block;
    }
    thead {
      tr {
        display: none;
      }
    }
    tr {
      border: 1px solid var(--default-border-color);

      &:first-child {
        border-bottom: 0;
        border-top-left-radius: $default-radius;
        border-top-right-radius: $default-radius;
      }

      &:last-child {
        border-top: 0;
        border-bottom-left-radius: $default-radius;
        border-bottom-right-radius: $default-radius;
      }

      td {
        border: 0;
        padding: 1rem 1.5rem !important;
        white-space: normal;

        &.table-action {
          display: block !important;
        }

        &:before {
          width: 45%;
          font-weight: bold;
          display: inline-block;
          content: attr(data-title);
        }
      }
    }
  }
}

// Empty Data Block
.no-data-found-wrapper {
  img {
    width: 150px;
    opacity: var(--not-found-opacity);
  }
}

// Highlighting Table Row
.highlighted {
  background-color: var(--base-color);

  td {
    background-color: var(--base-color);;
  }
}

// Context Menu
.bulk-floating-action-wrapper {
  z-index: 1031;
  position: fixed;
  top: 44px;
  right: 0;
  left: 0;

  @extend .dropdownAnimation;

  .actions {
    margin: 0 auto;
    width: fit-content;
    box-shadow: var(--default-box-shadow);
    background-color: var(--btn-light-bg);

    .dropdown {
      margin: 0 -2px;

      &.btn-dropdown {
        .dropdown-toggle {
          padding: 0.8rem;
          box-shadow: none;
          color: $default-secondary-color;

          &::after {
            content: '';
            margin: 0;
          }

          &:hover {
            color: $brand-color;
          }

          svg {
            stroke-width: 1.5;
          }
        }
      }

      .dropdown-toggle {
        border-radius: 0;
      }

      &:first-child {
        .dropdown-toggle {
          border-radius: $default-radius 0 0 $default-radius;
        }
      }

      &:last-child {
        .dropdown-toggle {
          border-radius: 0 $default-radius $default-radius 0;
        }
      }

      &.show {
        .dropdown-toggle {
          color: $white !important;
          background-color: $brand-color !important;
        }
      }

      .dropdown-menu {
        min-width: max-content;

        .dropdown-item {
          white-space: initial;
          padding: 1rem 2rem 1rem 2rem !important;
        }

        &.search-and-select {
          position: initial;
          right: initial;
          box-sizing: border-box;
          border-radius: $default-radius;
          box-shadow: var(--default-box-shadow);

          .dropdown-search-result-wrapper {
            padding: 0.8rem 0;
            max-height: 320px;
            overflow-y: auto;

            .dropdown-item {
              font-size: 95% !important;
              color: $forms-input-text-color;
              padding: 1rem 2rem 1rem 2rem !important;

              &.active {
                color: $forms-input-text-color !important;
                background-color: var(--base-color) !important;
              }

              &.selected {
                color: $forms-input-text-color !important;
                background-color: var(--base-color) !important;

                .check-sign {
                  display: block;
                }
              }

              &:hover {
                background-color: var(--base-color) !important;
                color: $forms-input-text-color !important;
              }
            }
          }

          a {
            .check-sign {
              display: none;
            }
          }
        }

        &.dropdown-menu-with-search {
          width: 280px;
          min-width: 280px;
          max-width: 280px;
        }

        @media (min-width: 575px) {
          top: auto !important;
          @keyframes dropdownAnimation {
            from {
              opacity: 0;
              transform: translate3d(0, -30px, 0);
            }

            to {
              opacity: 1;
              transform: translate3d(0, 0px, 0);
            }
          }

          animation-name: dropdownAnimation;
          animation-duration: 0.25s;
          animation-fill-mode: both;
        }
        @media (max-width: 575px) {
          top: 0 !important;
        }
      }

      .dropdown-search-result-wrapper {
        max-height: 320px;
        overflow-y: auto;
      }
    }
  }
}

// For datable expandable column
.table-expanded-column {
  .expandable-btn {
    transition: .5s;

    &[aria-expanded="true"] {
      transform: rotateX(180deg);
    }
  }
}

.cursor-default {
  cursor: default !important;
}

.table-expandable-area {
  td {
    padding: 0 !important;
    border-top: 0 !important;
  }
}

@media only screen and (max-width: 767px) {
  .table-view-responsive {
    .table-expandable-area {
      border-top: 0 !important;
      border-bottom: 0 !important;

      td {
        padding: 0 !important;

        &:before {
          display: none !important;
        }
      }
    }
  }
}

// Datatable helper classes
.remove-datatable-x-padding {
  .datatable {
    table {
      thead {
        th {
          &:first-child {
            padding-left: 0;
          }

          &:last-child {
            padding-right: 0;
          }
        }
      }

      tbody {
        tr {
          td {
            &:first-child {
              padding-left: 0;
            }

            &:last-child {
              padding-right: 0;
            }
          }
        }
      }
    }
  }
}




</style>
