import '@/styles/index.scss';
import Vue from 'vue';
import * as Sentry from '@sentry/browser';
import { Vue as VueIntegration } from '@sentry/integrations';
import { Integrations } from '@sentry/tracing';
import * as filters from './filters'; // global filters
// import App from './views/App';
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('ExampleComponent', require('./components/ExampleComponent.vue').default);
Vue.component('HomeComponent', require('./components/HomeComponent.vue').default);
// Vue.component('AboutComponent', require('./components/AboutComponent.vue').default);
// Vue.component('NavComponent', require('./components/NavComponent.vue').default);
// Vue.component('FooterComponent', require('./components/FooterComponent.vue').default);
// Vue.component('WhoamiComponent', require('./components/WhoamiComponent.vue').default);

Sentry.init({
  dsn: process.env.MIX_SENTRY_DSN,
  integrations: [
    new Integrations.BrowserTracing(),
    new VueIntegration({
      Vue,
      tracing: true,
      tracingOptions: {
        trackComponents: true,
      },
      attachProps: true,
    }),
  ],
  // We recommend adjusting this value in production, or using tracesSampler
  // for finer control
  tracesSampleRate: 1.0,
});

// register global utility filters.
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key]);
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.config.productionTip = true;
new Vue({
  el: '#app',
});
