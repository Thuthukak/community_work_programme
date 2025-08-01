<template>
    <app-modal
        modal-id="activity-modal"
        modal-size="large"
        modal-alignment="top"
        @close-modal="closeModal"
    >
        <template slot="header">
            <h5 class="modal-title">
                {{ selectedUrl ? $t("edit_activity") : $t("add_activity") }}
            </h5>

            <button
                type="button"
                class="close outline-none"
                data-dismiss="modal"
                aria-label="Close"
            >
        <span>
          <app-icon :name="'x'"></app-icon>
        </span>
            </button>
        </template>
        <template slot="body">
            <form
                ref="form"
                :data-url="selectedUrl ? selectedUrl : route(`activities.store`)"
                v-if="dataLoaded"
            >
                <div class="form-group">
                    <div class="form-row">
                        <label class="mb-0 col-sm-2 d-flex align-items-center">{{
                                $t("activity")
                            }}</label>
                        <div class="col-sm-10">
                            <app-input
                                type="radio-buttons"
                                :required="true"
                                :list="activityTypeList"
                                v-model="activityId"
                            />
                            <small class="text-danger" v-if="errors.activity_type_id">{{
                                    errors.activity_type_id[0]
                                }}</small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <label class="mb-0 col-sm-2 d-flex align-items-center">{{
                                $t("title")
                            }}</label>
                        <div class="col-sm-10">
                            <app-input
                                type="text"
                                :required="true"
                                :placeholder="$t('title')"
                                v-model="formData.title"
                            />
                            <small class="text-danger" v-if="errors.title">{{
                                    errors.title[0]
                                }}</small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <label class="mb-0 col-sm-2">{{ $t("description") }}</label>
                        <div class="col-sm-10">
                            <app-input
                                type="textarea"
                                :text-area-rows="5"
                                :placeholder="$t('description_here')"
                                v-model="formData.description"
                            />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <label class="col-sm-2 mb-0 d-flex align-items-center">{{
                                $t("set_schedule")
                            }}</label>
                        <div class="col-sm-10">
                            <div class="row mb-1">
                                <div class="col-lg-7 pr-lg-0">
                                    <app-input
                                        type="date"
                                        :popover-position="'top-start'"
                                        :placeholder="$t('start_date')"
                                        v-model="formData.started_at"
                                        @input="setEndDateAsStartDate"
                                    />
                                    <small class="text-danger" v-if="errors.started_at">{{
                                            errors.started_at[0]
                                        }}</small>
                                </div>
                                <div class="col-lg-5 pl-lg-0 time-picker-dd-pos">
                                    <app-input
                                        type="time"
                                        :placeholder="$t('start_time')"
                                        v-model="startTime"
                                        @input="setStart($event)"
                                    />
                                    <small class="text-danger" v-if="errors.start_time">{{
                                            errors.start_time[0]
                                        }}</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-7 pr-lg-0">
                                    <app-input
                                        type="date"
                                        :popover-position="'top-start'"
                                        :min-date="formData.started_at"
                                        :placeholder="$t('end_date')"
                                        v-model="formData.ended_at"
                                    />
                                    <small class="text-danger" v-if="errors.ended_at">{{
                                            errors.ended_at[0]
                                        }}</small>
                                </div>
                                <div class="col-lg-5 pl-lg-0 time-picker-dd-pos">
                                    <app-input
                                        type="time"
                                        :placeholder="$t('end_time')"
                                        v-model="endTime"
                                        @input="setEnd($event)"
                                    />
                                    <small class="text-danger" v-if="errors.end_time">{{
                                            errors.end_time[0]
                                        }}</small>
                                </div>
                            </div>
                            <div class="mt-2 schedule-default-time-slot">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-light btn-with-shadow font-size-90 rounded-pill"
                                    :class="{ active: activePreset == 15 }"
                                    @click="setPreset(15)"
                                >
                                    00:15 H
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-light btn-with-shadow font-size-90 rounded-pill"
                                    :class="{ active: activePreset == 30 }"
                                    @click="setPreset(30)"
                                >
                                    00:30 H
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-light btn-with-shadow font-size-90 rounded-pill"
                                    :class="{ active: activePreset == 45 }"
                                    @click="setPreset(45)"
                                >
                                    00:45 H
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-light btn-with-shadow font-size-90 rounded-pill"
                                    :class="{ active: activePreset == 600 }"
                                    @click="setPreset(600)"
                                >
                                    10:00 H
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity change input -->
                <div class="form-group">
                    <div class="form-row">
                        <label class="mb-0 col-sm-2 d-flex align-items-center">{{
                                $t("activity_type")
                            }}</label>
                        <div class="col-sm-10">
                            <app-input
                                type="select"
                                list-value-field="title"
                                :list="setTypeActivity"
                                :placeholder="$t('choose_your_activity_type')"
                                :required="true"
                                v-model="formData.type_of_activity"
                                @input="activityTypeChanged"
                            />
                        </div>
                    </div>
                </div>
                <!-- end of Activity change input -->

                <!-- deal input -->
                <div class="form-group" v-if="formData.type_of_activity == '1'">
                    <div class="form-row">
                        <label class="mb-0 col-sm-2 d-flex align-items-center">{{
                                $t("deal")
                            }}</label>
                        <div class="col-sm-10">
                            <app-input
                                v-model="formData.contextable_id"
                                :options="dealsOptions"
                                :placeholder="$t('choose_a_deal')"
                                type="search-and-select"
                                :error-message="$errorMessage(errors, 'contextable_id')"
                            />
                        </div>
                    </div>
                    <!-- deal media object input -->
                    <div class="form-group mt-2" v-if="dealChange">
                        <div class="form-row">
                            <label class="mb-0 col-sm-2 d-flex align-items-center"></label>
                            <template v-if="formData.contextable_id">
                                <div class="col-sm-5">
                                    <app-media-object
                                        :title="dealChange.owner.full_name"
                                        :mediaTitle="dealChange.owner.full_name"
                                        :mediaSubtitle="'Owner'"
                                        :imgUrl="
                      dealChange.owner.profile_picture
                        ? urlGenerator(dealChange.owner.profile_picture.path)
                        : dealChange.owner.profile_picture
                    "
                                    />
                                </div>
                                <div class="col-sm-5" v-if="dealChange.contextable">
                                    <app-media-object
                                        :title="dealChange.contextable.name"
                                        :mediaTitle="dealChange.contextable.name"
                                        :mediaSubtitle="dealChange.contextable.contact_type['name']"
                                        :imgUrl="
                      dealChange.contextable.profile_picture
                        ? urlGenerator(
                            dealChange.contextable.profile_picture.path
                          )
                        : urlGenerator(`/images/${leadType}.png`)
                    "
                                    />
                                </div>
                                <div class="pt-4" v-else>
                                    <p class="text-muted font-size-90 mb-2">
                                        {{ $t("no_lead_added") }}
                                    </p>
                                </div>
                            </template>
                        </div>
                    </div>
                    <!-- end of deal media object input -->
                </div>
                <!-- end of deal input -->

                <!-- Person input -->
                <div class="form-group" v-else-if="formData.type_of_activity == '2'">
                    <div class="form-row">
                        <label class="mb-0 col-sm-2 d-flex align-items-center">{{
                                $t("person")
                            }}</label>
                        <div class="col-sm-10">
                            <app-input
                                v-model="formData.contextable_id"
                                :options="personsOptions"
                                :placeholder="$t('choose_a_contact_person')"
                                type="search-and-select"
                                :error-message="$errorMessage(errors, 'contextable_id')"
                            />

                        </div>
                    </div>
                </div>
                <!-- end of Person input -->

                <!-- Organization input -->
                <div class="form-group" v-else-if="formData.type_of_activity == '3'">
                    <div class="form-row">
                        <label class="mb-0 col-sm-2 d-flex align-items-center">{{
                                $t("organization")
                            }}</label>
                        <div class="col-sm-10">
                            <app-input
                                v-model="formData.contextable_id"
                                :options="organizationOptions"
                                :placeholder="$t('choose_an_organization')"
                                type="search-and-select"
                                :error-message="$errorMessage(errors, 'contextable_id')"
                            />
                        </div>
                    </div>
                </div>
                <!-- end of Organization input -->

                <!-- Participants input -->
                <div class="form-group">
                    <div class="form-row">
                        <label class="mb-0 col-sm-2 d-flex align-items-center">{{
                                $t("participants")
                            }}</label>
                        <div class="col-sm-10">
                            <app-paginated-multi-select
                                :options="personSelectOptions"
                                v-model="formData.person_id"
                            />
                        </div>
                    </div>
                </div>
                <!-- end of Participants input -->

                <!-- Collaborators input -->
                <div class="form-group">
                    <div class="form-row">
                        <label class="mb-0 col-sm-2 d-flex align-items-center">{{
                                $t("collaborators")
                            }}</label>
                        <div class="col-sm-10">
<!--                            <app-input-->
<!--                                type="multi-select"-->
<!--                                :list="ownerList"-->
<!--                                list-value-field="full_name"-->
<!--                                v-model="formData.owner_id"-->
<!--                                :is-animated-dropdown="true"-->
<!--                            />-->

                            <app-paginated-multi-select
                                :options="ownerSelectOptions"
                                v-model="formData.owner_id"
                            />
                        </div>
                    </div>
                </div>
                <!-- end of Collaborators input -->

                <!-- Activity reminder -->
                <div class="form-group">
                    <div class="form-row">
                        <label class="mb-0 col-sm-2 d-flex align-items-center">{{ $t("set_reminder") }}</label>
                        <div class="col-sm-5">
                            <app-input
                                type="select"
                                list-value-field="title"
                                :list="setReminderType"
                                :placeholder="$t('choose_your_activity_type')"
                                v-model="formData.reminder_type"
                            />
                            <small class="text-danger" v-if="errors.reminder_type">{{
                                    errors.reminder_type[0]
                                }}</small>
                        </div>
                        <div class="col-sm-5" v-if="formData.reminder_type == 'custom'">
                            <app-input
                                type="date"
                                date-mode="dateTime"
                                :min-date="new Date()"
                                :max-date="formData.started_at"
                                :placeholder="$t('set_reminder')"
                                v-model="formData.reminder_on"
                            />
                            <small class="text-danger" v-if="errors.reminder_on">{{
                                    errors.reminder_on[0]
                                }}</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <app-note :notes="reminderNotification"
                                      :show-title="false"
                                      :content-type="'html'"
                                      class="mt-2"
                                      note-type="note-warning"/>
                        </div>
                    </div>
                </div>
                <!-- End of Activity reminder -->
                <div class="form-group">
                    <div class="form-row">
                        <label class="mb-0 col-sm-2 d-flex align-items-center">{{
                                $t("save_as_done")
                            }}</label>
                        <div class="mt-2 col-sm-10">
                            <app-input
                                type="single-checkbox"
                                :list-value-field="$t(' ')"
                                v-model="formData.activity_done"
                            />
                        </div>
                    </div>
                </div>
            </form>
            <app-overlay-loader v-else/>
        </template>
        <template slot="footer">
            <button
                type="button"
                class="btn btn-secondary mr-2"
                data-dismiss="modal"
                @click.prevent="closeModal"
            >
                {{ $t("cancel") }}
            </button>
            <button type="button" class="btn btn-primary" @click.prevent="submit">
        <span class="w-100">
          <app-submit-button-loader v-if="loading"></app-submit-button-loader>
        </span>
                <template v-if="!loading">{{ $t("save") }}</template>
            </button>
        </template>
    </app-modal>
</template>

<script>
import {FormMixin} from "@core/mixins/form/FormMixin";
import {collect} from "@app/Helpers/Collection";
import {mapGetters} from "vuex";
import moment from "moment";
import {
    formatted_date,
    formatted_time,
    time_format,
    urlGenerator,
} from "@app/Helpers/helpers";
import {formatDateTimeForServer} from "../../../Helpers/helpers";
import { axiosGet } from "../../../Helpers/AxiosHelper";

export default {
    name: "ActivityModal",
    mixins: [FormMixin],
    props: {
        tableId: String,
        previousData: Boolean,
        setDate: Object,
        selectData: Object,
    },
    data() {
        return {
            reminderNotification: [
                `${this.$t('activity_cron_job_note')} <a href="https://pipex.gainhq.com/documentation/important-settings.html#scheduler-queue" target="_blank">
                                <app-icon name="alert-circle" class="size-18 mr-2"/>
                                ${this.$t('see_documentation')}</a>`
            ],
            personsOptions: {
                url: route('selectable.persons'),
                query_name: "name", // by default 'search'
                per_page: 10, // must need to set min 10 per page for showing scrollbar
                params: {},
                loader: "app-pre-loader", // by default 'app-overlay-loader'
                modifire: (item) => ({ id: item.id, value: item.name }),
            },
            organizationOptions: {
                url: route('selectable.organisations'),
                query_name: "name", // by default 'search'
                per_page: 10, // must need to set min 10 per page for showing scrollbar
                params: {},
                loader: "app-pre-loader", // by default 'app-overlay-loader'
                modifire: (item) => ({ id: item.id, value: item.name }),
            },
            dealsOptions: {
                url: route('selectable.deals'),
                query_name: "name", // by default 'search'
                per_page: 10, // must need to set min 10 per page for showing scrollbar
                params: {},
                loader: "app-pre-loader", // by default 'app-overlay-loader'
                modifire: (item) => ({ id: item.id, value: item.title }),
            },
            route,
            urlGenerator,
            formData: {
                activity_type: null,
                title: "",
                description: "",
                started_at: new Date(),
                ended_at: new Date(),
                person_id: [],
                owner_id: [],
                type_of_activity: null,
                contextable_id: null,
                reminder_type: '',
                reminder_on: null,
            },
            ownerSelectOptions: {
                // url: route('crm.auth_user'),
                url: route('selectable.owners'),
                listValueField: "full_name",
                per_page: 10,
                loader: "app-pre-loader", // by default 'app-overlay-loader'
            },
            personSelectOptions: {
                url: route('selectable.persons'),
                listValueField: "name",
                per_page: 10,
                loader: "app-pre-loader", // by default 'app-overlay-loader'
            },
            addEditData: {},
            activityTypeList: [],
            errors: {},
            statusList: [],
            dataLoaded: false,
            loading: false,
            endTime: moment(new Date()).format(`${time_format()}`),
            startTime: moment(new Date())
                .subtract("15", "minutes")
                .format(`${time_format()}`),
            activityId: 1,
            activePreset: 15,
            dealChange: null
        };
    },
    computed: {
        ...mapGetters({
            ownerList: "getOwner",
            // organizationList: "getOrganization",
            // personList: "getPerson",
            // dealList: "getDeal",
            activityStatusList: "getActivityStatus",
        }),

        // dealChange() {
        //     return this.dealList.find(
        //         (deal) => deal.id == this.formData.contextable_id
        //     );
        // },
        leadType() {
            if (!this.dealChange) return '';
            return this.dealChange.contextable_type ==
            "App\\Models\\CRM\\Person\\Person"
                ? "person"
                : "org";
        },

        setTypeActivity() {
            return [
                {
                    id: 1,
                    title: this.$t("deal"),
                },
                {
                    id: 2,
                    title: this.$t("person"),
                },
                {
                    id: 3,
                    title: this.$t("organization"),
                },
            ];
        },

        setReminderType() {
            return [
                {
                    id: '',
                    title: this.$t("none"),
                },
                {
                    id: '15mins',
                    title: this.$t("15mins"),
                },
                {
                    id: '1hr',
                    title: this.$t("1hr"),
                },
                {
                    id: '1day',
                    title: this.$t("1day"),
                },
                {
                    id: 'custom',
                    title: this.$t("custom"),
                },
            ];
        },
    },
    created() {
        this.$store.dispatch("getActivityStatus");
    },
    mounted() {
        if (this.previousData) {
            this.formData.type_of_activity = Number(this.selectData.type_of_activity);
            this.activityId = this.selectData.activity_type_id
                ? Number(this.selectData.activity_type_id)
                : this.activityId;
            this.formData.contextable_id = this.selectData.contextable_id;
            this.formData.title = this.selectData.title;
            this.formData.activity_done = this.selectData.is_done_activity;
            this.dateFormate();
        }

        this.pipeline([this.getActivityType()])
            .then(() => {
                this.dataLoaded = true;
            })
            .catch((err) => console.log(err));

        //for setting up data if update action fired
        this.getDealChange();
    },
    methods: {
        getDealChange() {
            axiosGet(route('deals.show', 1))
                .then(res => this.dealChange = res.data)
                .catch(e => {
                    console.log(e)
                    this.$toastr.e('something_went_wrong');
                });
        },
        setEndDateAsStartDate() {
            // please no need to change this formation of date,
            // it is just use for check logic

            let s = moment(moment(this.formData.started_at).format("YYYY-MM-DD")),
                e = moment(moment(this.formData.ended_at).format("YYYY-MM-DD")),
                diff = e.diff(s, "days");

            if (this.dataLoaded && diff < 0) {
                this.formData.ended_at = this.formData.started_at;
            }
        },

        activityTypeChanged() {
            this.formData.contextable_id = null;
        },
        dateFormate() {
            // add new from calender view
            if (this.setDate) {
                this.activePreset = null;
                this.formData.started_at = new Date(this.setDate.start);
                this.formData.ended_at = new Date(this.setDate.end);
                this.endTime = moment(new Date(this.setDate.end)).format(
                    `${time_format()}`
                );
                this.startTime = moment(new Date(this.setDate.start)).format(
                    `${time_format()}`
                );
            }
        },
        setStart(v) {
            this.startTime = v;
            this.formData.start_time = v;
            this.activePreset = null;
            if (this.formData.started_at && this.formData.ended_at) {
                if (
                    this.formData.started_at.toDateString() ==
                    this.formData.ended_at.toDateString()
                ) {
                    this.endTime =
                        this.convertTime12to24(v) > this.convertTime12to24(this.endTime)
                            ? this.startTime
                            : this.endTime;
                }
            }
        },
        convertTime12to24(time12h) {
            if (formatted_time() == 24) {
                return time12h;
            }
            const [time, modifier] = time12h.split(" ");

            let [hours, minutes] = time.split(":");

            if (hours === "12") {
                hours = "00";
            }

            if (modifier === "PM") {
                hours = parseInt(hours, 10) + 12;
            }

            return `${hours}:${minutes}`;
        },
        setEnd(v) {
            this.endTime = v;
            this.formData.end_time = v;
            this.activePreset = null;
        },
        setPreset(diff) {
            this.formData.ended_at = this.formData.ended_at
                ? this.formData.ended_at
                : new Date();
            this.endTime = this.endTime
                ? this.endTime
                : moment(new Date()).format(`${time_format()}`);
            let dateTimeString =
                moment(this.formData.ended_at).format(`${formatted_date()}`) +
                " " +
                this.endTime;
            let formattedDate = moment(
                dateTimeString,
                `${formatted_date()} ${time_format()}`
            ).subtract(diff, "minutes");
            this.startTime = formattedDate.format(`${time_format()}`);
            this.formData.started_at = new Date(formattedDate);
            this.activePreset = diff;
        },
        afterSuccessFromGetEditData(response) {
            this.formData.activity_done =
                response.data.status.name == 'status_done' ? true : false;
            this.activePreset = null;
            this.formData.contextable_id = response.data.contextable_id;
            this.formData.description = response.data.description;
            this.formData.reminder_type = response.data.reminder_type;
            this.formData.reminder_on = new Date(moment(response.data.reminder_on).utc(true)
                .local())
            if (response.data.contextable_type) {
                let arr = response.data.contextable_type.split("\\");
                if (arr[arr.length - 1] == "Deal") {
                    this.formData.type_of_activity = 1;
                } else if (arr[arr.length - 1] == "Organization") {
                    this.formData.type_of_activity = 3;
                } else if (arr[arr.length - 1] == "Person") {
                    this.formData.type_of_activity = 2;
                }
            }
            this.formData.activity_type_id = response.data.activity_type.id;
            this.formData.title = response.data.title;
            this.activityId = response.data.activity_type.id;
            this.formData.owner_id =
                response.data.collaborators.length > 0
                    ? collect(response.data.collaborators).pluck("id")
                    : [];
            this.formData.person_id =
                response.data.participants.length > 0
                    ? collect(response.data.participants).pluck("id")
                    : [];

            let start = moment(response.data.started_at + ' ' + response.data.start_time).utc(true)
                .local()

            this.formData.started_at = response.data.started_at
                ? new Date(start)
                : "";
            this.startTime = response.data.start_time
                ? moment(start).format(`${time_format()}`)
                : "";

            let end = moment(response.data.ended_at + ' ' + response.data.end_time).utc(true)
                .local()

            this.formData.ended_at = response.data.ended_at
                ? new Date(end)
                : "";
            this.endTime = response.data.end_time
                ? moment(end).format(`${time_format()}`)
                : "";
            this.dataLoaded = true;
        },
        beforeSubmit() {
            this.loading = true;
        },
        submit() {
            let started_at = moment(this.formData.started_at).format(
                "YYYY-MM-DD"
            );
            let start_time = this.convertTime12to24(this.startTime);
            let start = formatDateTimeForServer(moment(started_at + ' ' + start_time, "YYYY-MM-DD HH:mm"))

            let ended_at = moment(this.formData.ended_at).format(
                "YYYY-MM-DD"
            );
            let end_time = this.convertTime12to24(this.endTime);
            let end = formatDateTimeForServer(moment(ended_at + ' ' + end_time, "YYYY-MM-DD HH:mm"))
            this.addEditData.title = this.formData.title;
            this.addEditData.activity_type_id = this.activityId;
            this.addEditData.description = this.formData.description;
            this.addEditData.reminder_type = this.formData.reminder_type;
            this.addEditData.reminder_on = formatDateTimeForServer(this.formData.reminder_on)
            this.addEditData.contextable_type = this.getContextableType();
            this.addEditData.contextable_id = this.formData.contextable_id;
            this.addEditData.started_at = moment(start).format(
                "YYYY-MM-DD"
            );
            this.addEditData.start_time = moment(start).format(
                "HH:mm"
            );
            this.addEditData.ended_at = moment(end).format(
                "YYYY-MM-DD"
            );
            this.addEditData.end_time = moment(end).format(
                "HH:mm"
            );
            this.addEditData.person_id = this.formData.person_id;
            this.addEditData.owner_id = this.formData.owner_id;

            this.addEditData.status_id = this.formData.activity_done
                ? collect(this.activityStatusList).where('name', '=', 'status_done').first().id
                : collect(this.activityStatusList).where('name', '=', 'status_todo').first().id;

            if (this.addEditData.started_at == this.addEditData.ended_at) {
                this.addEditData.start_time > this.addEditData.end_time
                    ? this.$toastr.e("End time should be over than start time")
                    : this.save(this.addEditData);
            } else {
                this.save(this.addEditData);
            }
        },
        pipeline(funcArr) {
            funcArr.forEach((obj) => {
                if (Promise.resolve(obj) !== obj) {
                    throw new Error(
                        "Expects all methods are passed in parameter array should return Promise"
                    );
                }
            });
            return Promise.all(funcArr);
        },
        getActivityType() {
            return this.axiosGet(route(`activity_types.index`))
                .then((response) => {
                    this.activityTypeList = this.collection(response.data.data).shaper(
                        "translated_name"
                    );
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getContextableType() {
            if (this.formData.type_of_activity == 1) {
                return "App\\Models\\CRM\\Deal\\Deal";
            } else if (this.formData.type_of_activity == 2) {
                return "App\\Models\\CRM\\Person\\Person";
            } else {
                return "App\\Models\\CRM\\Organization\\Organization";
            }
        },
        afterError(response) {
            this.loading = false;
            this.errors = response.data.errors;
        },
        afterSuccess(response) {
            this.$toastr.s(response.data.message);
            this.$hub.$emit("reload-" + this.tableId);
            this.$emit("save");
            this.closeModal();
        },
        afterFinalResponse() {
            this.loading = false;
        },
        closeModal() {
            this.$emit("cancel-modal");
            this.$emit("close-modal");
        },
    },
};
</script>

<style scoped lang="scss">
.schedule-default-time-slot {
    .active {
        color: #4466f2 !important;
        background-color: var(--base-color) !important;
        border-color: var(--default-border-color) !important;
    }
}
</style>
