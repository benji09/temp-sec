import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

let userState = {
	hasLogin: false, // 是否登录
	username: '',
	id: '',
	dept_id: '',
	type: '',
	token: ''
};

const userInfo = uni.getStorageSync('userInfo');
if(userInfo.hasLogin){	
	userState = userInfo;
}

const store = new Vuex.Store({
    state: {...userState},
    mutations: {
        login(state, data) {
            state.hasLogin = true;
			state.username = data.username;
            state.id = data.data.user.id;
			state.dept_id = data.data.user.dept_id;
			state.type = data.data.user.type;
			state.token = data.data.token;
			// 设置本地数据缓存
			uni.setStorageSync('userInfo', {...state});	
        },
        logout(state) {			
            state.hasLogin = false;
			state.username = '';
			state.id = '';
			state.dept_id = '';
			state.type = '';
			state.token = '';
			uni.clearStorageSync();
        }
    }
});

export default store
