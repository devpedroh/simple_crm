<template>
    <v-data-table
        background-color="transparent"
        :headers="headers"
        :items="items"
        :page.sync="currentPage"
        :items-per-page="pageSize"
        :footer-props="{
            itemsPerPageText: 'Registros por página',
            itemsPerPageOptions: [
              5, 10, 20
            ],
            pageText: 'Página ' + this.currentPage + ' de ' + ((this.total / this.pageSize) + 0.4).toFixed()
        }"
        @update:items-per-page="getItemPerPage"
        item-key="id"
        :search="search"
        :loading="loading"
        loading-text="Buscando dados... Por favor, aguarde!"
    >
        <template v-slot:top>
            <v-text-field
                v-model="search"
                label="Pesquisar"
                append-icon="mdi-magnify"
                color="none"
            ></v-text-field>

            <v-dialog
                v-model="dialog"
                max-width="1000px"
                content-class="dashboard-dialog"
            >
                <v-card class="mb-0" v-if="dialogType === 'products' && !('payment_method_id' in dialogData)">
                    <v-card-title>Visualizando produtos de {{ dialogData.name }}</v-card-title>

                    <v-card-text class="pt-5 pb-5">
                        <v-data-table
                            :headers="dialogHeadersProducts"
                            :items="dialogData.products"
                            :items-per-page="5"
                            :footer-props="{
                                itemsPerPageText: 'Registros por página',
                                itemsPerPageOptions: [5, 10],
                            }"
                        >
                            <template v-for="h in dialogHeadersProducts" v-slot:[`item.${h.value}`]="{ item }">
                                <v-tooltip v-if="['price', 'total_price'].includes(h.value)" bottom>
                                    <template v-slot:activator="{ on }">
                                        <span v-on="on">{{Number(item[h.value]).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}}</span>
                                    </template>
                                    <span>{{Number(item[h.value]).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}}</span>
                                </v-tooltip>

                                <v-tooltip v-else-if="['qtd'].includes(h.value)" bottom>
                                    <template v-slot:activator="{ on }">
                                        <span v-on="on">{{$numberFormat(item[h.value])}}</span>
                                    </template>
                                    <span>{{$numberFormat(item[h.value])}}</span>
                                </v-tooltip>

                                <v-tooltip v-else bottom>
                                    <template v-slot:activator="{ on }">
                                        <span v-on="on">{{item[h.value]}}</span>
                                    </template>
                                    <span>{{item[h.value]}}</span>
                                </v-tooltip>
                            </template>
                        </v-data-table>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            @click="close"
                        >
                            Fechar
                        </v-btn>
                    </v-card-actions>
                </v-card>

                <v-card class="mb-0" v-else-if="dialogType === 'products' && ('payment_method_id' in dialogData)">
                    <v-card-title>Visualizando produtos de {{ dialogData.client.name }}</v-card-title>

                    <v-card-text class="pt-5 pb-5">
                        <v-data-table
                            :headers="dialogHeadersSellProducts"
                            :items="dialogData.products"
                            :items-per-page="5"
                            :footer-props="{
                                itemsPerPageText: 'Registros por página',
                                itemsPerPageOptions: [5, 10],
                            }"
                        >
                            <template v-for="h in dialogHeadersSellProducts" v-slot:[`item.${h.value}`]="{ item }">
                                <v-tooltip v-if="['product_name'].includes(h.value)" bottom>
                                    <template v-slot:activator="{ on }">
                                        <span v-on="on">{{item['product']['name']}}</span>
                                    </template>
                                    <span>{{item['product']['name']}}</span>
                                </v-tooltip>

                                <v-tooltip v-else-if="['product_id'].includes(h.value)" bottom>
                                    <template v-slot:activator="{ on }">
                                        <span v-on="on">{{item['product']['id']}}</span>
                                    </template>
                                    <span>{{item['product']['id']}}</span>
                                </v-tooltip>

                                <v-tooltip v-else-if="['product_weight'].includes(h.value)" bottom>
                                    <template v-slot:activator="{ on }">
                                        <span v-on="on">{{item['product']['weight'] ? item['product']['weight'] + item['product']['weight_unit']['short_form'] : ''}}</span>
                                    </template>
                                    <span>{{item['product']['weight'] ? item['product']['weight'] + item['product']['weight_unit']['short_form'] : ''}}</span>
                                </v-tooltip>

                                <v-tooltip v-else-if="['supplier_name'].includes(h.value)" bottom>
                                    <template v-slot:activator="{ on }">
                                        <span v-on="on">{{item['supplier']['name']}}</span>
                                    </template>
                                    <span>{{item['supplier']['name']}}</span>
                                </v-tooltip>

                                <v-tooltip v-else-if="['total_price'].includes(h.value)" bottom>
                                    <template v-slot:activator="{ on }">
                                        <span v-on="on">{{Number(item[h.value]).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}}</span>
                                    </template>
                                    <span>{{Number(item[h.value]).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}}</span>
                                </v-tooltip>

                                <v-tooltip v-else-if="['product_price'].includes(h.value)" bottom>
                                    <template v-slot:activator="{ on }">
                                        <span v-on="on">{{Number(item['product']['price']).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}}</span>
                                    </template>
                                    <span>{{Number(item['product']['price']).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}}</span>
                                </v-tooltip>

                                <v-tooltip v-else-if="['qtd'].includes(h.value)" bottom>
                                    <template v-slot:activator="{ on }">
                                        <span v-on="on">{{$numberFormat(item[h.value])}}</span>
                                    </template>
                                    <span>{{$numberFormat(item[h.value])}}</span>
                                </v-tooltip>

                                <v-tooltip v-else bottom>
                                    <template v-slot:activator="{ on }">
                                        <span v-on="on">{{item[h.value]}}</span>
                                    </template>
                                    <span>{{item[h.value]}}</span>
                                </v-tooltip>
                            </template>
                        </v-data-table>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            @click="close"
                        >
                            Fechar
                        </v-btn>
                    </v-card-actions>
                </v-card>

                <v-card class="mb-0" v-else-if="dialogType === 'locations'">
                    <v-card-title>Visualizando endereços de {{ dialogData.name }}</v-card-title>

                    <v-card-text class="pt-5 pb-5">
                        <v-data-table
                            background-color="transparent"
                            :headers="[
                                { text: 'Rua', align: 'start', value: 'street' },
                                { text: 'Numero', value: 'number' },
                                { text: 'Complemento', value: 'complement' },
                                { text: 'Cidade', value: 'city' },
                                { text: 'Estado', value: 'state' },
                                { text: 'País', value: 'country' }
                            ]"
                            :items="(dialogData.locations ? dialogData.locations : [])"
                            :items-per-page="5"
                            :footer-props="{
                                disableItemsPerPage: true
                            }"
                        >
                            <template v-slot:no-results>
                                <EmptyData text="Nenhum endereço cadastrado!" />
                            </template>
                            <template v-slot:no-data>
                                <EmptyData text="Nenhum endereço cadastrado!" />
                            </template>
                        </v-data-table>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            @click="close"
                        >
                            Fechar
                        </v-btn>
                    </v-card-actions>
                </v-card>

                <v-card class="mb-0" v-else-if="dialogType === 'client'">
                    <v-card-title>Visualizando dados de {{ dialogData.name }}</v-card-title>

                    <v-card-text class="pt-5 pb-5">
                        <h6>CPF/CNPJ: {{ dialogData.identification }}</h6>
                        <h6>Tipo: {{ dialogData.type == 1 ? 'Fisica' : 'Juridica' }}</h6>
                        <h6>Telefone: {{ dialogData.tel }}</h6>
                        <h6>Email: {{ dialogData.email }}</h6>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            @click="close"
                        >
                            Fechar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-dialog v-model="dialogDelete" max-width="400">
                <v-card>
                    <v-card-title class="headline">Atenção</v-card-title>
                    <v-card-text class="mt-5">
                        Tem certeza que deseja excluir este registro?
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="success" @click="dialogDelete = false">Cancelar</v-btn>
                        <v-btn color="error" @click="confirmDelete">Excluir</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </template>

        <template v-for="h in headers" v-slot:[`item.${h.value}`]="{ item }">
            <v-tooltip v-if="['created_at', 'updated_at'].includes(h.value)" bottom>
                <template v-slot:activator="{ on }">
                    <span v-on="on">{{(item[h.value] ? moment(item[h.value]).format('DD/MM/YYYY') + ' às ' + moment(item[h.value]).format('HH:mm') : '---')}}</span>
                </template>
                <span>{{(item[h.value] ? moment(item[h.value]).format('DD/MM/YYYY') + ' às ' + moment(item[h.value]).format('HH:mm') : '---')}}</span>
            </v-tooltip>

            <v-tooltip v-else-if="h.value == 'type' && ['suppliers', 'clients'].includes(name)" bottom>
                <template v-slot:activator="{ on }">
                    <span v-on="on">{{getIdentType(item[h.value])}}</span>
                </template>
                <span>{{getIdentType(item[h.value])}}</span>
            </v-tooltip>

            <v-tooltip v-else-if="h.value == 'client_name'" bottom>
                <template v-slot:activator="{ on }">
                    <span v-on="on">
                        {{item['client']['name']}}
                        <v-icon @click="showDialog(item.client, 'client')" class="ml-3">mdi-magnify</v-icon>
                    </span>
                </template>
                <span>{{item['client']['name']}}</span>
            </v-tooltip>

            <v-tooltip v-else-if="h.value == 'paymentMethod'" bottom>
                <template v-slot:activator="{ on }">
                    <span v-on="on">{{getPaymentMethod(item[h.value])}}</span>
                </template>
                <span>{{getPaymentMethod(item[h.value])}}</span>
            </v-tooltip>

            <v-tooltip v-else-if="['products', 'locations'].includes(h.value)" bottom>
                <template v-slot:activator="{ on }">
                    <span v-on="on" style="display: flex; flex-direction: row; align-content: center; align-items: center;">
                        {{(item[h.value] ? item[h.value].length : '---')}}
                        <v-icon @click="showDialog(item, h.value)" class="ml-3">mdi-magnify</v-icon>
                    </span>
                </template>
                <span>{{(item[h.value] ? item[h.value].length : '---')}}</span>
            </v-tooltip>

            <v-tooltip v-else-if="h.value == 'paymentType'" bottom>
                <template v-slot:activator="{ on }">
                    <span v-on="on">{{getPaymentType(item[h.value])}}</span>
                </template>
                <span>{{getPaymentType(item[h.value])}}</span>
            </v-tooltip>

            <v-tooltip v-else-if="h.value == 'identification'" bottom>
                <template v-slot:activator="{ on }">
                    <span v-on="on">{{formatCpfCnpj(item[h.value])}}</span>
                </template>
                <span>{{formatCpfCnpj(item[h.value])}}</span>
            </v-tooltip>

            <v-tooltip v-else-if="h.value == 'tel'" bottom>
                <template v-slot:activator="{ on }">
                    <span v-on="on">{{formatTel(item[h.value])}}</span>
                </template>
                <span>{{formatTel(item[h.value])}}</span>
            </v-tooltip>

            <v-tooltip v-else-if="['price', 'total_price'].includes(h.value)" bottom>
                <template v-slot:activator="{ on }">
                    <span v-on="on">{{Number(item[h.value]).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}}</span>
                </template>
                <span>{{Number(item[h.value]).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}}</span>
            </v-tooltip>

            <v-tooltip v-else-if="['qtd'].includes(h.value)" bottom>
                <template v-slot:activator="{ on }">
                    <span v-on="on">{{$numberFormat(item[h.value])}}</span>
                </template>
                <span>{{$numberFormat(item[h.value])}}</span>
            </v-tooltip>

            <v-tooltip v-else-if="['weight', 'width', 'length'].includes(h.value)" bottom>
                <template v-slot:activator="{ on }">
                    <span v-on="on">{{ item[h.value] ? $numberFormat(item[h.value]) + item[h.value + '_unit']['short_form'] : '' }}</span>
                </template>
                <span>{{ item[h.value] ? $numberFormat(item[h.value]) + item[h.value + '_unit']['short_form'] : '' }}</span>
            </v-tooltip>

            <v-tooltip v-else bottom>
                <template v-slot:activator="{ on }">
                    <span v-on="on">{{item[h.value]}}</span>
                </template>
                <span>{{item[h.value]}}</span>
            </v-tooltip>
        </template>

        <template v-slot:item.actions="{ item }">
            <v-menu>
                <template v-slot:activator="{ on: menu, attrs }">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on: tooltip }">
                            <v-btn
                                color="transparent"
                                dark
                                small
                                elevation="0"
                                style="border: 1px solid #000 !important; border-radius: 16px;"
                                v-bind="attrs"
                                v-on="{ ...tooltip, ...menu }"
                            >
                                <h4>...</h4>
                            </v-btn>
                        </template>
                        <span>Ações</span>
                    </v-tooltip>
                </template>
                <v-list>
                    <v-list-item
                        v-for="(act, indexAct) in actions"
                        :key="indexAct"
                        style="cursor: pointer"
                    >
                        <v-list-item-title v-if="!('dialog' in act)" @click="startAct(act.type, item.id)">
                            <v-icon small class="mr-2" :color="act.color">
                                {{act.icon}}
                            </v-icon>

                            <span>{{act.tooltip}}</span>
                        </v-list-item-title>

                        <v-list-item-title v-else @click="startAct(act.type, item.id, act.dialog)">
                            <v-icon small class="mr-2" :color="act.color">
                                {{act.icon}}
                            </v-icon>

                            <span>{{act.tooltip}}</span>
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </template>

        <template v-slot:no-results>
            <EmptyData text="Nenhum registro encontrado!" />
        </template>
        <template v-slot:no-data>
            <EmptyData text="Nenhum registro encontrado!" />
        </template>
    </v-data-table>
</template>

<script>
import EmptyData from "@/components/dashboard/skeletons/EmptyData.vue"

export default {
    name: 'TableDefault',
    components: {
        EmptyData
    },
    props: [
        'name',
        'headers',
        'data',
        'actions',
    ],
    data () {
        return {
            search: '',

            currentPage: 1,
            total: 0,
            pageSize: 10,
            loading: true,

            dialogDelete: false,
            dialogType: '',
            deleteId: -1,

            dialog: false,
            dialogHeadersProducts: [
                { text: 'Nome', align: 'start', value: 'product' },
                { text: 'Peso', value: 'weight' },
                { text: 'Altura', value: 'height' },
                { text: 'Largura', value: 'width' },
                { text: 'Quantidade', value: 'qtd' },
                { text: 'Preço Unitário', value: 'price' },
                { text: 'Preço Total', value: 'total_price' }
            ],
            dialogHeadersSellProducts: [
                { text: 'ID', align: 'start', value: 'product_id' },
                { text: 'Nome', value: 'product_name' },
                { text: 'Peso', value: 'product_weight' },
                { text: 'Fornecedor', value: 'supplier_name' },
                { text: 'Quantidade', value: 'qtd' },
                { text: 'Preço Unitário', value: 'product_price' },
                { text: 'Preço Total', value: 'total_price' }
            ],
            dialogData: [],

            items: [],
        }
    },
    mounted () {

    },
    methods: {
        getItemPerPage(val) {
            this.pageSize = val
            this.getData()
        },
        getData: function () {
            this.loading = true

            this.$http.get('/api/dashboard/' + this.name + '/get', {
                'headers': {
                    Authorization: 'Bearer ' + this.$store.getters['AuthUser/getToken']
                }
            }).then(response => {
                if (response.data.cod === 200) {
                    this.items = response.data.data
                    this.total = response.data.data.length
                } else {
                    this.items = []
                    this.total = 0
                }
                this.loading = false
            })
        },
        startAct: function (type, id, dialog = null) {
            if (type === 'delete') {
                this.dialogDelete = true
                this.deleteId = id
            } else if (type === 'edit') {
                this.$router.push('/dashboard/' + this.name + '/edit/' + id)
            }
        },
        confirmDelete: function () {
            if (this.deleteId > -1) {
                this.$store.commit('DashboardAlert/setAlert', {
                    value: true,
                    data: {
                        text: 'Deletando registro! Favor, aguarde...',
                        type: 'info'
                    }
                })
                this.$http.delete('/api/dashboard/' + this.name + '/delete/' + this.deleteId, {
                    'headers': {
                        Authorization: 'Bearer ' + this.$store.getters['AuthUser/getToken']
                    }
                }).then(response => {
                    if (response.data.cod === 200) {
                        this.$store.commit('DashboardAlert/setAlert', {
                            value: true,
                            data: {
                                text: 'Registro deletado com sucesso!',
                                type: 'success'
                            }
                        })
                        this.getData()
                    } else {
                        this.$store.commit('DashboardAlert/setAlert', {
                            value: true,
                            data: {
                                text: response.data.error,
                                type: 'error'
                            }
                        })
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
                });
            }
            this.dialogDelete = false
            this.deleteId = -1
        },

        getPaymentMethod: function (type) {
            let paymentName = ''
            switch (type) {
                case 1:
                    paymentName = 'Cartão de Crédito'
                    break;
                case 2:
                    paymentName = 'Cartão de Débito'
                    break;
                case 3:
                    paymentName = 'Cheque'
                    break;
                default:
                    paymentName = 'Dinheiro'
            }

            return paymentName
        },
        getPaymentType: function (type) {
            let format = ''
            if (type > 1) {
                format = 'Parcelado em ' + type + 'x'
            } else {
                format = 'À vista'
            }

            return format
        },
        getIdentType: function (type) {
            let identName = ''
            if (type == 1) {
                identName = 'Fisica'
            } else {
                identName = 'Juridica'
            }

            return identName
        },

        formatCpfCnpj: function (value) {
            if (!value) return "";
            value = value.replace(/\D/g, "");

            if (value.length <= 11) {
                return value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
            } else {
                return value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
            }
        },
        formatTel: function (value) {
            if (!value) return "";

            value = value.replace(/\D/g, "");

            if (value.length === 10) {
                return value.replace(/(\d{2})(\d{4})(\d{4})/, "($1) $2-$3");
            } else if (value.length === 11) {
                return value.replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
            }

            return value;
        },

        showDialog: function (item, type) {
            this.dialogData = item
            this.dialogType = type
            this.dialog = true
        },
        close () {
            this.dialog = false
            this.dialogType = ''
            this.dialogData = []
        },
    },
    created () {
        this.getData()
    },
    watch: {
        currentPage () {
            this.getData()
        },
        pageSize () {
            this.getData()
        },
    },
}
</script>

<style scoped>

</style>
