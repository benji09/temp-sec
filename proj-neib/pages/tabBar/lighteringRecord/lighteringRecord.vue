<template>
	<view class="content">
		<view class="record-section"  v-for="(item, index) in resData" :key="index">
			<view>
				<text>编号：{{item.id}}</text>
			</view>
			<view class="record-row">
				<text class="col1">{{item.entrust}}->{{item.delivery}}</text>
				<text class="col2">{{item.cargoType}}</text>
				<text class="col5">{{setStatus(item.status)}}</text>
			</view>
			<view class="record-row">
				<text class="col1">{{item.drayageFrom}}->{{item.drayageTo}}</text>
				<text class="col2">{{item.cargoProperty}}</text>
			</view>
			<view class="record-row">
				<button @tap="remarkBtn(item.id)">备注</button>
				<button v-if="innerGroupUser && item.status == 1" @tap="arriveToOrderPlace(item.id)">到达接单地</button>
				<button v-if="innerGroupUser && item.status == 2" @tap="headedBtn(item.id, item.allUldNo, item.cargoNum, item.shelfNum)">已出发</button>
				<button v-if="innerGroupUser && item.status == 3" @tap="arriveToDestination(item.id)">到达目的地</button>
				<button v-if="InOutUser && item.status == 4" @tap="receive(item.id)">接收</button>
			</view>
		</view>
	</view>
	
</template>

<script>
	import {mapState} from 'vuex';
	export default {
		name: 'lighteringRecord',
		data() {
			return {
				resData: [],
				resId: '96602',
				InOutUser: false,
				innerGroupUser: false,
				userId: '',
				statusData: null
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
							for (var i = 0; i < data.length; i++) {
								var res = data[i];
								if (res.resId === '96602') {
									this.InOutUser = true;
								} else if (res.resId === '96603') {
									this.innerGroupUser = true;
								}
							}
							// userId不是必传, 96602权限不传，96603权限必传
							if (this.InOutUser) {
								this.userId = null;
								this.statusData = 4;
							} else if (this.innerGroupUser) {
								this.userId = this.id;
							} else {
								return;
							}
							this.dataList();
						}else {
							console.log('权限接口内部报错');
						}
					}
				})
				
			}
		},
		methods: {
			dataList() {
				this.request({
					url: '/terminal/innerLighter/selectOrderListPhone', 
					method: 'POST',
					data: {
						type: 2,
						userId: this.userId,
						status: this.statusData
					},
					success: res => {
						uni.hideLoading();
						console.log('驳运记录', res);
						this.resData = res.data.data;
					}
				});
							
			},
			setStatus(status) {
				let statusText = '';
				if (status == 1) statusText = '已接单';
				if (status == 2) statusText = '到达接单地';
				if (status == 3) statusText = '已出发';
				if (status == 4) statusText = '到达目的地';
				if (status == 5) statusText = '已接收';
				return statusText;
			},
			remarkBtn(id) {
				uni.navigateTo({
					url: '../../remark/remark?id=' + id
				})
			},
			headedBtn(id, allUldNo) {
				uni.navigateTo({
					url: '../../headed/headed?id=' + id + '&allUldNo=' + encodeURIComponent(allUldNo)
				})
			},
			arriveToOrderPlace(id) {
				const userId = this.id;
				const applyUser = this.username;
				var that = this;
				uni.showModal({
				    title: '确认到达接单地',
				    content: '是否确认到达接单地？',
				    success: function (res) {
				        if (res.confirm) {
							that.request({
								url: '/terminal/innerLighter/updateOrderData',
								method: 'POST',
								data: {
									status: 2,
									id: id,
									userId: userId,
									applyUser: applyUser
								},
								success: res => {
									if (res && res.data && res.data.status == 200) {
										console.log('到达接单地: ', res);
										uni.showToast({
											title: '已确认到达接单地',
											duration: 2000
										});
										that.dataList();
									}else {
										uni.showToast({
											title: '确认到达接单地提交失败',
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
			arriveToDestination(id) {
				const userId = this.id;
				const applyUser = this.username;
				var that = this;
				uni.showModal({
				    title: '确认到达目的地',
				    content: '是否确认到达目的地？',
				    success: function (res) {
				        if (res.confirm) {
							that.request({
								url: '/terminal/innerLighter/updateOrderData',
								method: 'POST',
								data: {
									status: 4,
									userId: userId,
									applyUser: applyUser,
									id: id
								},
								success: res => {
									console.log('到达目的地：', res);
									if (res && res.data && res.data.status == 200) {
										uni.showToast({
											title: '已确认到达目的地',
											duration: 2000
										});
										that.dataList();
									}else {
										uni.showToast({
											title: '到达目的地提交失败',
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
			receive(id) {
				const userId = this.id;
				const applyUser = this.username;
				var that = this;
				uni.showModal({
				    title: '确认接收',
				    content: '是否确认接收？',
				    success: function (res) {
						console.log('接收：', res);
				        if (res.confirm) {
							that.request({
								url: '/terminal/innerLighter/updateOrderData',
								method: 'POST',
								data: {
									status: 5,
									id: id,
									userId: userId,
									applyUser: applyUser
								},
								success: res => {
									if (res && res.data && res.data.status == 200) {
										uni.showToast({
											title: '已确认接收',
											duration: 2000
										});
										that.dataList();
									}else {
										uni.showToast({
											title: '已确认接收提交失败',
											duration: 2000
										});
									}
								}
							})
				        } else if (res.cancel) {
				        }
				    }
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
		margin: 10rpx 0;
	}
	.record-row .col1 {
		/* width: 160rpx; */
	}
	.record-row .col2 {
		/* width: 210rpx; */
	}
	.record-row .col3 {
		/* width: 90rpx; */
	}
	.record-row .col4 {
		/* width: 120rpx; */
	}
	.record-row .col5 {
		/* width: 160rpx; */
	}
	.record-row button {
		height: 60rpx;
		line-height: 60rpx;
		padding: 0 5rpx;
		font-size: 40rpx;
		margin: 5rpx;
	}

</style>
