<template>
    <app-modal modal-id="view-user-modal"
               modal-size="default" modal-alignment="top"
               @close-modal="closeModal">
        <template slot="header">

            <h5 class="modal-title">{{ role.name }} : {{ $t('permission') }}</h5>
            <button type="button" class="close outline-none" data-dismiss="modal" aria-label="Close">
                <span>
                    <app-icon :name="'x'"></app-icon>
                </span>
            </button>
        </template>

        <template slot="body">
            <template v-if="role.name === 'App Admin'">
                <p>
                    Sys admin (Application administrator) performs all admin activities and has full management access.
                    Also
                    can add & configure application settings, create users through users invitation & assign a role with
                    application permissions
                </p>
                <p class="mt-3">
                    N.B: Remember that your application must have at least one individually assigned App admin. If you
                    just
                    have one individually assigned super admin, you can't edit or revoke their admin permissions.
                </p>
            </template>
            <template v-if="role.name === 'Manager'">
                <p>
                    Managers perform user-related activities for specific modules of the application. Managers can view
                    and manage(add/edit/delete) as well as all Participants, Onboardings, Proposals, Activities & Reports. Also can
                    view a presentation of these data in the dashboard.
                </p>
            </template>
            <template v-if="role.name === 'Agent'">
                <p>
                    Partner has a fixed set of permissions, but there are also restrictions on what this role can do.
                </p>

               <p>Parner have the following permissions:</p>

                <ol>
                    <li> Can view Dashboard (Only his/her onboardings related data).</li>
                    <li> Can add Participant person and Organization (manage his/her own created person and Organization).
                    </li>
                    <li>Can view & use Participant  groups.</li>
                    <li>Can view & use the Pipeline/Kanban view.</li>
                    <li>Can add onboardings for his/her person and organization.</li>
                    <li>Can manage and comment only on his/her own created onboarding.</li>
                    <li>Can view and use rejected reasons.</li>
                    <li>Can send proposals to his/her own participant of an onboarding.</li>
                    <li>Can create activities within his/her own person, Organizations and onboardings.</li>
                </ol>

            </template>
            <template v-if="role.name === 'Client'">
                <p>
                    Candidates (Participants) have view and communication access to most data in the application. You can manage
                    Participants by inviting as "Ccandidate" users from the <b>Participants (Person)</b> module action.
                </p>
                <p>
                    Candidate can view the following:
                </p>
                <ol>
                    <li>Can view Dashboard (Only his/her onboardings related data).</li>
                    <li>Can view organizations that he/she belongs to.</li>
                    <li>Can view his/her own onboardings and comment on these onboardings.</li>
                    <li>Can view proposals list and Kanban view.</li>
                </ol>
            </template>
        </template>

        <template slot="footer">
            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" @click.prevent="closeModal">
                {{ $t('close') }}
            </button>
        </template>
    </app-modal>
</template>

<script>

import {FormSubmitMixin} from "../../../../Mixins/Global/FormSubmitMixin";

export default {
    name: "ViewModal",
    mixins: [FormSubmitMixin],
    props: {
        role: {}
    },
    computed: {
    getRoleDisplayName() {
      switch (this.role.name) {
        case 'App Admin':
          return 'Sys Admin';
        case 'Manager':
          return 'Director';
        case 'Agent':
          return 'Agent Display Name'; // Replace with the desired name
        case 'Client':
          return 'Client Display Name'; // Replace with the desired name
        default:
          return this.role.name;
        }
        }
    },
    data() {
        return {
            formData: {}
        }
    },
}
</script>

