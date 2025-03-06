<template>
    <dashbord-template>
        <v-card>
            <v-card-text>
                <div class="card-status">
                    <div class="card-title-more">
                        <h4>Resumo</h4>
                        <h4>Mais</h4>
                    </div>

                    <v-row>
                        <v-col cols="12" sm="6" md="4" lg="3" xl="3">
                            <v-card>
                                <v-card-text>
                                    <div class="text">
                                        <h5>Cliente(s)</h5>
                                        <h3>{{ ('clients' in infos) ? infos.clients : '---' }}</h3>
                                        <small>{{ ('clients_today' in infos) ? infos.clients_today : '---' }} cadastrado(s) hoje</small>
                                    </div>

                                    <div class="icon">
                                        <v-icon>mdi-account-group-outline</v-icon>
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-col>

                        <v-col cols="12" sm="6" md="4" lg="3" xl="3">
                            <v-card>
                                <v-card-text>
                                    <div class="text">
                                        <h5>Fornecedor(es)</h5>
                                        <h3>{{ ('suppliers' in infos) ? infos.suppliers : '---' }}</h3>
                                        <small>{{ ('suppliers_today' in infos) ? infos.suppliers_today : '---' }} cadastrado(s) hoje</small>
                                    </div>

                                    <div class="icon">
                                        <v-icon>mdi-account-tie-outline</v-icon>
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-col>

                        <v-col cols="12" sm="6" md="4" lg="3" xl="3">
                            <v-card>
                                <v-card-text>
                                    <div class="text">
                                        <h5>Produto(s)</h5>
                                        <h3>{{ ('products' in infos) ? infos.products : '---' }}</h3>
                                        <small>{{ ('products_today' in infos) ? infos.products_today : '---' }} cadastrado(s) hoje</small>
                                    </div>

                                    <div class="icon">
                                        <v-icon>mdi-sale-outline</v-icon>
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-col>

                        <v-col cols="12" sm="6" md="4" lg="3" xl="3">
                            <v-card>
                                <v-card-text>
                                    <div class="text">
                                        <h5>Venda(s)</h5>
                                        <h3>{{ ('sells' in infos) ? infos.sells : '---' }}</h3>
                                        <small>{{ ('sells_today' in infos) ? infos.sells_today : '---' }} cadastrada(s) hoje</small>
                                    </div>

                                    <div class="icon">
                                        <v-icon>mdi-cart-outline</v-icon>
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </div>
            </v-card-text>
        </v-card>
    </dashbord-template>
</template>

<script>
import DashbordTemplate from '@/templates/Dashboard.vue'

export default {
    name: 'DashboardHome',
    components: {
        DashbordTemplate
    },
    data () {
        return {
            infos: []
        }
    },
    methods: {

    },
    created() {

        this.$http.get('/api/dashboard/home/get', {
            'headers': {
                Authorization: 'Bearer ' + this.$store.getters['AuthUser/getToken']
            }
        }).then(response => {
            if (response.data.cod === 200) {
                this.infos = response.data.data
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
}
</script>

<style scoped>

.v-card {
    margin-bottom: 2%;
}

.dashboard-card-fa h3 {
    color: #B622B5;
}
.dashboard-card-fa .v-card {
    border-radius: 16px !important;
}
.dashboard-card-fa .v-card,
.dashboard-card-fa .v-card .v-card__text {
    color: #fff;
    font-weight: bold;
}
.dashboard-card-fa .col:nth-of-type(2) .v-card {
    background-image: linear-gradient(
        to top,
        hsl(0, 100%, 60.98%) 0%,
        hsl(359.95, 99.86%, 61.12%) 8.1%,
        hsl(359.81, 99.47%, 61.5%) 15.5%,
        hsl(359.62, 98.84%, 62.05%) 22.5%,
        hsl(359.38, 98.01%, 62.7%) 29%,
        hsl(359.12, 96.99%, 63.42%) 35.3%,
        hsl(358.84, 95.83%, 64.14%) 41.2%,
        hsl(358.56, 94.54%, 64.85%) 47.1%,
        hsl(358.28, 93.19%, 65.52%) 52.9%,
        hsl(358.01, 91.81%, 66.13%) 58.8%,
        hsl(357.76, 90.47%, 66.67%) 64.7%,
        hsl(357.52, 89.22%, 67.14%) 71%,
        hsl(357.32, 88.13%, 67.51%) 77.5%,
        hsl(357.16, 87.27%, 67.8%) 84.5%,
        hsl(357.06, 86.7%, 67.98%) 91.9%,
        hsl(357.02, 86.5%, 68.04%) 100%
    );
}
.dashboard-card-fa .col:nth-of-type(3) .v-card {
    background-image: linear-gradient(
        to top,
        hsl(268.04, 100%, 60.98%) 0%,
        hsl(267.99, 99.86%, 61.12%) 8.1%,
        hsl(267.87, 99.47%, 61.5%) 15.5%,
        hsl(267.69, 98.84%, 62.05%) 22.5%,
        hsl(267.5, 98.01%, 62.7%) 29%,
        hsl(267.31, 96.99%, 63.42%) 35.3%,
        hsl(267.14, 95.83%, 64.14%) 41.2%,
        hsl(267, 94.54%, 64.85%) 47.1%,
        hsl(266.89, 93.19%, 65.52%) 52.9%,
        hsl(266.82, 91.81%, 66.13%) 58.8%,
        hsl(266.78, 90.47%, 66.67%) 64.7%,
        hsl(266.77, 89.22%, 67.14%) 71%,
        hsl(266.78, 88.13%, 67.51%) 77.5%,
        hsl(266.79, 87.27%, 67.8%) 84.5%,
        hsl(266.8, 86.7%, 67.98%) 91.9%,
        hsl(266.81, 86.5%, 68.04%) 100%
    );
}
.dashboard-card-fa .col:nth-of-type(4) .v-card {
    background-image: linear-gradient(
        to top,
        hsl(224.02, 100%, 60.98%) 0%,
        hsl(223.9, 99.86%, 61.12%) 8.1%,
        hsl(223.56, 99.47%, 61.5%) 15.5%,
        hsl(223.02, 98.84%, 62.05%) 22.5%,
        hsl(222.3, 98.01%, 62.7%) 29%,
        hsl(221.41, 96.99%, 63.42%) 35.3%,
        hsl(220.38, 95.83%, 64.14%) 41.2%,
        hsl(219.25, 94.54%, 64.85%) 47.1%,
        hsl(218.04, 93.19%, 65.52%) 52.9%,
        hsl(216.81, 91.81%, 66.13%) 58.8%,
        hsl(215.59, 90.47%, 66.67%) 64.7%,
        hsl(214.45, 89.22%, 67.14%) 71%,
        hsl(213.44, 88.13%, 67.51%) 77.5%,
        hsl(212.64, 87.27%, 67.8%) 84.5%,
        hsl(212.11, 86.7%, 67.98%) 91.9%,
        hsl(211.91, 86.5%, 68.04%) 100%
    );
}

.card-lv {
    margin-top: 2%;
}

</style>
