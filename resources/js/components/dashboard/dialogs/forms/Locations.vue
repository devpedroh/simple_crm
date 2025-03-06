<template>
    <div class="locations">
        <div class="card-title-more">
            <h4>Endereços</h4>

            <a href="#" @click="addLocation">
                <h5><v-icon>mdi-plus-circle</v-icon> Adicionar</h5>
            </a>
        </div>

        <v-data-table
            background-color="transparent"
            :headers="headers"
            :items="(data ? data : [])"
            :items-per-page="5"
        >
            <template v-slot:top>
                <v-dialog
                    v-model="dialog"
                    max-width="800px"
                    style="z-index: 999"
                    persistent
                >
                    <v-card>
                        <v-form class="mt-5" v-on:submit="save" ref="form" v-model="valid" lazy-validation>
                            <v-card-text class="pt-6 pb-6">
                                <v-text-field
                                    label="Rua"
                                    type="text"
                                    v-model="inputs.street.text"
                                    :rules="inputs.street.validation"
                                    required
                                ></v-text-field>

                                <v-text-field
                                    label="Numero"
                                    type="number"
                                    v-model="inputs.number.text"
                                    :rules="inputs.number.validation"
                                    required
                                ></v-text-field>

                                <v-text-field
                                    label="Complemento"
                                    type="text"
                                    v-model="inputs.complement.text"
                                    :rules="inputs.complement.validation"
                                    required
                                ></v-text-field>

                                <v-text-field
                                    label="Cidade"
                                    type="text"
                                    v-model="inputs.city.text"
                                    :rules="inputs.city.validation"
                                    required
                                ></v-text-field>

                                <v-text-field
                                    label="Estado"
                                    type="text"
                                    v-model="inputs.state.text"
                                    :rules="inputs.state.validation"
                                    required
                                ></v-text-field>

                                <v-text-field
                                    label="País"
                                    type="text"
                                    v-model="inputs.country.text"
                                    :rules="inputs.country.validation"
                                    required
                                ></v-text-field>
                            </v-card-text>

                            <v-card-actions>
                                <v-btn
                                    color="error"
                                    @click="close"
                                >
                                    Fechar
                                </v-btn>

                                <v-spacer></v-spacer>

                                <v-btn
                                    color="success"
                                    @click="save"
                                >
                                    Salvar
                                </v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-card>
                </v-dialog>
            </template>

            <template v-slot:item.actions="{ item, index }">
                <v-icon small color="amber" class="mr-3" @click="editLocation(index)">
                    mdi-pencil
                </v-icon>
                <v-icon small color="red" @click="removeLocation(index)">
                    mdi-delete
                </v-icon>
            </template>

            <template v-slot:no-results>
                <EmptyData text="Nenhum endereço cadastrado!" />
            </template>
            <template v-slot:no-data>
                <EmptyData text="Nenhum endereço cadastrado!" />
            </template>
        </v-data-table>
    </div>
</template>

<script>
import EmptyData from "@/components/dashboard/skeletons/EmptyData.vue";

export default {
    name: 'Locations',
    components: {
        EmptyData
    },
    props: [
        'data'
    ],
    data () {
        return {
            valid: false,
            dialog: false,

            selectedIndex: -1,

            headers: [
                { text: 'Rua', align: 'start', value: 'street' },
                { text: 'Numero', value: 'number' },
                { text: 'Complemento', value: 'complement' },
                { text: 'Cidade', value: 'city' },
                { text: 'Estado', value: 'state' },
                { text: 'País', value: 'country' },
                { text: '', value: 'actions' },
            ],

            inputs: {
                'street': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                        v => (v && v.length > 4) || 'Este campo deve conter no minimo 5 caracteres'
                    ]
                },
                'number': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                        v => (v && v.length > 0) || 'Este campo deve conter no minimo 1 caracteres'
                    ]
                },
                'complement': {
                    'text': '',
                    'validation': []
                },
                'city': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                        v => (v && v.length > 3) || 'Este campo deve conter no minimo 4 caracteres'
                    ]
                },
                'state': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                        v => (v && v.length > 1) || 'Este campo deve conter no minimo 2 caracteres'
                    ]
                },
                'country': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                        v => (v && v.length > 2) || 'Este campo deve conter no minimo 3 caracteres'
                    ]
                },
            },
        }
    },
    methods: {
        clearLocation () {
            this.inputs.street.text = ''
            this.inputs.number.text = ''
            this.inputs.complement.text = ''
            this.inputs.city.text = ''
            this.inputs.state.text = ''
            this.inputs.country.text = ''
            this.selectedIndex = -1
        },

        addLocation: function () {
            this.clearLocation()
            this.dialog = true
        },
        editLocation: function (index) {
            this.selectedIndex = index
            this.inputs.street.text = this.data[this.selectedIndex].street
            this.inputs.number.text = this.data[this.selectedIndex].number
            this.inputs.complement.text = this.data[this.selectedIndex].complement
            this.inputs.city.text = this.data[this.selectedIndex].city
            this.inputs.state.text = this.data[this.selectedIndex].state
            this.inputs.country.text = this.data[this.selectedIndex].country
            this.dialog = true
        },
        removeLocation: function (index) {
            this.data.splice(index, 1)
        },

        save () {
            if (this.selectedIndex >= 0) {
                this.data[this.selectedIndex].street = this.inputs.street.text
                this.data[this.selectedIndex].number = this.inputs.number.text
                this.data[this.selectedIndex].complement = this.inputs.complement.text
                this.data[this.selectedIndex].city = this.inputs.city.text
                this.data[this.selectedIndex].state = this.inputs.state.text
                this.data[this.selectedIndex].country = this.inputs.country.text
            } else {
                this.data.push({
                    street: this.inputs.street.text,
                    number: this.inputs.number.text,
                    complement: this.inputs.complement.text,
                    city: this.inputs.city.text,
                    state: this.inputs.state.text,
                    country: this.inputs.country.text,
                })
            }
            this.close()
        },

        close () {
            this.dialog = false
            this.clearLocation()
        },
    }
}
</script>

<style scoped>

</style>
