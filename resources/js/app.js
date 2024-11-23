import './bootstrap';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import Header from './Pages/Components/Header.vue';
import Footer from './Pages/Components/Footer.vue';
import Banner from './Pages/Components/Banner.vue';

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.component('Header', Header);
        app.component('Footer', Footer);
        app.component('Banner', Banner);

        app.config.globalProperties.route = route;
        app.use(plugin).mount(el);
    },
});
