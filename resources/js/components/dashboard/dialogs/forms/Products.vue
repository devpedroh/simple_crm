<template>
    <div class="products">
        <div class="card-title-more">
            <h4>Produtos</h4>

            <a href="#" @click="addProduct">
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
                                <v-select
                                    label="Produto"
                                    :items="products"
                                    item-text="name"
                                    item-value="id"
                                    v-model="inputs.product_id.text"
                                    :rules="inputs.product_id.validation"
                                    @change="selectedProduct"
                                >
                                    <template v-slot:selection="{ item, index }">
                                        <span>ID: {{ item.id }} - {{ item.name }}</span>
                                    </template>

                                    <template v-slot:item="{ item }">
                                        <span>ID: {{ item.id }} - {{ item.name }}</span>
                                    </template>

                                    <template v-slot:no-results>
                                        <EmptyData text="Nenhum produto encontrado" />
                                    </template>
                                    <template v-slot:no-data>
                                        <EmptyData text="Nenhum produto encontrado" />
                                    </template>
                                </v-select>

                                <v-select
                                    label="Fornecedor"
                                    :items="suppliers"
                                    item-text="name"
                                    item-value="id"
                                    v-model="inputs.supplier_id.text"
                                    :rules="inputs.supplier_id.validation"
                                    @change="selectedSupplier"
                                >
                                    <template v-slot:selection="{ item, index }">
                                        <span>ID: {{ item.id }} - {{ item.name }} ({{ item.identification }})</span>
                                    </template>

                                    <template v-slot:item="{ item }">
                                        <span>ID: {{ item.id }} - {{ item.name }} ({{ item.identification }})</span>
                                    </template>

                                    <template v-slot:no-results>
                                        <EmptyData text="Nenhum fornecedor encontrado" />
                                    </template>
                                    <template v-slot:no-data>
                                        <EmptyData text="Nenhum fornecedor encontrado" />
                                    </template>
                                </v-select>

                                <v-text-field
                                    label="Quantidade"
                                    step="0.01"
                                    min="0.01"
                                    type="number"
                                    v-model="inputs.qtd.text"
                                    :rules="inputs.qtd.validation"
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

            <template v-for="h in headers" v-slot:[`item.${h.value}`]="{ item }">
                <v-tooltip v-if="['product_name'].includes(h.value)" bottom>
                    <template v-slot:activator="{ on }">
                        <span v-on="on">{{item['product']['name']}}</span>
                    </template>
                    <span>{{item['product']['name']}}</span>
                </v-tooltip>

                <v-tooltip v-else-if="['product_weight'].includes(h.value)" bottom>
                    <template v-slot:activator="{ on }">
                        <span v-on="on">{{item['product']['weight_unit'] ? (item['product']['weight_unit']['short_form'] ? item['product']['weight'] + item['product']['weight_unit']['short_form'] : '') : ''}}</span>
                    </template>
                    <span>{{item['product']['weight_unit'] ? (item['product']['weight_unit']['short_form'] ? item['product']['weight'] + item['product']['weight_unit']['short_form'] : '') : ''}}</span>
                </v-tooltip>

                <v-tooltip v-else-if="['product_price'].includes(h.value)" bottom>
                    <template v-slot:activator="{ on }">
                        <span v-on="on">{{Number(item['product']['price']).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}}</span>
                    </template>
                    <span>{{Number(item['product']['price']).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}}</span>
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

            <template v-slot:item.actions="{ item, index }">
                <v-icon small color="amber" class="mr-3" @click="editProduct(index)">
                    mdi-pencil
                </v-icon>
                <v-icon small color="red" @click="removeProduct(index)">
                    mdi-delete
                </v-icon>
            </template>

            <template v-slot:no-results>
                <EmptyData text="Nenhum produto cadastrado!" />
            </template>
            <template v-slot:no-data>
                <EmptyData text="Nenhum produto cadastrado!" />
            </template>
        </v-data-table>
    </div>
</template>

<script>
import EmptyData from "@/components/dashboard/skeletons/EmptyData.vue";

export default {
    name: 'Products',
    components: {
        EmptyData
    },
    props: [
        'data',
        'products',
        'suppliers'
    ],
    data () {
        return {
            valid: false,
            dialog: false,

            selectedIndex: -1,

            headers: [
                { text: 'ID', align: 'start', value: 'product_id' },
                { text: 'Nome', value: 'product_name' },
                { text: 'Peso', value: 'product_weight' },
                { text: 'Fornecedor', value: 'supplier_name' },
                { text: 'Preço Unitário', value: 'product_price' },
                { text: 'Quantidade', value: 'qtd' },
                { text: 'Preço Total', value: 'total_price' },
                { text: '', value: 'actions' },
            ],

            inputs: {
                'product_id': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                    ]
                },
                'product': {
                    'name': '',
                    'price': '',
                    'weight': '',
                    'weight_unit': {
                        'short_form': ''
                    }
                },
                'supplier_id': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                    ]
                },
                'supplier': {
                    'name': '',
                    'identification': ''
                },
                'qtd': {
                    'text': '',
                    'validation': [
                        v => !!v || 'Este campo deve ser preenchido',
                    ]
                },
                'total_price': {
                    'text': '',
                    'validation': []
                },
            },
        }
    },
    methods: {
        clearProduct () {
            this.inputs.product_id.text = ''
            this.inputs.product = {
                'name': '',
                'price': '',
                'weight': '',
                'weight_unit': {
                    'short_form': ''
                }
            }
            this.inputs.supplier_id.text = ''
            this.inputs.supplier = {
                'name': '',
                'identification': ''
            }
            this.inputs.qtd.text = ''
            this.inputs.total_price.text = 0
            this.selectedIndex = -1
        },

        selectedProduct: function () {

            let product = this.products.filter((data) => {
                return data.id.toString().match(this.inputs.product_id.text)
            })[0]

            this.inputs.product = {
                'name': product.name,
                'price': product.price,
                'weight': product.weight,
                'weight_unit': {
                    'short_form': product.weight_unit ? product.weight_unit.short_form : ''
                }
            }

        },
        selectedSupplier: function () {

            let supplier = this.suppliers.filter((data) => {
                return data.id.toString().match(this.inputs.supplier_id.text)
            })[0]

            this.inputs.supplier = {
                'name': supplier.name,
                'identification': supplier.identification
            }

        },

        addProduct: function () {
            this.clearProduct()
            this.dialog = true
        },
        editProduct: function (index) {
            this.selectedIndex = index

            this.inputs.product_id.text = this.data[this.selectedIndex].product_id
            this.inputs.product = {
                'name': this.data[this.selectedIndex].product.name,
                'price': this.data[this.selectedIndex].product.price,
                'weight': this.data[this.selectedIndex].product.weight,
                'weight_unit': {
                    'short_form': (this.data[this.selectedIndex].product.weight_unit ? this.data[this.selectedIndex].product.weight_unit.short_form : '')
                }
            }
            this.inputs.supplier_id.text = this.data[this.selectedIndex].supplier_id
            this.inputs.supplier = {
                'name': this.data[this.selectedIndex].supplier.name,
                'identification': this.data[this.selectedIndex].supplier.identification
            }
            this.inputs.qtd.text = this.data[this.selectedIndex].qtd
            this.inputs.total_price.text = this.inputs.product.price * this.inputs.qtd.text
            this.dialog = true
        },
        removeProduct: function (index) {
            this.data.splice(index, 1)
        },

        save () {
            if (this.selectedIndex >= 0) {
                this.data[this.selectedIndex].product_id = this.inputs.product_id.text
                this.data[this.selectedIndex].supplier_id = this.inputs.supplier_id.text
                this.data[this.selectedIndex].product = {
                    'name': this.inputs.product.name,
                    'price': this.inputs.product.price,
                    'weight': this.inputs.product.weight,
                    'weight_unit': {
                        'short_form': (this.inputs.product.weight_unit ? this.inputs.product.weight_unit.short_form : '')
                    }
                }
                this.data[this.selectedIndex].supplier = {
                    'name': this.inputs.supplier.name,
                    'identification': this.inputs.supplier.identification
                }
                this.data[this.selectedIndex].qtd = this.inputs.qtd.text
                this.data[this.selectedIndex].total_price = this.inputs.product.price * this.inputs.qtd.text
            } else {
                this.data.push({
                    product_id: this.inputs.product_id.text,
                    product: {
                        'name': this.inputs.product.name,
                        'price': this.inputs.product.price,
                        'weight': this.inputs.product.weight,
                        'weight_unit': {
                            'short_form': this.inputs.product.weight_unit.short_form
                        }
                    },
                    supplier_id: this.inputs.supplier_id.text,
                    supplier: {
                        'name': this.inputs.supplier.name,
                        'identification': this.inputs.supplier.identification
                    },
                    qtd: this.inputs.qtd.text,
                    total_price: this.inputs.product.price * this.inputs.qtd.text,
                })
            }
            this.close()
        },

        close () {
            this.dialog = false
            this.clearProduct()
        },
    }
}
</script>

<style scoped>

</style>
