<template>
    <div class="content-wrapper">
        <!-- Create New Project Button -->
        <div class="row mb-3">
            <div class="col-12 text-center">
                <header>
                <app-breadcrumb
                    :page-title="$t('Project List')"
                    :directory="[$t('Expense'), $t('expense')]"
                    :icon="'users'"
                />
                <a  :href="projects.create" class="btn btn-success btn-lg text-white ">
                    {{ $t("create_new_project") }}
                </a>
            </header>
            </div>
        </div>
        <!-- Project List Header -->
        <div class="row mb-3">
            <div class="col-12">
                <h2 class="text-center">
                    {{ $t("project_list") }} {{ projectCount }} {{ $t("projects_found") }}
                </h2>
            </div>
        </div>
        <!-- Project Filters -->
        <div class="row mb-3">
            <div class="col-12 text-center">
                <span class="badge badge-pill badge-warning">All Projects</span>
                <span class="badge badge-pill badge-warning">Planned</span>
                <span class="badge badge-pill badge-warning">Progress</span>
                <span class="badge badge-pill badge-warning">Done</span>
                <span class="badge badge-pill badge-warning">Closed</span>
                <span class="badge badge-pill badge-warning">Canceled</span>
                <span class="badge badge-pill badge-warning">On Hold</span>
            </div>
        </div>
        <!-- Project Search -->
        <div class="row mb-3">
            <div class="col-12 text-center">
                <input
                    type="text"
                    class="form-control d-inline-block"
                    placeholder="Search Projects"
                    style="width: 50%;"
                    v-model="searchQuery"
                />
                <button class="btn btn-primary ml-2" @click="searchProjects">{{ $t("search_projects") }}</button>
                <button class="btn btn-secondary ml-2" @click="resetSearch">{{ $t("reset") }}</button>
            </div>
        </div>
        <!-- Project List Table -->
        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $t("project_name") }}</th>
                            <th>{{ $t("start_date") }}</th>
                            <th>{{ $t("work_duration") }}</th>
                            <th>{{ $t("project_value") }}</th>
                            <th>{{ $t("status") }}</th>
                            <th>{{ $t("customer") }}</th>
                            <th>{{ $t("action") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="projects.length === 0">
                            <td colspan="8">{{ $t("project_not_found") }}</td>
                        </tr>
                        <tr v-for="(project, index) in projects" :key="project.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ project.name }}</td>
                            <td>{{ project.start_date }}</td>
                            <td>{{ project.work_duration }}</td>
                            <td>{{ project.value }}</td>
                            <td>{{ project.status }}</td>
                            <td>{{ project.customer }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary">{{ $t("edit") }}</button>
                                <button class="btn btn-sm btn-danger">{{ $t("delete") }}</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProjectList",
    data() {
        return {
            projects: [], // Your project data goes here
            projectCount: 0, // Your project count goes here
            searchQuery: ""
        };
    },
    methods: {
        searchProjects() {
            // Implement search functionality here
        },
        resetSearch() {
            this.searchQuery = "";
            // Implement reset functionality here
        }
    },
    mounted() {
        // Fetch your projects here
    },
    route(name, params = {}) {
            // Replace with your actual route generation logic, if not using Laravel's route function
            return this.$route('projects.create'); // Assuming you have Vue Router properly set up
        }
};
</script>

<style>
.content-wrapper {
    padding: 20px;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0,0,0,.05);
}

.text-center {
    text-align: center;
}

.btn-lg {
    padding: 10px 20px;
    font-size: 1.5rem;
}

.badge {
    cursor: pointer;
    margin: 0 5px;
}
</style>
