<template>
    <dashbord-template>
        <v-card>
            <v-card-text>
                <div class="card-title-more">
                    <h4>Vendas</h4>
                    <router-link :to="{ name: 'DashboardSellsCreate' }">
                        <h5><v-icon>mdi-plus-circle</v-icon> Nova venda</h5>
                    </router-link>
                </div>

                <table-default
                    name="sells"
                    :headers="headers"
                    :data="dataSells"
                    :actions="actions"
                ></table-default>
            </v-card-text>
        </v-card>
    </dashbord-template>
</template>

<script>
import DashbordTemplate from '@/templates/Dashboard.vue'
import TableDefault from "@/components/dashboard/tables/Default.vue";

export default {
    name: 'DashboardSells',
    components: {
        TableDefault,
        DashbordTemplate
    },
    data () {
        return {
            actions: [
                {icon: 'mdi-pencil', tooltip: 'Editar venda', color: '#FFC400', type: 'edit'},
                {icon: 'mdi-delete', tooltip: 'Deletar venda', color: '#E57373', type: 'delete'},
            ],

            headers: [
                { text: 'ID', align: 'start', value: 'id' },
                { text: 'Cliente', value: 'client_name' },
                { text: 'Produtos', value: 'products', filterable: false, sortable: false },
                { text: 'Pago via', value: 'paymentMethod', filterable: false, sortable: false },
                { text: 'Tipo', value: 'paymentType', filterable: false, sortable: false },
                { text: 'Valor total', value: 'total_price', filterable: false },
                { text: 'Criado em', value: 'created_at', filterable: false },
                { text: 'Atualizado em', value: 'updated_at', filterable: false },
                { text: '', value: 'actions' },
            ],

            dataSells: [],
        }
    },
    methods: {

    },
    created () {

    },
}
</script>

<style scoped>

.v-card {
    margin-bottom: 2%;
}

</style>
