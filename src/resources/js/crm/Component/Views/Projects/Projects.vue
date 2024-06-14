<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-sm-12 col-md-6">
        <app-breadcrumb
          :page-title="$t('Projects')"
          :directory="[$t('Project'), $t('projects')]"
          :icon="'users'"
        />
      </div>
      <div class="col-sm-12 col-md-6">
        <div class="text-sm-right mb-primary mb-sm-0 mb-md-0">
          <div class="dropdown d-inline-block btn-dropdown">
            <div class="dropdown-menu"></div>
          </div>

          <button
            v-if="$can('create_project')"
            type="button"
            class="btn btn-primary btn-with-shadow"
            data-toggle="modal"
            @click.prevent="openModal()"
          >
            {{ $t("add_project") }}
          </button>
        </div>
      </div>
    </div>

    <app-table
      :id="tableId"
      :options="options"
      @action="getAction"
    />

    <project-create-edit-modal
      v-if="isProjectModalActive"
      :selected-url="selectedProjectUrl"
      :table-id="tableId"
      @close-modal="closeModal">
    </project-create-edit-modal>

    <app-confirmation-modal
      v-if="confirmationModalActive"
      modal-id="project-delete-modal"
      @cancelled="cancelled"
      @confirmed="confirmed"
    />
  </div>
</template>

<script>
import { DeleteMixin } from "../../../Mixins/Global/DeleteMixin";
import { getCustomFileds } from "../../../Mixins/Global/CustomFieldMixin";
import CoreLibrary from "../../../../core/helpers/CoreLibrary";
import axios from 'axios';
import { numberWithCurrencySymbol, textTruncate, formatDateToLocal } from "../../../Helpers/helpers";

export default {
  name: "Projects",
  extends: CoreLibrary,
  mixins: [
    DeleteMixin,
    getCustomFileds
  ],
  data() {
    return {
      route,
      isModalActive: false,
      selectedProjectUrl: '',
      isProjectModalActive: false,
      tableId: "project",
      confirmationModalActive: false,
      personId: null,
      selectedUrl: "",
      projects: [],
      commonColumn: [
        {
          title: this.$t('Project Name'),
          type: 'text',
          key: 'name',
        },
        {
          title: this.$t('start_date'),
          type: 'text',
          key: 'start_date',
          modifier: value => formatDateToLocal(value),
        },
        {
          title: this.$t('work_duration'),
          type: 'text',
          key: 'work_duration',
        },
        {
          title: this.$t('project_value'),
          type: 'text',
          key: 'project_value',
          modifier: value => numberWithCurrencySymbol(value),
          isVisible: () => this.$can('see_pricings')
        },
        {
          title: this.$t('status'),
          type: 'text',
          key: 'status',
        },
        {
          title: this.$t('customer'),
          type: 'text',
          key: 'customer',
          modifier: value => value?.name,
        },
        {
          title: this.$t('actions'),
          type: 'action',
          key: 'project',
          isVisible: true
        },
      ],
      options: {
        name: this.$t("project_table"),
        url: route("project.index"),
        showHeader: true,
        enableHighlights: false,
        enableSaveFilter: false,
        columns: this.commonColumn,
        filters: [
          {
            title: this.$t("date"),
            type: "range-picker",
            key: "date",
            option: ["today", "thisMonth", "last7Days", "thisYear"],
            permission: this.$can("view_project") ? true : false,
          },
          {
            title: this.$t("project_date"),
            type: "range-picker",
            key: "project_date",
            option: ["today", "thisMonth", "last7Days", "thisYear"],
            permission: this.$can("view_project") ? true : false,
          },
          {
            title: this.$t("created_by"),
            type: "search-and-select-filter",
            key: "created_by",
            settings: {
              url: route('selectable.owners'),
              modifire: (v) => {
                return { id: v.id, name: v.full_name }
              },
              per_page: 10,
              queryName: "name",
              loader: "app-pre-loader"
            },
            listValueField: "name"
          },
        ],
        showSearch: true,
        searchPlaceholder: 'Search by name',
        showFilter: true,
        paginationType: "pagination",
        enableRowSelect: false,
        responsive: true,
        rowLimit: 10,
        showAction: true,
        orderBy: "desc",
        actionType: "dropdown",
        actions: [
          {
            title: this.$t("edit"),
            icon: "edit",
            type: "modal",
            modifier: () => this.$can("update_project"),
          },
          {
            title: this.$t("view"),
            icon: "eye",
            type: "modal",
            modifier: () => this.$can("view_project"),
          },
        ],
        showCount: true,
        showClearFilter: true,
        data: [],
        enableCookie: false,
        datatableWrapper: 'datatable-wrapper',
      },
    };
  },
  methods: {
    getAction(rowData, actionObj, active) {
      if (actionObj.title == this.$t("edit")) {
        this.selectedProjectUrl = route("project.show", { id: rowData.id });
        this.isProjectModalActive = true;
      } else if (actionObj.title == this.$t("view")) {
        this.deleteUrl = route("project.show", { id: rowData.id });
        this.confirmationModalActive = true;
      }
    },

    openModal() {
      this.isProjectModalActive = true;
      $('#project-modal').modal('show');
    },
    closeModal() {
      this.isProjectModalActive = false;
      this.selectedUrl = "";
      this.selectedProjectUrl = '';
      $("#project-modal").modal("hide");
    },

    fetchData() {
      axios.get(this.options.url)
        .then(response => {
          this.projects = response.data.data;
          this.options.data = this.projects;
        })
        .catch(error => {
          console.error(error);
        });
    }
  },
  mounted() {
    this.getCustomFiled("project");
    this.fetchData();
  },
};
</script>

<style scoped>
/* Add your custom styles here */
</style>
