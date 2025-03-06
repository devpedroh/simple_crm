<template>
    <v-app-bar app class="dashboard-toolbar">
        <v-app-bar-nav-icon @click="changeDrawer()"></v-app-bar-nav-icon>

        <v-toolbar-title>{{ moment(new Date()).format('LLLL').substring(0, (moment(new Date()).format('LLLL')).length-9) }}</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-avatar
                    class="ml-4"
                    color="#B622B5"
                    size="40"
                    v-bind="attrs"
                    v-on="on"
                >
                    <v-icon color="#fff">mdi-account-circle</v-icon>
                </v-avatar>
            </template>

            <v-card>
                <v-card-text class="dashboard-toolbar-menu">
                    <a class="dashboard-toolbar-link" @click="logout">
                        <v-icon>mdi-logout</v-icon> Deslogar
                    </a>
                </v-card-text>
            </v-card>
        </v-menu>
    </v-app-bar>
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: 'DashboardNavbar',
    data () {
        return {

        }
    },
    methods: {
        changeDrawer: function () {
            this.$store.commit("DashboardDrawer/setDrawer", !this.drawer);
        },
        logout: function (e) {
            e.preventDefault()

            this.$store.commit('DashboardAlert/setAlert', {
                value: true,
                data: {
                    text: 'Encerrando sessão! Favor, aguarde...',
                    type: 'info',
                    timeout: 0,
                    blackdrop: true,
                }
            })
            this.$http.post('/api/auth/logout', {}, {
                headers: {
                    Authorization: "Bearer " + this.$cookies.get('auth_token')
                }
            }).then(response => {
                if (response.data.cod === 200) {
                    this.$store.commit('DashboardAlert/setAlert', {
                        value: true,
                        data: {
                            text: 'Deslogado com sucesso!',
                            type: 'success',
                            blackdrop: true,
                        }
                    })
                    setTimeout(() => {
                        this.$store.commit('AuthUser/setUser', '')
                        this.$store.commit('AuthUser/setUserToken', '')
                        this.$cookies.remove('auth_token');
                        this.$router.push({ name: 'AuthLogin' })
                    }, 2200)
                } else {
                    this.$store.commit('DashboardAlert/setAlert', {
                        value: true,
                        data: {
                            text: response.data.error,
                            type: 'error'
                        }
                    })
                }
            }).catch(err => {
                this.$store.commit('DashboardAlert/setAlert', {
                    value: true,
                    data: {
                        text: 'Não foi possível concluir sua solicitação! Favor, tente novamente mais tarde...',
                        type: 'error'
                    }
                })
                console.clear()
            });
        }
    },
    computed: {
        ...mapState("DashboardDrawer", ["drawer"]),
    }
}
</script>

<style scoped>

#dashboard .dashboard-toolbar {
    background: #F5F6FB;
    color: #A5A4AA;
    box-shadow: none;
    left: 252px !important;
}

#dashboard .dashboard-toolbar .v-icon {
    color: #A5A4AA;
}
#dashboard .dashboard-toolbar .dashboard-toolbar-link {
    display: flex;
    align-items: center;
    align-content: center;
    color: #A5A4AA;
    text-transform: capitalize;
    transition: .5s;
}
#dashboard .dashboard-toolbar .dashboard-toolbar-link:hover,
#dashboard .dashboard-toolbar .dashboard-toolbar-link:active,
#dashboard .dashboard-toolbar .dashboard-toolbar-link:focus {
    color: #B622B5 !important;
}

.dashboard-toolbar-menu {
    display: flex;
    flex-direction: column;
}
.dashboard-toolbar-menu .dashboard-toolbar-link {
    display: flex;
    align-items: center;
    align-content: center;
    margin-bottom: 24px;
    color: #A5A4AA;
    text-transform: capitalize;
}
.dashboard-toolbar-menu .dashboard-toolbar-link:last-of-type {
    margin-bottom: 0;
}
.dashboard-toolbar-menu .dashboard-toolbar-link .v-icon {
    margin-right: 8px;
    color: #A5A4AA;
}

</style>
