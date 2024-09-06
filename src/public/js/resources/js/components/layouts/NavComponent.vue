<template>

        <a class="nav-link link" href="#">
                <i class="fa fa-bell-o" aria-hidden="true"></i>
                <div class="notification-badge" v-if="count!=0">{{ count }}</div>
        </a>

</template>

<script>

    export default {
        data() {
          return {
                count: 0,
          }
        },
        mounted() {
            this.notifyCount();
        },
        methods: {
            notifyCount(){
                axios.get('/count')
                    .then(response => {
                        this.count = response.data;
                        console.log(this.count);
                    });
            },
        }
    }
</script>
