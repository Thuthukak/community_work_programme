<template>
    <div>
        <sidebar :data="sidebarData" />
        <h1 class="page-header">
            <button v-if="canCreate" @click="goToCreatePage" class="btn btn-success pull-right">
                {{ $t('project.create') }}
            </button>
            {{ $t('project.index_title', { status }) }} 
            <small>{{ projects.total }} {{ $t('project.found') }}</small>
        </h1>
        <div class="well well-sm text-right">
            <div class="pull-left hidden-xs">
                @Include your index-nav-tabs component
                <index-nav-tabs />
            </div>
            <form @submit.prevent="searchProjects" class="form-inline">
                <input type="hidden" v-model="status_id" />
                <input type="text" v-model="searchQuery" class="form-control index-search-field" :placeholder="$t('project.search')" style="width:100%;max-width:350px" />
                <button type="submit" class="btn btn-info btn-sm">{{ $t('project.search') }}</button>
                <button @click="resetSearch" class="btn btn-default btn-sm">{{ $t('app.reset') }}</button>
            </form>
        </div>
        <div class="panel panel-default table-responsive">
            <table class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>{{ $t('app.table_no') }}</th>
                        <th>{{ $t('project.name') }}</th>
                        <th class="text-center">{{ $t('project.start_date') }}</th>
                        <th class="text-center">{{ $t('project.work_duration') }}</th>
                        <th v-if="status_id == 2" class="text-right">{{ $t('project.overall_progress') }}</th>
                        <th v-if="status_id == 2" class="text-center">{{ $t('project.due_date') }}</th>
                        <th v-if="canSeePricings" class="text-right">{{ $t('project.project_value') }}</th>
                        <th class="text-center">{{ $t('app.status') }}</th>
                        <th>{{ $t('project.customer') }}</th>
                        <th>{{ $t('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(project, key) in projects.data" :key="project.id">
                        <td>{{ projects.from + key }}</td>
                        <td>{{ project.nameLink }}</td>
                        <td class="text-center">{{ project.start_date }}</td>
                        <td class="text-right">{{ project.work_duration }}</td>
                        <td v-if="status_id == 2" class="text-right">{{ formatDecimal(project.getJobOveralProgress) }} %</td>
                        <td v-if="status_id == 2" class="text-center">{{ project.due_date }}</td>
                        <td v-if="canSeePricings" class="text-right">{{ formatMoney(project.project_value) }}</td>
                        <td class="text-center">{{ project.status }}</td>
                        <td>{{ project.customer.name }}</td>
                        <td>
                            <a :href="`/projects/${project.id}`" class="btn btn-info btn-xs" title="Show">
                                <i class="icon-search"></i>
                            </a>
                            <a :href="`/projects/${project.id}/edit`" class="btn btn-warning btn-xs" title="Edit">
                                <i class="icon-edit"></i>
                            </a>
                        </td>
                    </tr>
                    <tr v-if="!projects.data.length">
                        <td colspan="9">{{ status }} {{ $t('project.not_found') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <pagination :data="projects" @pagination-change-page="getProjects"></pagination>
    </div>
</template>

<script>
import Sidebar from '../../components/Layouts/Sidebar.vue';


export default {
    components: {
        Sidebar,
    },
    data() {
        return {
            projects: {},
            searchQuery: '',
            status_id: '',
            status: '',
            sidebarData: [
                {
                    icon: 'pie-chart',
                    name: 'Dashboard',
                    url: '/admin/dashboard',
                    subMenu: null,
                },
                {
                    icon: 'users',
                    name: 'Leads',
                    url: '#',
                    subMenu: [
                        { name: 'Persons', url: '/person/list' },
                        { name: 'Organizations', url: '/org/list' },
                        { name: 'Lead Groups', url: '/contact/type/list' },
                    ],
                },
                {
                    icon: 'clipboard',
                    name: 'Deals',
                    url: '#',
                    subMenu: [
                        { name: 'Pipeline View', url: '/deals/pipeline/view' },
                        { name: 'All Deals', url: '/deals/list/view' },
                        { name: 'Pipelines', url: '/pipelines/list/view' },
                        { name: 'Lost Reasons', url: '/lost/reasons/list/view' },
                    ],
                },
                {
                    icon: 'hexagon',
                    name: 'Proposals',
                    url: '#',
                    subMenu: [
                        { name: 'Proposal List', url: '/proposals/list/view' },
                        { name: 'Templates', url: '/template/view' },
                    ],
                },
                {
                    icon: 'activity',
                    name: 'Activities',
                    url: '#',
                    subMenu: [
                        { name: 'Calendar View', url: '/activities/calendar/view/' },
                        { name: 'Activity List', url: '/activities/list/view' },
                    ],
                },
                {
                    icon: 'clipboard',
                    name: 'Project Management',
                    url: '#',
                    subMenu: [
                        { name: 'Project List', url: '/projects' },
                        { name: 'Job List', url: '/jobs' },
                        { name: 'Subscriptions', url: '/subscriptions' },
                    ],
                },
                {
                    icon: 'dollar-sign',
                    name: 'Expenses',
                    url: '#',
                    subMenu: [
                        { name: 'Expenses', url: '/expenses/list' },
                        { name: 'Area of Expense', url: '/expenses-area/list' },
                    ],
                },
                {
                    icon: 'bar-chart',
                    name: 'Reports',
                    url: '#',
                    subMenu: [
                        { name: 'Deal', url: '/reports/deal' },
                        { name: 'Proposal', url: '/reports/proposal' },
                        { name: 'Pipeline', url: '/reports/pipeline' },
                    ],
                },
                {
                    icon: 'user-check',
                    name: 'User and Role',
                    url: '/users/list',
                    subMenu: null,
                },
                {
                    icon: 'settings',
                    name: 'Settings',
                    url: '/settings/page',
                    subMenu: null,
                },
            ],
            
        };
    },
    computed: {
        ...mapGetters(['canCreate', 'canSeePricings']),
    }, 
    methods: {
        getProjects(page = 1) {
            axios.get(`/projects?page=${page}`).then(response => {
                this.projects = response.data;
            });
        },
        searchProjects() {
            this.getProjects();
        },
        resetSearch() {
            this.searchQuery = '';
            this.getProjects();
        },
        goToCreatePage() {
            this.$inertia.visit('/projects/create');
        },
        formatDecimal(value) {
            return Number(value).toFixed(2);
        },
        formatMoney(value) {
            return new Intl.NumberFormat().format(value);
        },
    },
    mounted() {
        this.getProjects();
    },
};
</script>
import axios from 'axios';
import { mapGetters } from 'vuex';
import Sidebar from '../../components/Layouts/Sidebar.vue';


export default {
    components: {
        Sidebar,
    },
    data() {
        return {
            projects: {},
            searchQuery: '',
            status_id: '',
            status: '',
            sidebarData: [
                {
                    icon: 'pie-chart',
                    name: 'Dashboard',
                    url: '/admin/dashboard',
                    subMenu: null,
                },
                {
                    icon: 'users',
                    name: 'Leads',
                    url: '#',
                    subMenu: [
                        { name: 'Persons', url: '/person/list' },
                        { name: 'Organizations', url: '/org/list' },
                        { name: 'Lead Groups', url: '/contact/type/list' },
                    ],
                },
                {
                    icon: 'clipboard',
                    name: 'Deals',
                    url: '#',
                    subMenu: [
                        { name: 'Pipeline View', url: '/deals/pipeline/view' },
                        { name: 'All Deals', url: '/deals/list/view' },
                        { name: 'Pipelines', url: '/pipelines/list/view' },
                        { name: 'Lost Reasons', url: '/lost/reasons/list/view' },
                    ],
                },
                {
                    icon: 'hexagon',
                    name: 'Proposals',
                    url: '#',
                    subMenu: [
                        { name: 'Proposal List', url: '/proposals/list/view' },
                        { name: 'Templates', url: '/template/view' },
                    ],
                },
                {
                    icon: 'activity',
                    name: 'Activities',
                    url: '#',
                    subMenu: [
                        { name: 'Calendar View', url: '/activities/calendar/view/' },
                        { name: 'Activity List', url: '/activities/list/view' },
                    ],
                },
                {
                    icon: 'clipboard',
                    name: 'Project Management',
                    url: '#',
                    subMenu: [
                        { name: 'Project List', url: '/projects' },
                        { name: 'Job List', url: '/jobs' },
                        { name: 'Subscriptions', url: '/subscriptions' },
                    ],
                },
                {
                    icon: 'dollar-sign',
                    name: 'Expenses',
                    url: '#',
                    subMenu: [
                        { name: 'Expenses', url: '/expenses/list' },
                        { name: 'Area of Expense', url: '/expenses-area/list' },
                    ],
                },
                {
                    icon: 'bar-chart',
                    name: 'Reports',
                    url: '#',
                    subMenu: [
                        { name: 'Deal', url: '/reports/deal' },
                        { name: 'Proposal', url: '/reports/proposal' },
                        { name: 'Pipeline', url: '/reports/pipeline' },
                    ],
                },
                {
                    icon: 'user-check',
                    name: 'User and Role',
                    url: '/users/list',
                    subMenu: null,
                },
                {
                    icon: 'settings',
                    name: 'Settings',
                    url: '/settings/page',
                    subMenu: null,
                },
            ],
            
        };
    },
    computed: {
        ...mapGetters(['canCreate', 'canSeePricings']),
    }, 
    methods: {
        getProjects(page = 1) {
            axios.get(`/projects?page=${page}`).then(response => {
                this.projects = response.data;
            });
        },
        searchProjects() {
            this.getProjects();
        },
        resetSearch() {
            this.searchQuery = '';
            this.getProjects();
        },
        goToCreatePage() {
            this.$inertia.visit('/projects/create');
        },
        formatDecimal(value) {
            return Number(value).toFixed(2);
        },
        formatMoney(value) {
            return new Intl.NumberFormat().format(value);
        },
    },
    mounted() {
        this.getProjects();
    },
};
</script>

<style scoped>
/* Add any required styles */
</style>
