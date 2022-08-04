<template>
	<view class="content">
		<view class="record-section">
			<view>
				<text>编号：12345678</text>
			</view>
			<view class="record-row section-mg-tb">
				<text class="col1">进港->出港</text>
				<text class="col2">集装货物（C）</text>
				<text class="col5">正在驳运</text>
			</view>
			<view class="record-row section-mg-tb">
				<text class="col1">T1->T3</text>
				<text class="col2">冷藏货转场冷藏（冷）</text>
				<text class="col3"></text>
				<button class="col4">备注</button>
				<button class="col5">确认</button>
			</view>
		</view>
		<view class="record-section">
			<view>
				<text>编号：12345678</text>
			</view>
			<view class="record-row section-mg-tb">
				<text class="col1">进港->出港</text>
				<text class="col2">集装货物（C）</text>
				<text class="col5">正在驳运</text>
			</view>
			<view class="record-row section-mg-tb">
				<text class="col1">T1->T3</text>
				<text class="col2">冷藏货转场冷藏（冷）</text>
				<text class="col3"></text>
				<button class="col4">备注</button>
				<button class="col5">确认</button>
			</view>
		</view>
		<view class="record-section">
			<view>
				<text>编号：12345678</text>
			</view>
			<view class="record-row section-mg-tb">
				<text class="col1">进港->出港</text>
				<text class="col2">集装货物（C）</text>
				<text class="col5">正在驳运</text>
			</view>
			<view class="record-row section-mg-tb">
				<text class="col1">T1->T3</text>
				<text class="col2">冷藏货转场冷藏（冷）</text>
				<text class="col3"></text>
				<button class="col4">备注</button>
				<button class="col5">确认</button>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		name: 'pendingList',
		data() {
			return {
				title: 'test',
				items: [{
				        value: 'temp1',
				        name: 'AKE123456'
				    },
				    {
				        value: 'temp2',
				        name: 'AKE123456',
				        checked: 'true'
				    },
				    {
				        value: 'temp3',
				        name: 'AKE123456'
				    },
				    {
				        value: 'temp4',
				        name: 'AKE123456'
				    }
				],
				fileLists: [{
					url: 'https://vkceyugu.cdn.bspapp.com/VKCEYUGU-dc-site/b7c7f970-517d-11eb-97b7-0dc4655d6e68.jpg',
					extname: 'png',
					name: 'shuijiao.png'
				}]
			} 
		},
		onLoad() {
			
		},
		methods: {
			checkboxChange: function (e) {
			    var items = this.items,
			        values = e.detail.value;
			    for (var i = 0, lenI = items.length; i < lenI; ++i) {
			        const item = items[i]
			        if(values.includes(item.value)){
			            this.$set(item,'checked',true)
			        }else{
			            this.$set(item,'checked',false)
			        }
			    }
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
		/* background: pink; */
		width: 160rpx;
	}
	.record-row .col2 {
		/* background: pink; */
		width: 210rpx;
	}
	.record-row .col3 {
		/* background: pink; */
		width: 90rpx;
	}
	.record-row .col4 {
		/* background: pink; */
		width: 120rpx;
	}
	.record-row .col5 {
		/* background: pink; */
		width: 120rpx;
	}
	button {
		width: 120rpx;
		height: 50rpx;
		line-height: 50rpx;
		font-size: 40rpx;
		/* display: inline-block; */
		margin: 5rpx;
	}

</style>
