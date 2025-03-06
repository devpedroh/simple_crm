<template>
    <v-app id="auth">
        <v-main class="auth-main">
            <v-container>
                <slot />
            </v-container>
        </v-main>

        <div class="blackdrop" v-if="this.$store.getters['DashboardAlert/getAlertData'].blackdrop"></div>

        <alert />
    </v-app>
</template>

<script>
import Alert from '@/components/alert/index.vue'

export default {
    name: 'DashboardTemplate',
    components: {
        Alert
    },
    data () {
        return {

        }
    },
    computed: {

    },
    mounted () {

    }
}
</script>

<style scoped>

::v-deep .container {
    padding: 0 !important;
}

#auth .auth-main {
    width: 100vw;
    height: 100vh;
    background: #F5F6FB;
    color: #A5A4AA;
    overflow: hidden;
}

#auth .auth-main .container {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    align-content: center;
}

#auth .blackdrop {
    position: absolute;
    width: 100vw;
    height: 100vh;
    background: #F5F6FB;
    opacity: .5;
    z-index: 999;
}

#auth ::v-deep .auth-main .v-card {
    width: 600px;
    border-radius: 24px;
    text-align: center;
}
#auth ::v-deep .auth-main .v-card .v-card__title {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

#auth ::v-deep .auth-main .v-card .form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
#auth ::v-deep .auth-main .v-card .form-actions .form-texts {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}

</style>
