<template>
	<view class="content">
		<view>
			<text>编号：{{headedId}}</text>
		</view>
		<view class="section-flex section-mg-tb">
			<text>板箱号/散货车号：</text>
			<view class="checkbox-list">
				<checkbox-group @change="checkboxChange">
					<label class="checkbox-label section-mg-tb" v-for="item in allUldNoArray" :key="item.name">
						<view class="checkbox-value">{{item.name}}</view>
						<view>
							<checkbox :value="item.name" :checked="item.checked" />
						</view>
					</label>
				</checkbox-group>
			</view>
		</view>
		<view class="section-flex section-mg-tb">
			<text>确认外观是否完整：</text> 
			<radio-group @change="radioChange">
				<label class="radio" v-for="(item,index) in radioItems" :key="index">
					<radio :id="item.name" :value="item.name" :checked="item.checked"></radio>
					<label class="radio-value" :for="item.name">
						<text>{{item.value}}</text>
					</label>
				</label>
			</radio-group>
		</view>
		<view class="section-flex section-mg-tb">
			<text>使用架子车数量：</text>
			<input type="text" v-model="cargoNum" placeholder="请填写数字" />
		</view>
		<view class="section-flex section-mg-tb">
			<text>使用散货车数量：</text>
			<input type="text" v-model="shelfNum" placeholder="请填写数字" />
		</view>
		<view class="section-mg-tb">
			<view class="section-mg-tb">备注：</view>
			<view class="section-textarea">
				<textarea @blur="textAreaBlur" auto-height />
			</view>
		</view>
		<button class="confirm" @tap="confirmBtn">已出发</button>
	</view>
</template>

<script>
	import {mapState} from 'vuex';
	export default {
		name: 'headed',
		data() {
			return {
				headedId: '',
				radioItems: [{
						name: '1',
						value: '是',
						checked: 'true'
					},
					{
						name: '0',
						value: '否',
					}
				],
				cargoTypeArray: [
					{name:'集装货物', code: "C"},
					{name: '散货', code: "L"}, 
					{name:'空集装板箱/叠板', code: "U"}, 
					{name:'集装器附件', code: "A"},
				],
				cargoPropertyArray : [
					{name: "冷藏货转场冷藏", code: "冷"},
					{name: "危险品转场存储", code: "危"}, 
					{name: "集控空板箱", code: "集"},
					{name: "空转陆中转", code: "陆"}, 
					{name: "空转空中转", code: "空"},
					{name: "FEDEX", code: "快"},
					{name: "国际出港调配", code: "出"},
					{name: "业务袋", code: "业"}, 
					{name: "其他", code: "其"}
				],
				allUldNoArray: [],
				cargoType: '',
				cargoProperty: '',
				typeIndex: 0,
				propertyIndex: 0,
				uldNoIndex: 0,
				remark: '',
				uldNo: '',
				cargoNum: 0,
				shelfNum: 0,
				isIntact: 1,
				orderedUldNo: []
			} 
		},
		computed: mapState(['hasLogin', 'id', 'username']),
		onLoad(option) {
			if (!this.hasLogin) {
				uni.reLaunch({
					url: '../loginFlow/login/login'
				});
			}else {
				this.headedId = option.id;
				this.request({
					url: '/terminal/innerLighter/selecOrdertList',
					method: 'POST',
					data: {
						sid: '10011'
					},
					success: res => {
						console.log('已被接单的板箱号：', res);
						if (res && res.data && res.data.status == 200) {
							const dataArray = res.data.data;
							const filteredArray = dataArray.filter((item, index) => {
								return (item.status == 3 || item.status == 4 || item.status == 5);
							})
							const temp = filteredArray.map(item => {
								return item.uldNo.split(',');
							}).flat();
							// 已被接单的板箱号
							const orderedUldNo = Array.from(new Set(temp));
							const allUldNos= decodeURIComponent(option.allUldNo).split(',');
							const copyAllUldNos = [...allUldNos];
							orderedUldNo.forEach(item => {
								copyAllUldNos.splice(copyAllUldNos.indexOf(item), 1)
							})
							copyAllUldNos.forEach(item => {
								this.allUldNoArray.push({name: item});
							})
						}else {
						}
						
					}
				})
				
			}
			
		},
		methods: {
			radioChange: function(e) {
				var checked = e.target.value
				var changed = {}
				for (var i = 0; i < this.radioItems.length; i++) {
					if (checked.indexOf(this.radioItems[i].name) !== -1) {
						changed['radioItems[' + i + '].checked'] = true
					} else {
						changed['radioItems[' + i + '].checked'] = false
					}
				}
				this.isIntact = checked;
			},
			checkboxChange: function (e) {
			    var items = this.allUldNoArray;
				var values = e.target.value;
			    for (var i = 0; i < items.length; ++i) {
			        const item = items[i]
			        if(values.includes(item)){
			            this.$set(item,'checked',true)
			        }else{
			            this.$set(item,'checked',false)
			        }
			    }
				this.uldNo = values.join(',');
			},
			textAreaBlur: function (e) {
				this.remark = e.detail.value
			},
			cargoTypePickerChange: function(e) {
				this.typeIndex = e.detail.value
			},
			cargoPropertyPickerChange: function(e) {
				this.propertyIndex = e.detail.value
			},
			allUldNoPickerChange: function(e) {
				this.uldNoIndex = e.detail.value
			},
			confirmBtn() {
				this.request({
					url: '/terminal/innerLighter/updateOrderData',
					method: 'POST',
					data: {
						status: 3,
						id: this.headedId,
						// 多板箱号
						uldNo: this.uldNo,
						// 散货车数量
						cargoNum: parseInt(this.cargoNum),
						// 架子车数量
						shelfNum: parseInt(this.shelfNum),
						remark: this.remark,
						userId: this.id,
						applyUser: this.username,
						isIntact: this.isIntact.toString()
					},
					success: res => {
						console.log('已出发：', res);
						if (res && res.data && res.data.status == 200) {
							uni.showToast({
							    title: '已添加成功！',
							    duration: 2000
							});
							//更新成功跳转页面
							uni.reLaunch({
								url: '../tabBar/lighteringRecord/lighteringRecord'
							});
						}else {
							uni.showToast({
							    title: '添加提交失败！',
							    duration: 2000
							});
						}
						
					}
				})
			}
			
		}
	}
</script>

<style>
	.content {
		display: flex;
		flex-direction: column;
		padding: 30rpx;
		color: #333;
		font-size: 40rpx;
	}
	uni-page-head {
		background-color: #FFCC80;
	}
	.section-mg-tb {
		margin: 10rpx 0;
	}
	.checkbox-list {
	}
	.checkbox-label {
		display: flex;
		align-items: center;
		justify-content: center;
		
	}
	.checkbox-label view {
		width: 200rpx;
	}
	
	uni-checkbox {
		margin-left: 20rpx;
	}
	.section-flex {
		display: flex;
	}
	.section-flex text{
		width: 300rpx;
		display: inline-block;
	}
	.section-flex input {
		width: 200rpx;
		border: 1rpx solid #999;
		display: inline-block;
	}
	.section-flex .select-input {
		width: 200rpx;
		border: 1rpx solid #999;
		display: inline-block;
	}
	.section-flex .first-radio {
		margin-right: 20rpx;
	}
	.section-flex .radio-value text{
		width: 80rpx;
	}
	.section-textarea {
		height: 160rpx;
		padding: 10rpx;
		border: 1rpx solid #999;
	}
	.section-flex button {
		width: 120rpx;
		height: 60rpx;
		line-height: 60rpx;
		font-size: 40rpx;
		color: #333;
	}
	.confirm {
		width: 200rpx;
		height: 60rpx;
		line-height: 60rpx;
		font-size: 40rpx;
		margin: 20rpx auto 0;
		color: #333;
	}
</style>
