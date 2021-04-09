import Vue from 'vue';

// Guest
Vue.component('app-guest', require('./components/Guest.vue').default);

// Peliculas
Vue.component('app-peliculas-index', require('./components/peliculas/index.vue').default);
Vue.component('app-peliculas-crear', require('./components/peliculas/crear.vue').default);

// Turnos
Vue.component('app-turnos-index', require('./components/turnos/index.vue').default);
Vue.component('app-turnos-crear', require('./components/turnos/crear.vue').default);
