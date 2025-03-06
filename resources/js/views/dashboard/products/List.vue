<template>
    <dashbord-template>
        <v-card>
            <v-card-text>
                <div class="card-title-more">
                    <h4>Produtos</h4>
                    <router-link :to="{ name: 'DashboardProductsCreate' }">
                        <h5><v-icon>mdi-plus-circle</v-icon> Novo Produto</h5>
                    </router-link>
                </div>

                <table-default
                    name="products"
                    :headers="headers"
                    :data="dataProducts"
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
    name: 'DashboardProducts',
    components: {
        TableDefault,
        DashbordTemplate,
    },
    data () {
        return {
            actions: [
                {icon: 'mdi-pencil', tooltip: 'Editar produto', color: '#FFC400', type: 'edit'},
                {icon: 'mdi-delete', tooltip: 'Deletar produto', color: '#E57373', type: 'delete'},
            ],

            headers: [
                { text: 'ID', align: 'start', value: 'id' },
                { text: 'Produto', value: 'name' },
                { text: 'Preço', value: 'price', filterable: false, sortable: false },
                { text: 'Peso', value: 'weight', filterable: false, sortable: false },
                { text: 'Altura', value: 'length', filterable: false, sortable: false },
                { text: 'Largura', value: 'width', filterable: false, sortable: false },
                { text: 'Criado em', value: 'created_at', filterable: false },
                { text: 'Atualizado em', value: 'updated_at', filterable: false },
                { text: '', value: 'actions' },
            ],

            dataProducts: [],
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
