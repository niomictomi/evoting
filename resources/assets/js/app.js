
require('sweetalert');

window.Vue = require('vue');

import Chartkick from 'chartkick'
import VueChartkick from 'vue-chartkick'
import Chart from 'chart.js'

Vue.use(VueChartkick, { Chartkick })

Vue.component('card-paslon', require('./components/CardPaslon.vue'));
Vue.component('card-calon-dpm', require('./components/CardCalonDPM.vue'));
Vue.component('timer', require('./components/Timer.vue'));