<template>
    <div>
        <form @submit="formSubmit">
            <button v-if="show && !loading" type="submit" class="w-100 btn btn-success">
                Apply For Opportunity
            </button>
            <div v-if="loading" class="spinner-border text-success" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div v-else-if="!show" class="alert alert-success">
                Application sent successfully.
            </div>
            <div v-if="error" class="alert alert-danger">
                Failed to send application. Please try again.
            </div>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: ["opportunityid"],
    data() {
        return {
            show: true,
            loading: false,
            error: false,
        };
    },
    methods: {
        formSubmit(e) {
            e.preventDefault();
            this.loading = true;
            this.error = false;

            axios
                .post(`/jobfinder/applications/${this.opportunityid}`, {})
                .then(() => {
                    this.show = false;
                    this.loading = false;
                })
                .catch(() => {
                    this.error = true;
                    this.loading = false;
                });
        },
    },
};
</script>
