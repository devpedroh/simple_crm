import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';

import vuetify from './plugins/vuetify';
import '@mdi/font/css/materialdesignicons.css';
import VuetifyMask from "vuetify-mask";

import moment from 'moment';
import 'moment/locale/pt-br';
import pt from 'moment/dist/locale/pt-br';

import axios from 'axios'
import VueCookies from 'vue-cookies';

Vue.config.productionTip = false;

Vue.prototype.$http = axios

moment.locale('pt-br');
moment.updateLocale('pt-br', {
    months: [
        "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
        "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
    ],
    weekdays: [
        "Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sabado"
    ]
});
Vue.prototype.moment = moment

Vue.prototype.$numberFormat = (value) => {
    if (!value) return '0';

    const hasDecimal = value % 1 !== 0;

    return new Intl.NumberFormat('pt-BR', {
        style: 'decimal',
        minimumFractionDigits: hasDecimal ? 2 : 0,
        maximumFractionDigits: 2
    }).format(value);
}

Vue.use(VuetifyMask);
Vue.use(VueCookies);

new Vue({
    router,
    store,
    vuetify,
    render: (h) => h(App),
}).$mount('#app');
