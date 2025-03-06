<template>
    <v-snackbar
        top right
        v-model="enabled"
        :timeout="this.alertData.timeout"
        :color="this.alertData.type"
        elevation="24"
        transition="scroll-x-transition"
    >
        {{ this.alertData.text }}

        <template v-slot:action="{ attrs }" v-if="this.alertData.canClose">
            <v-btn
                color="#fff"
                text
                plain
                v-bind="attrs"
                @click="closeAlert"
            >
                <v-icon>mdi-close-circle-outline</v-icon>
            </v-btn>
        </template>
    </v-snackbar>
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: 'Alert',
    methods: {
        closeAlert: function () {
            this.$store.commit('DashboardAlert/setAlert', false)
        }
    },
    computed: {
        ...mapState("DashboardAlert", ["alertData"]),

        enabled: {
            get () {
                return this.$store.getters['DashboardAlert/getAlert'];
            },
            set (value) {
                this.$store.commit('DashboardAlert/setAlert', value);
            }
        }
    }
}
</script>

<style scoped>

</style>
