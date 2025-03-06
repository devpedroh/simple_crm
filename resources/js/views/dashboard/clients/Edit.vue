<template>
    <dashbord-template>
        <v-card>
            <v-card-text>
                <div class="card-title-more">
                    <h4>Alterando Cliente</h4>
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

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Email"
                                type="email"
                                v-model="inputs.email.text"
                                :rules="inputs.email.validation"
                                :disabled="end"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col>
                            <v-text-field-simplemask
                                v-model="inputs.tel.text"
                                label="Telefone"
                                v-bind:options="{
                                    inputMask: '(##) #####-####',
                                    outputMask: '###########',
                                    empty: null,
                                    applyAfter: false,
                                }"
                                v-bind:focus="focus"
                                v-on:focus="focus = false"
                                :disabled="end"
                            />
                        </v-col>
                    </v-row>

                    <v-row class="mt-0">
                        <v-col cols="4">
                            <v-select
                                label="Tipo"
                                :items="[{ id: 1, name: 'Fisica' }, { id: 2, name: 'Juridica' }]"
                                item-text="name"
                                item-value="id"
                                v-model="inputs.type.text"
                                :rules="inputs.type.validation"
                                :disabled="end"
                            ></v-select>
                        </v-col>

                        <v-col v-if="inputs.type.text === 1">
                            <v-text-field-cpf
                                v-model="inputs.identification.text"
                                label="CPF"
                                v-bind:options="{
                                    outputMask: '###########',
                                    empty: null,
                                    applyAfter: false,
                                }"
                                v-bind:focus="focus"
                                v-on:focus="focus = false"
                                :disabled="end"
                            />
                        </v-col>

                        <v-col v-else-if="inputs.type.text === 2">
                            <v-text-field-cnpj
                                v-model="inputs.identification.text"
                                label="CNPJ"
                                v-bind:options="{
                                    outputMask: '##############',
                                    empty: null,
                                    applyAfter: false,
                                }"
                                v-bind:focus="focus"
                                v-on:focus="focus = false"
                                :disabled="end"
                            />
                        </v-col>
                    </v-row>

                    <supplier-locations class="mt-5" :data="this.inputs.locations.text" />

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
import SupplierLocations from "@/components/dashboard/dialogs/forms/Locations.vue";

export default {
    name: 'DashboardClientsEdit',
    components: {
        SupplierLocations,
        DashbordTemplate,
    },
    data () {
        return {
            focus: false,
            valid: false,
            end: false,

            inputs: {
                'name': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                        v => (v && v.length > 5) || 'Este campo deve conter mais de 5 caracteres'
                    ]
                },
                'email': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                        v => (v && v.length > 10) || 'Este campo deve conter mais de 10 caracteres'
                    ]
                },
                'type': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                        v => (v > 0 && v < 3) || 'Tipo invalido'
                    ]
                },
                'identification': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                        v => (v && v.length > 10) || 'Este campo deve conter no minimo 11 caracteres'
                    ]
                },
                'tel': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                        v => (v && v.length > 7) || 'Este campo deve conter no minimo 8 caracteres'
                    ]
                },
                'locations': {
                    'text': [],
                    'count': 1,
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                    ]
                },
            },
        }
    },
    methods: {
        validate: function (e) {
            e.preventDefault()

            this.end = true
            if (this.$refs.form.validate()) {
                this.$http.put('/api/dashboard/clients/update/' + this.$route.params.id, {
                    name: this.inputs.name.text,
                    email: this.inputs.email.text,
                    type: Number(this.inputs.type.text),
                    identification: this.inputs.identification.text,
                    locations: this.inputs.locations.text,
                    tel: Number(this.inputs.tel.text),
                }, { 'headers': { Authorization: 'Bearer ' + this.$store.getters['AuthUser/getToken'] } }).then(response => {
                    if (response.data.cod === 200) {
                        this.$store.commit('DashboardAlert/setAlert', {
                            value: true,
                            data: {
                                text: 'Cliente alterado com sucesso!',
                                type: 'success',
                                blackdrop: true
                            }
                        })
                        setTimeout(() => {
                            this.$router.push({ name: 'DashboardClients' })
                        }, 2200)
                    } else if (response.data.cod === 400) {
                        this.$store.commit('DashboardAlert/setAlert', {
                            value: true,
                            data: {
                                text: response.data.error,
                                type: 'warning'
                            }
                        })
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
                })
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
    created() {

        this.$http.get('/api/dashboard/clients/view/' + this.$route.params.id, {
            'headers': {
                Authorization: 'Bearer ' + this.$store.getters['AuthUser/getToken']
            }
        }).then(response => {
            if (response.data.cod === 200) {
                let data = response.data.data

                this.inputs.name.text = data.name
                this.inputs.email.text = data.email
                this.inputs.tel.text = data.tel
                this.inputs.type.text = data.type
                this.inputs.identification.text = data.identification
                this.inputs.locations.text = data.locations
            } else {
                this.$store.commit('DashboardAlert/setAlert', {
                    value: true,
                    data: {
                        text: response.data.error,
                        type: 'error'
                    }
                })
                this.$router.push({ name: 'DashboardClients' })
            }
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
            this.$router.push({ name: 'DashboardClients' })
        });

    },
}
</script>

<style scoped>

.v-card {
    margin-bottom: 2%;
}

</style>
