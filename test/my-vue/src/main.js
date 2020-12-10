import Vue from 'vue';
import VueRouter from 'vue-router';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
// import Button from 'ant-design-vue/lib/button';
import Antd from 'ant-design-vue';
import 'ant-design-vue/dist/antd.css';
import App from './App.vue';
// import QrCode from 'qrcode'
import 'echarts-gl'
import Echarts from 'vue-echarts'
import axios from 'axios'
import VueAxios from 'vue-axios'




Vue.use(ElementUI);
Vue.use(Antd);
Vue.use(VueRouter);
Vue.component('v-chart', Echarts);
Vue.use(VueAxios, axios)



Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')
