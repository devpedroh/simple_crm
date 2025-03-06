<template>
    <v-app id="dashboard">
        <v-navigation-drawer
            class="dashboard-drawer"
            v-model="drawerInfo"
            floating
            app
        >
            <div class="dashboard-logo">
                <img src="../../static/img/logo_dash_black.png" alt="logo" width="100" height="100" class="img-fluid">
            </div>

            <dashboard-sidebar></dashboard-sidebar>
        </v-navigation-drawer>

        <dashboard-navbar></dashboard-navbar>

        <v-main class="dashboard-main">
            <slot />
        </v-main>

        <div class="blackdrop" v-if="this.$store.getters['DashboardAlert/getAlertData'].blackdrop"></div>

        <alert />
    </v-app>
</template>

<script>
import DashboardSidebar from '@/components/dashboard/Sidebar.vue'
import DashboardNavbar from '@/components/dashboard/Navbar.vue'
import Alert from '@/components/alert/index.vue'
import {mapState} from "vuex";

export default {
    name: 'DashboardTemplate',
    components: {
        DashboardSidebar,
        DashboardNavbar,
        Alert
    },
    data () {
        return {

        }
    },
    computed: {
        ...mapState("DashboardDrawer", ["drawer"]),

        drawerInfo: {
            get () {
                return this.drawer;
            },
            set (value) {
                this.$store.commit("DashboardDrawer/setDrawer", value);
            }
        },
    },
    mounted () {
        document.querySelectorAll(".card-status .v-card .v-card__text h5").forEach(el => {
            let words = el.innerText.split(" ");
            if (words.length > 1) {
                el.setAttribute("data-first-word", words[0]);
                el.setAttribute("data-rest", words.slice(1).join(" "));
                el.innerHTML = "";
            }
        });
    }
}
</script>

<style scoped>

#dashboard:not(:has(.v-navigation-drawer--open)) .dashboard-main {
    padding: 64px 0px 0px 0px !important;
}
#dashboard:not(:has(.v-navigation-drawer--open)) .dashboard-toolbar {
    left: 8px !important;
}
#dashboard .dashboard-main {
    padding: 64px 8px 0px 248px !important;
}

#dashboard .dashboard-drawer {
    background: #F5F6FB;
    color: #A5A4AA;
    padding: 0 24px;
}
#dashboard .dashboard-drawer .v-navigation-drawer__border {
    background-color: #FFFFFF !important;
}
#dashboard .dashboard-drawer .dashboard-logo {
    display: flex;
}
#dashboard .dashboard-drawer .dashboard-user {
    background: #F5F6FB;
    text-align: center;
    color: #A5A4AA;
}
#dashboard .dashboard-drawer .v-icon,
#dashboard .dashboard-user .v-icon  {
    color: #A5A4AA;
}

#dashboard .dashboard-main ::v-deep .v-card {
    border-radius: 32px;
}

#dashboard ::v-deep .card-status .v-card .v-card__text {
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #9F8F92;
}
#dashboard ::v-deep .card-status .v-card .v-card__text .v-icon {
    font-size: 48px;
}
#dashboard ::v-deep .card-status .v-card .v-card__text h5 {
    display: flex;
    flex-direction: column;
    font-weight: bold;
    color: #9F8F92 !important;
}
#dashboard ::v-deep .card-status .v-card .v-card__text h5::before {
    content: attr(data-first-word);
    font-weight: inherit;
}
#dashboard ::v-deep .card-status .v-card .v-card__text h5::after {
    content: attr(data-rest);
}
#dashboard ::v-deep .card-status .v-card .v-card__text h3 {
    font-weight: bold;
    color: #544548 !important;
}
#dashboard ::v-deep .card-status .col-12 .v-card {
    background: #F5F6FA;
}
#dashboard ::v-deep .card-status .col-12 .v-card .v-icon {
    background: #ddd;
}
#dashboard ::v-deep .card-status .col-12:nth-of-type(1) .v-card {
    background: #ffebee;
}
#dashboard ::v-deep .card-status .col-12:nth-of-type(2) .v-card {
    background: #f3e5f5;
}
#dashboard ::v-deep .card-status .col-12:nth-of-type(3) .v-card {
    background: #e3f2fd;
}
#dashboard ::v-deep .card-status .col-12:nth-of-type(4) .v-card {
    background: #e8f5e9;
}
#dashboard ::v-deep .card-status .col-12 .v-card .v-icon {
    color: #fff;
    border-radius: 30%;
    padding: 10px;
}
#dashboard ::v-deep .card-status .col-12:nth-of-type(1) .v-card .v-icon {
    background: #ef5350;
}
#dashboard ::v-deep .card-status .col-12:nth-of-type(2) .v-card .v-icon {
    background: #ab47bc;
}
#dashboard ::v-deep .card-status .col-12:nth-of-type(3) .v-card .v-icon {
    background: #42a5f5;
}
#dashboard ::v-deep .card-status .col-12:nth-of-type(4) .v-card .v-icon {
    background: #66bb6a;
}

#dashboard ::v-deep .v-card:not(:has(.v-card__title)) .v-card__text {
    padding-top: 24px
}

#dashboard .v-btn {
    border-radius: 16px;
}

#dashboard .blackdrop {
    position: absolute;
    width: 100vw;
    height: 100vh;
    background: #F5F6FB;
    opacity: .5;
    z-index: 999;
}

</style>
