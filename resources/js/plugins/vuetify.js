import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import pt from 'vuetify/lib/locale/pt';

Vue.use(Vuetify);

export default new Vuetify({
    lang: {
        locales: { pt },
        current: 'pt',
    },
    theme: {
        themes: {
            light: {
                primary: "#B622B5",
                secondary: "#FF8F00",
                accent: "#8C9EFF",
                error: "#FF5252",
                info: "#2196F3",
                success: "#4CAF50",
                warning: "#FFC107"
            },
            dark: {
                primary: "#BB86FC",
                secondary: "#03DAC6",
                accent: "#03A9F4",
                error: "#CF6679",
                info: "#2196F3",
                success: "#4CAF50",
                warning: "#FFC107"
            }
        }
    }
});
