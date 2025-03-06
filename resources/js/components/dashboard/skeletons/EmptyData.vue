<template>
    <div class="empty-data">
        <v-icon size="80">mdi-package-variant</v-icon>
        <h5>{{ (text ? text : 'Opa, parece que isso ainda não está disponivel!') }}</h5>
    </div>
</template>

<script>
export default {
    name: 'EmptyData',
    props: [
        'text',
    ],
    data () {
        return {

        }
    },
}
</script>

<style scoped>

.empty-data {
    padding: 32px;
}
.empty-data h5 {
    font-weight: bold;
}
.empty-data .v-icon {
    margin-bottom: 8px;
}

</style>
