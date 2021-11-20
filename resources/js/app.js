import {useModal} from "@/UseModal";

require('./bootstrap');

// Import modules...
import Vue from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';
import { InertiaProgress } from '@inertiajs/progress'
import VueTailwind from 'vue-tailwind'
import settings from './vuetailwind'


Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
Vue.use(VueTailwind, settings);

const app = document.getElementById('app');

InertiaProgress.init({

    // The color of the progress bar.
    color: '#3edd22',

    // Whether the NProgress spinner will be shown.
    showSpinner: false,
})

new Vue({
    mixins: [useModal],
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
