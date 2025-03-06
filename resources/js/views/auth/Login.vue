<template>
    <auth-template>
        <v-card>
            <v-card-title>
                <img src="../../../static/img/logo_dash_black.png" alt="logo" width="150" height="150" class="img-fluid">
            </v-card-title>
            <v-card-text>
                <v-form v-on:submit="validate" ref="form" v-model="valid" lazy-validation>
                    <v-text-field
                        label="Email"
                        type="text"
                        v-model="inputs.email.text"
                        :rules="inputs.email.validation"
                        required
                    ></v-text-field>

                    <v-text-field
                        label="Senha"
                        type="password"
                        v-model="inputs.password.text"
                        :rules="inputs.password.validation"
                        required
                    ></v-text-field>

                    <div class="form-actions text-start mt-3">
                        <div class="form-texts">
                            <h6>Ainda não tem conta? <router-link :to="{ name: 'AuthRegister' }">Registre-se</router-link></h6>
                        </div>
                        <v-btn v-if="valid" large color="success" @click="validate">Entrar</v-btn>
                        <v-btn v-else large color="success">Verificando...</v-btn>
                    </div>
                </v-form>
            </v-card-text>
        </v-card>
    </auth-template>
</template>

<script>
import AuthTemplate from '@/templates/Auth.vue'

export default {
    name: 'AuthLogin',
    components: {
        AuthTemplate
    },
    data () {
        return {
            valid: true,
            inputs: {
                'email': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                        v => (v && v.length > 5) || 'Este campo deve conter mais de 5 caracteres'
                    ]
                },
                'password': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                        v => (v && v.length > 5) || 'Este campo deve conter mais de 2 caracteres'
                    ]
                }
            }
        }
    },
    methods: {
        validate (e) {
            e.preventDefault()
            this.valid = false

            if (this.$refs.form.validate()) {
                this.$http.post('/api/auth/login', {
                    email: this.inputs.email.text,
                    password: this.inputs.password.text
                }).then(response => {
                    if (response.data.cod === 200) {
                        this.$store.commit('DashboardAlert/setAlert', {
                            value: true,
                            data: {
                                text: 'Autenticado com sucesso!',
                                type: 'success'
                            }
                        })
                        this.$store.commit('AuthUser/setUser', response.data.user)
                        this.$store.commit('AuthUser/setUserToken', response.data.token)
                        this.$cookies.set('auth_token', response.data.token, '365d');
                        setTimeout(() => {
                            this.$router.push({ name: 'DashboardHome' })
                        }, 2200)
                    } else {
                        this.$store.commit('DashboardAlert/setAlert', {
                            value: true,
                            data: {
                                text: response.data.error,
                                type: 'error'
                            }
                        })
                        this.valid = true
                    }
                }).catch(err => {
                    this.$store.commit('DashboardAlert/setAlert', {
                        value: true,
                        data: {
                            text: 'Não foi possível concluir sua solicitação! Favor, tente novamente mais tarde...',
                            type: 'error'
                        }
                    })
                    this.valid = true
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
                this.valid = true
            }
        }
    },
    created () {

    }
}
</script>

<style scoped>



</style>
