<template>
    <dashbord-template>
        <v-card>
            <v-card-text>
                <div class="card-title-more">
                    <h4>Alterando Venda</h4>
                </div>

                <v-form class="mt-5" v-on:submit="validate" ref="form" v-model="valid" lazy-validation>
                    <v-select
                        label="Cliente"
                        :items="clients"
                        item-text="name"
                        item-value="id"
                        v-model="inputs.client_id.text"
                        :rules="inputs.client_id.validation"
                        :disabled="end"
                    >
                        <template v-slot:selection="{ item, index }">
                            <span>{{ item.name }} ({{ item.identification }})</span>
                        </template>

                        <template v-slot:item="{ item }">
                            <span>{{ item.name }} ({{ item.identification }})</span>
                        </template>

                        <template v-slot:no-results>
                            <EmptyData text="Nenhum cliente encontrado" />
                        </template>
                        <template v-slot:no-data>
                            <EmptyData text="Nenhum cliente encontrado" />
                        </template>
                    </v-select>

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Preço"
                                type="number"
                                step="0.01"
                                min="0.01"
                                v-model="inputs.total_price.text"
                                :rules="inputs.total_price.validation"
                                :disabled="end"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col>
                            <v-select
                                label="Meio de pagamento"
                                :items="paymentMethods"
                                item-text="name"
                                item-value="id"
                                v-model="inputs.payment_method_id.text"
                                :rules="inputs.payment_method_id.validation"
                                :disabled="end"
                            >
                                <template v-slot:no-results>
                                    <EmptyData text="Nenhum meio de pagamento encontrado" />
                                </template>
                                <template v-slot:no-data>
                                    <EmptyData text="Nenhum meio de pagamento encontrado" />
                                </template>
                            </v-select>
                        </v-col>

                        <v-col>
                            <v-select
                                label="Tipo de pagamento"
                                :items="paymentTypes"
                                item-text="name"
                                item-value="id"
                                v-model="inputs.payment_type_id.text"
                                :rules="inputs.payment_type_id.validation"
                                :disabled="end"
                            >
                                <template v-slot:no-results>
                                    <EmptyData text="Nenhum tipo de pagamento encontrado" />
                                </template>
                                <template v-slot:no-data>
                                    <EmptyData text="Nenhum tipo de pagamento encontrado" />
                                </template>
                            </v-select>
                        </v-col>
                    </v-row>

                    <v-textarea
                        label="Descrição"
                        v-model="inputs.description.text"
                        :rules="inputs.description.validation"
                    ></v-textarea>

                    <sell-products :data="inputs.products.text" :products="products" :suppliers="suppliers"></sell-products>

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
import SellProducts from '@/components/dashboard/dialogs/forms/Products.vue'

export default {
    name: 'DashboardSellsEdit',
    components: {
        DashbordTemplate,
        SellProducts
    },
    data() {
        return {
            valid: false,
            end: false,

            paymentMethods: [],
            paymentTypes: [],
            products: [],
            clients: [],
            suppliers: [],

            inputs: {
                'client_id': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                    ]
                },
                'total_price': {
                    'text': '',
                    'validation': []
                },
                'payment_method_id': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                    ]
                },
                'payment_type_id': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                    ]
                },
                'products': {
                    'text': [],
                    'validation': []
                },
                'description': {
                    'text': '',
                    'validation': []
                },
            }
        }
    },
    methods: {
        validate: function (e) {
            e.preventDefault()

            this.end = true
            if (this.$refs.form.validate()) {
                this.$http.put('/api/dashboard/sells/update/' + this.$route.params.id, {
                    client_id: this.inputs.client_id.text,
                    total_price: this.inputs.total_price.text,
                    payment_method_id: this.inputs.payment_method_id.text,
                    payment_type_id: this.inputs.payment_type_id.text,
                    products: this.inputs.products.text,
                    description: this.inputs.description.text,
                }, {'headers': {Authorization: 'Bearer ' + this.$store.getters['AuthUser/getToken']}}).then(response => {
                    if (response.data.cod === 200) {
                        this.$store.commit('DashboardAlert/setAlert', {
                            value: true,
                            data: {
                                text: 'Venda alterada com sucesso!',
                                type: 'success',
                                blackdrop: true
                            }
                        })
                        setTimeout(() => {
                            this.$router.push({name: 'DashboardSells'})
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
        }
    },
    created() {

        this.$http.get('/api/dashboard/sells/getFormData', {
            'headers': {
                Authorization: 'Bearer ' + this.$store.getters['AuthUser/getToken']
            }
        }).then(response => {
            if (response.data.cod === 200) {
                this.paymentMethods = response.data.data.paymentMethods
                this.paymentTypes = response.data.data.paymentTypes
                this.products = response.data.data.products
                this.clients = response.data.data.clients
                this.suppliers = response.data.data.suppliers
            }
        })

        this.$http.get('/api/dashboard/sells/view/' + this.$route.params.id, {
            'headers': {
                Authorization: 'Bearer ' + this.$store.getters['AuthUser/getToken']
            }
        }).then(response => {
            if (response.data.cod === 200) {
                let data = response.data.data

                this.inputs.client_id.text = data.client_id
                this.inputs.total_price.text = data.total_price
                this.inputs.payment_method_id.text = data.payment_method_id
                this.inputs.payment_type_id.text = data.payment_type_id
                this.inputs.products.text = data.products
                this.inputs.description.text = data.description
            }
        })

    }
}
</script>

<style scoped>

</style>
