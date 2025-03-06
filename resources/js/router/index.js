import Vue from 'vue';
import VueRouter from 'vue-router';

import store from '../store/index.js';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../views/auth/Login.vue'),
    },
    {
        path: '/login',
        name: 'AuthLogin',
        component: () => import('../views/auth/Login.vue'),
    },
    {
        path: '/register',
        name: 'AuthRegister',
        component: () => import('../views/auth/Register.vue'),
    },

    {
        path: '/dashboard',
        name: 'DashboardHome',
        component: () => import('../views/dashboard/Home.vue'),
    },

    {
        path: '/dashboard/clients',
        name: 'DashboardClients',
        component: () => import('../views/dashboard/clients/List.vue'),
    },
    {
        path: '/dashboard/clients/create',
        name: 'DashboardClientsCreate',
        component: () => import('../views/dashboard/clients/Create.vue'),
    },
    {
        path: '/dashboard/clients/edit/:id',
        name: 'DashboardClientsEdit',
        component: () => import('../views/dashboard/clients/Edit.vue'),
    },

    {
        path: '/dashboard/suppliers',
        name: 'DashboardSuppliers',
        component: () => import('../views/dashboard/suppliers/List.vue'),
    },
    {
        path: '/dashboard/suppliers/create',
        name: 'DashboardSuppliersCreate',
        component: () => import('../views/dashboard/suppliers/Create.vue'),
    },
    {
        path: '/dashboard/suppliers/edit/:id',
        name: 'DashboardSuppliersEdit',
        component: () => import('../views/dashboard/suppliers/Edit.vue'),
    },

    {
        path: '/dashboard/products',
        name: 'DashboardProducts',
        component: () => import('../views/dashboard/products/List.vue'),
    },
    {
        path: '/dashboard/products/create',
        name: 'DashboardProductsCreate',
        component: () => import('../views/dashboard/products/Create.vue'),
    },
    {
        path: '/dashboard/products/edit/:id',
        name: 'DashboardProductsEdit',
        component: () => import('../views/dashboard/products/Edit.vue'),
    },

    {
        path: '/dashboard/sells',
        name: 'DashboardSells',
        component: () => import('../views/dashboard/sells/List.vue'),
    },
    {
        path: '/dashboard/sells/create',
        name: 'DashboardSellsCreate',
        component: () => import('../views/dashboard/sells/Create.vue'),
    },
    {
        path: '/dashboard/sells/edit/:id',
        name: 'DashboardSellsEdit',
        component: () => import('../views/dashboard/sells/Edit.vue'),
    },
];

const router = new VueRouter({
    mode: 'history',
    routes,
});

import axios from 'axios';
router.beforeResolve((to, from, next) => {
    let array = to.path.replace('https://', '').replace('http://', '').split('/');
    let token = Vue.prototype.$cookies.get('auth_token');

    if (to.path) {
        if (array[1] === 'dashboard') {
            if (token && !store.getters['AuthUser/getToken']) {
                axios.get('/api/auth/user', {
                    headers: {
                        Authorization: "Bearer " + token
                    }
                }).then(response => {
                    if (response.data.cod === 200) {
                        store.commit('AuthUser/setUser', response.data.user);
                        store.commit('AuthUser/setUserToken', token);
                    } else {
                        store.commit('AuthUser/setUser', '');
                        store.commit('AuthUser/setUserToken', '');
                        Vue.prototype.$cookies.remove('auth_token')
                        router.push({ name: 'AuthLogin' });
                    }

                    next();
                }).catch(err => {
                    console.clear()
                    store.commit('AuthUser/setUser', '');
                    store.commit('AuthUser/setUserToken', '');
                    Vue.prototype.$cookies.remove('auth_token')
                    router.push({ name: 'AuthLogin' });
                    next();
                })
            } else {
                next();
            }
        } else if (array[1] !== 'dashboard') {
            if (token) {
                axios.get('/api/auth/user', {
                    headers: {
                        Authorization: "Bearer " + token
                    }
                }).then(response => {
                    if (response.data.cod === 200) {
                        store.commit('AuthUser/setUser', response.data.user);
                        store.commit('AuthUser/setUserToken', token);
                        router.push({ name: 'DashboardHome' });
                    } else {
                        Vue.prototype.$cookies.remove('auth_token')
                    }

                    next();
                }).catch(err => {
                    console.clear()
                    store.commit('AuthUser/setUser', '');
                    store.commit('AuthUser/setUserToken', '');
                    Vue.prototype.$cookies.remove('auth_token')
                    router.push({ name: 'AuthLogin' });
                    next();
                })
            } else {
                next();
            }
        }
    }
});

export default router;
