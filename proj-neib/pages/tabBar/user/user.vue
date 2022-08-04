<template>
	<view class="content">
		<view class="top-content">
			<view class="row">
				<text>姓名</text>
				<input v-model="username" name="name"  />
			</view>
			<view class="row">
				<text>班次</text>
				<input v-model="shift" name="shift" />
			</view>
		</view>
		<view class="row">
			<text>移动设备id</text>
			<input v-model="mobileId" name="mobileId" />
		</view>
		<view class="row">
			<text>车牌号</text>
			<input v-model="plateNo" name="plateNo" />
		</view>
		<view>
			<button @tap="quit">退出</button>
		</view>
	</view>
</template>

<script>
	import {mapState} from 'vuex';
	export default {
		name: 'user',
		data() {
			return {
				shift: '',
				mobileId: '',
				plateNo: ''
			}
		},
		computed: mapState(['hasLogin', 'username', 'id']),
		onLoad() {
			if (!this.hasLogin) {
				uni.reLaunch({
					url: '../../loginFlow/login/login'
				});
			}else {
				uni.showLoading({
				    title: '请求数据中'
				});
				setTimeout(function () {
				    uni.hideLoading();
				}, 2000);
				
				this.request({
					url: '/terminal/innerLighter/selectInnerLighterUser',
					method: 'POST',
					data: {
						userId: this.id,
					},
					success: res => {
						uni.hideLoading();
						console.log('查询信息：', res);
						// CLP601，CLP602有数据
						if (res && res.data && res.data.status == 200) {
							if (res.data.data) {
								const info = res.data.data;
								this.plateNo = info.plateNo;
								this.mobileId = info.mobileId;
								this.shift = info.shift;
							}
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
			}
		},
		methods: {
			quit() {
				uni.navigateTo({
					url:'../../loginFlow/logout/logout',
				});
			}
		}
	}
</script>

<style>
	.content {
		display: flex;
		flex-direction: column;
		color: #333;
		font-size: 40rpx;
	}
	.top-content {
		border-bottom: 1rpx solid #999;
		padding-bottom: 30rpx;
		margin-bottom: 30rpx;
	}
	.row {
		margin: 30rpx 0;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.row text{
		width: 160rpx;
		display: inline-block;
		text-align: right;
	}
	.row input {
		width: 200rpx;
		margin-left: 40px;
		border: 1rpx solid #999;
		display: inline-block;
	}
	button {
		width: 200rpx;
		height: 60rpx;
		line-height: 60rpx;
		font-size: 40rpx;
		margin: 300rpx auto 0;
		color: #333;
	}
</style>
