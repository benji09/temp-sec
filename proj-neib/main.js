import Vue from 'vue'
import App from './App'

import store from './store'

Vue.config.productionTip = false

Vue.prototype.$store = store

// 封装Request请求并挂载到Vue原型上
Vue.prototype.apiUrl = '/h5api';

Vue.prototype.request = function(obj) {
	var header = obj.header || {}
	if (uni.getStorageSync('token')) {
		header['token'] = uni.getStorageSync("token");
	}
	uni.request({
		// 设置请求地址 变成了 /h5api+后台路由接口 以/h5api的请求都会被代理 
		url: this.apiUrl + obj.url, 
		data: obj.data || {},
		method: obj.method || 'GET',
		header: header,
		success: res => {
		    typeof obj.success == "function" && obj.success(res)
		},
		fail: res => {
		    typeof obj.fail == "function" && obj.fail(res)
		}
	});
}

Vue.prototype.uploadFile = function(obj) {
	var header = obj.header || {}
	if (uni.getStorageSync('token')) {
		header['token'] = uni.getStorageSync("token");
	}
	uni.uploadFile({
		url: this.apiUrl + obj.url, 
		filePath: obj.filePath || '',
		name: obj.name || '',
		type: obj.type || '',
		data: obj.data || {},
		method: obj.method || 'GET',
		header: header,
		success: res => {
		    typeof obj.success == "function" && obj.success(res)
		},
		fail: res => {
		    typeof obj.fail == "function" && obj.fail(res)
		}
	});
}



App.mpType = 'app'

const app = new Vue({
    ...App,
	store
})

app.$mount()
