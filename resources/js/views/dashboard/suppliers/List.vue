<template>
    <dashbord-template>
        <v-card>
            <v-card-text>
                <div class="card-title-more">
                    <h4>Fornecedores</h4>
                    <router-link :to="{ name: 'DashboardSuppliersCreate' }">
                        <h5><v-icon>mdi-plus-circle</v-icon> Novo fornecedor</h5>
                    </router-link>
                </div>

                <table-default
                    name="suppliers"
                    :headers="headers"
                    :data="dataSuppliers"
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
    name: 'DashboardSuppliers',
    components: {
        TableDefault,
        DashbordTemplate,
    },
    data () {
        return {
            actions: [
                {icon: 'mdi-pencil', tooltip: 'Editar fornecedor', color: '#FFC400', type: 'edit'},
                {icon: 'mdi-delete', tooltip: 'Deletar fornecedor', color: '#E57373', type: 'delete'},
            ],

            headers: [
                { text: 'ID', align: 'start', value: 'id' },
                { text: 'Nome', value: 'name' },
                { text: 'Email', value: 'email' },
                { text: 'Endereços', value: 'locations', filterable: false, sortable: false },
                { text: 'Tipo', value: 'type', filterable: false, sortable: false },
                { text: 'CPF/CNPJ', value: 'identification' },
                { text: 'Telefone', value: 'tel', filterable: false, sortable: false },
                { text: 'Criado em', value: 'created_at', filterable: false },
                { text: 'Atualizado em', value: 'updated_at', filterable: false },
                { text: '', value: 'actions' },
            ],

            dataSuppliers: [],
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
