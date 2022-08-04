<template>
    <view class="content">
        <view class="input-group">
            <view class="input-row border">
                <text class="title">账号</text>
                <input type="text" v-model="username" placeholder="请输入账号">
            </view>
            <view class="input-row">
                <text class="title">密码</text>
                <input type="text" password="true" v-model="password" placeholder="请输入密码">
            </view>
        </view>
        <view class="btn-row">
            <button type="primary" class="primary" @tap="bindLogin">登录</button>
        </view>
    </view>
</template>

<script>
	import {mapState, mapMutations} from 'vuex';
	import jsSHA from '../../../common/sha1.js';
	export default {
		data() {
			return {
				username: 'CLP601',
				password: '123456',
			};
		},	
		computed: {
			secureCode() {
				const shaObj = new jsSHA('SHA-1', 'TEXT');
				shaObj.update(this.password);
				return shaObj.getHash('HEX');
			}
		},
		methods:{
			...mapMutations(['login']),
			bindLogin(){
				uni.showLoading({
				    title: '登陆中'
				});
				setTimeout(function () {
				    uni.hideLoading();
				}, 2000);
				
				this.request({
					url: '/sso/login?username=' + this.username + '&checkCode=&password=' + this.secureCode,
					method: 'POST',
					data: {
					},
					success: res => {
						console.log('登录：', res);
						if (res && res.data && res.data.status == 200) {
							uni.hideLoading();
							const parsedData = JSON.parse(res.data.data);
							console.log('parsedInfo: ', parsedData);
							this.toLogin(this.username, parsedData);
						}else {
							uni.showToast({
								icon: 'none',
								title: res.data.msg
							})
						}
						
					},
					fail: () => {
						uni.showToast({
							icon: 'none',
							title: '用户账号或密码不正确'
						})
					},
					complete: () => {}
				});				
			},
			toLogin(username, data){
				this.login({username, data});
				uni.reLaunch({
					url: '../../tabBar/pendingApplication/pendingApplication',
				});
			}
		}
	}
</script>

<style>
	@import '../../../common/denglu.css';
	
	.input-row input{
		margin-left: 15upx;
	}
</style>
