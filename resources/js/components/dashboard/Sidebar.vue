<template>
    <div class="dashboard-menu">
        <router-link :class="'dashboard-link' + (this.$router.currentRoute.name === 'DashboardHome' ? ' active' : '')" :to="{ name: 'DashboardHome' }">
            <v-icon>mdi-home-outline</v-icon> Inicio
        </router-link>

        <router-link :class="'dashboard-link' + (this.$router.currentRoute.name.includes('DashboardClients') ? ' active' : '')" :to="{ name: 'DashboardClients' }">
            <v-icon>mdi-account-group-outline</v-icon> Clientes
        </router-link>

        <router-link :class="'dashboard-link' + (this.$router.currentRoute.name.includes('DashboardSuppliers') ? ' active' : '')" :to="{ name: 'DashboardSuppliers' }">
            <v-icon>mdi-account-tie-outline</v-icon> Fornecedores
        </router-link>

        <router-link :class="'dashboard-link' + (this.$router.currentRoute.name.includes('DashboardProducts') ? ' active' : '')" :to="{ name: 'DashboardProducts' }">
            <v-icon>mdi-sale-outline</v-icon> Produtos
        </router-link>

        <router-link :class="'dashboard-link' + (this.$router.currentRoute.name.includes('DashboardSells') ? ' active' : '')" :to="{ name: 'DashboardSells' }">
            <v-icon>mdi-cart-outline</v-icon> Vendas
        </router-link>
    </div>
</template>

<script>
export default {
    name: 'DashboardMenu',
    data () {
        return {

        }
    },
    created () {

    }
}
</script>

<style scoped>

#dashboard .dashboard-drawer .dashboard-menu {
    display: flex;
    flex-direction: column;
    margin-top: 24px;
}
#dashboard .dashboard-drawer .dashboard-menu .dashboard-link {
    margin-bottom: 48px;
    display: flex;
    align-items: center;
}
#dashboard .dashboard-drawer .dashboard-menu .dashboard-link .v-icon {
    margin-right: 8px;
}
#dashboard .dashboard-drawer .dashboard-menu .dashboard-link,
#dashboard .dashboard-drawer .dashboard-menu .dashboard-link .v-icon {
    color: #A5A4AA !important;
}
#dashboard .dashboard-drawer .dashboard-menu .dashboard-link.active,
#dashboard .dashboard-drawer .dashboard-menu .dashboard-link.active .v-icon {
    color: #B622B5 !important;
    font-weight: bold;
}

</style>
