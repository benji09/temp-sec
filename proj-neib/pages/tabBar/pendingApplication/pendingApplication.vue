<template>
	<view class="content">
		
		<view class="record-section" v-for="(item, index) in resData" :key="index">
			<view>
				<text>编号：{{item.id}}</text>
			</view>
			<view class="record-row section-mg-tb">
				<text class="col1">{{item.entrust}}->{{item.delivery}}</text>
				<text class="col2">{{item.cargoType}}</text>
				<text class="col5">{{setStatus(item.status)}}</text>
			</view>
			<view class="record-row section-mg-tb">
				<text class="col1">{{item.drayageFrom}}->{{item.drayageTo}}</text>
				<text class="col2">{{item.cargoProperty}}</text>
				<button class="col3" @tap="remarkBtn(item.id)">备注</button>
				
				<button v-if="innerGroupUser && (item.status == 3 || item.status == 4)" class="col4" @tap="orderBtn(item.id)">接单</button>
				<button v-if="InOutUser && item.status == 2" class="col5" @tap="confirmBtn(item.id)">确认</button>
			</view>
		</view>
		
		
	</view>
</template>

<script>
	import {mapState} from 'vuex';
	export default {
		name: 'pendingApplication',
		data() {
			return {
				resData: [],
				resId: '96602',
				InOutUser: false,
				innerGroupUser: false,
			} 
		},
		computed: mapState(['hasLogin', 'token', 'dept_id', 'id', 'username']),
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
					url: '/pactlorg/tokens/getPermission/' + this.token + '/' + this.dept_id + '/' + this.resId ,
					data: {
					},
					success: res => {
						console.log('查看权限：', res);
						if (res && res.data && res.data.length > 0) {
							const data = res.data;
							for (let i = 0; i < data.length; i++) {
								const res = data[i];
								if (res.resId === '96602') {
									this.InOutUser = true;
								} else if (res.resId === '96603') {
									this.innerGroupUser = true;
								}
							}
							this.request({
								url: '/terminal/innerLighter/selectOrderListPhone',
								method: 'POST',
								data: {
									type: 1,
									userId: this.id,
								},
								success: res => {
									uni.hideLoading();
									console.log('待处理列表：', res);
									if (this.InOutUser) {
										this.resData = res.data.data.filter((item, index) => {
											return item.status === 2;
										})
									} else if (this.innerGroupUser) {
										this.resData = res.data.data.filter((item, index) => {
											return item.status === 3 ||  item.status === 4;
										})
									}
								}
							});
						}else {
							console.log('权限接口内部报错');
						}
					}
				})
			}
			
		},
		
		methods: {
			setStatus(status) {
				let statusText = '';
				if (status == 1) statusText = '未申请';
				if (status == 2) statusText = '已申请';
				if (status == 3) statusText = '已确认';
				if (status == 4) statusText = '正在驳运';
				if (status == 5) statusText = '驳运完成';
				return statusText;
			},
			remarkBtn(id) {
				uni.navigateTo({
					url: '../../remark/remark?id='+id
				})
			},
			orderBtn(id) {
				const userId = this.id;
				const applyUser = this.username;
				var that = this;
				uni.showModal({
				    title: '确认接单',
				    content: '是否确认接单？',
				    success: function (res) {
				        if (res.confirm) {
							// that.$options.methods.toRequest(id);
							that.request({
								url: '/terminal/innerLighter/updateOrderData',
								method: 'POST',
								data: {
									status: 1,
									sid: id,
									userId: userId,
									applyUser: applyUser
								},
								success: res => {
									console.log('接单：', res);
									if (res && res.data && res.data.status == 200) {
										uni.showToast({
											title: '已成功接单',
											duration: 2000
										});
									}else {
										uni.showToast({
											title: '接单请求失败',
											duration: 2000
										});
									}
								}
							})
				        } else if (res.cancel) {
				        }
				    }
				});
			},
			
			confirmBtn(id) {
				uni.navigateTo({
					url: '../../confirmation/confirmation?id=' + id
				})
			},
			
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
	.record-section {
		border-bottom: 1rpx solid #999;
		padding: 15rpx 0;
	}
	.record-row {
		padding: 0 30rpx;
		display: flex;
		justify-content: space-between;
	}
	.section-mg-tb {
	}
	.record-row .col1 {
		/* width: 160rpx; */
	}
	.record-row .col2 {
		/* width: 120rpx; */
	}
	.record-row .col3 {
		/* width: 120rpx; */
	}
	.record-row .col4 {
		/* width: 120rpx; */
	}
	.record-row .col5 {
		/* width: 120rpx; */
	}
	button {
		height: 60rpx;
		line-height: 60rpx;
		font-size: 40rpx;
		margin: 5rpx;
	}

</style>
