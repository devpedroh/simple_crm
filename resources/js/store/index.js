import Vue from 'vue';
import Vuex from 'vuex';
import router from '../router'

import AuthUser from './modules/auth/user'

import DashboardAlert from './modules/dashboard/alert'
import DashboardDrawer from './modules/dashboard/drawer'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        AuthUser,

        DashboardAlert,
        DashboardDrawer,
    },
    state: {
        // routeList: router.options.routes || [],
    },
    mutations: {

    },
    actions: {

    },
    getters: {
        // getRoutePath: (state) => (name) => state.routeList.find((data) => data.name === name).path,
    },
});
