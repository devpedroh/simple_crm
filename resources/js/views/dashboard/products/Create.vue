<template>
    <dashbord-template>
        <v-card>
            <v-card-text>
                <div class="card-title-more">
                    <h4>Cadastrando Produto</h4>
                </div>

                <v-form class="mt-5" v-on:submit="validate" ref="form" v-model="valid" lazy-validation>
                    <v-text-field
                        label="Nome"
                        type="text"
                        v-model="inputs.name.text"
                        :rules="inputs.name.validation"
                        :disabled="end"
                        required
                    ></v-text-field>

                    <v-text-field
                        label="Preço"
                        type="number"
                        step="0.01"
                        min="0.01"
                        v-model="inputs.price.text"
                        :rules="inputs.price.validation"
                        :disabled="end"
                        required
                    ></v-text-field>

                    <v-row>
                        <v-col>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        label="Peso"
                                        type="number"
                                        step="0.01"
                                        min="0.01"
                                        v-model="inputs.weight.text"
                                        :rules="inputs.weight.validation"
                                        :disabled="end"
                                        required
                                    ></v-text-field>
                                </v-col>

                                <v-col>
                                    <v-select
                                        label="Unidade de medida"
                                        :items="units"
                                        item-text="name"
                                        item-value="id"
                                        v-model="inputs.weight_unit_id.text"
                                        :rules="inputs.weight_unit_id.validation"
                                        :disabled="end"
                                    ></v-select>
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        label="Largura"
                                        type="number"
                                        step="0.01"
                                        min="0.01"
                                        v-model="inputs.width.text"
                                        :rules="inputs.width.validation"
                                        :disabled="end"
                                        required
                                    ></v-text-field>
                                </v-col>

                                <v-col>
                                    <v-select
                                        label="Unidade de medida"
                                        :items="units"
                                        item-text="name"
                                        item-value="id"
                                        v-model="inputs.width_unit_id.text"
                                        :rules="inputs.width_unit_id.validation"
                                        :disabled="end"
                                    ></v-select>
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        label="Altura"
                                        type="number"
                                        step="0.01"
                                        min="0.01"
                                        v-model="inputs.length.text"
                                        :rules="inputs.length.validation"
                                        :disabled="end"
                                        required
                                    ></v-text-field>
                                </v-col>

                                <v-col>
                                    <v-select
                                        label="Unidade de medida"
                                        :items="units"
                                        item-text="name"
                                        item-value="id"
                                        v-model="inputs.length_unit_id.text"
                                        :rules="inputs.length_unit_id.validation"
                                        :disabled="end"
                                    ></v-select>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>

                    <v-textarea
                        label="Descrição"
                        v-model="inputs.description.text"
                        :rules="inputs.description.validation"
                    ></v-textarea>

                    <div class="form-actions text-end mt-5">
                        <v-btn v-if="!end" large color="success" @click="validate">Salvar</v-btn>
                        <v-btn v-else large color="success">Salvando...</v-btn>
                    </div>
                </v-form>
            </v-card-text>
        </v-card>
    </dashbord-template>
</template>

<script>
import DashbordTemplate from '@/templates/Dashboard.vue'
import SupplierLocations from '@/components/dashboard/dialogs/forms/Locations.vue'

export default {
    name: 'DashboardProductsCreate',
    components: {
        DashbordTemplate,
        SupplierLocations
    },
    data () {
        return {
            focus: false,
            valid: false,
            end: false,

            types: [],
            units: [],

            inputs: {
                'name': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                        v => (v && v.length > 2) || 'Este campo deve conter mais de 2 caracteres'
                    ]
                },
                'price': {
                    'text': '',
                    'validation': []
                },
                'weight': {
                    'text': '',
                    'validation': []
                },
                'weight_unit_id': {
                    'text': '',
                    'validation': []
                },
                'width': {
                    'text': '',
                    'validation': []
                },
                'width_unit_id': {
                    'text': '',
                    'validation': []
                },
                'length': {
                    'text': '',
                    'validation': []
                },
                'length_unit_id': {
                    'text': '',
                    'validation': []
                },
                'description': {
                    'text': '',
                    'validation': []
                },
            },
        }
    },
    methods: {
        validate: function (e) {
            e.preventDefault()

            this.end = true
            if (this.$refs.form.validate()) {
                this.$http.post('/api/dashboard/products/create', {
                    name: this.inputs.name.text,
                    price: this.inputs.price.text,
                    weight: this.inputs.weight.text,
                    weight_unit_id: this.inputs.weight_unit_id.text,
                    width: this.inputs.width.text,
                    width_unit_id: this.inputs.width_unit_id.text,
                    length: this.inputs.length.text,
                    length_unit_id: this.inputs.length_unit_id.text,
                    description: this.inputs.description.text
                }, { 'headers': { Authorization: 'Bearer ' + this.$store.getters['AuthUser/getToken'] } }).then(response => {
                    if (response.data.cod === 200) {
                        this.$store.commit('DashboardAlert/setAlert', {
                            value: true,
                            data: {
                                text: 'Produto criado com sucesso!',
                                type: 'success',
                                blackdrop: true
                            }
                        })
                        setTimeout(() => {
                            this.$router.push({ name: 'DashboardProducts' })
                        }, 2200)
                    } else if (response.data.cod === 400) {
                        this.$store.commit('DashboardAlert/setAlert', {
                            value: true,
                            data: {
                                text: response.data.error,
                                type: 'warning'
                            }
                        })
                        console.log(response.data.validate)
                    } else {
                        this.$store.commit('DashboardAlert/setAlert', {
                            value: true,
                            data: {
                                text: response.data.error,
                                type: 'error'
                            }
                        })
                    }
                    this.end = false
                }).catch(err => {
                    this.$store.commit('DashboardAlert/setAlert', {
                        value: true,
                        data: {
                            text: 'Não foi possível concluir sua solicitação! Favor, tente novamente mais tarde...',
                            type: 'error'
                        }
                    })
                    this.end = false
                    console.clear()
                });
            } else {
                this.$store.commit('DashboardAlert/setAlert', {
                    value: true,
                    data: {
                        text: 'Preencha os campos corretamente! Verifique o formulário...',
                        type: 'warning'
                    }
                })
                this.end = false
                console.clear()
            }
        },
    },
    created () {

        this.$http.get('/api/dashboard/products/getFormData', {
            'headers': {
                Authorization: 'Bearer ' + this.$store.getters['AuthUser/getToken']
            }
        }).then(response => {
            if (response.data.cod === 200) {
                this.units = response.data.data.units
            }
        })

    },
}
</script>

<style scoped>

.v-card {
    margin-bottom: 2%;
}

</style>
