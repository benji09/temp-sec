<template>
	<view class="content">
		<view>
			<text>编号：12345678</text>
		</view>
		<view class="section-mg-tb">
			<view class="section-mg-tb">选择集装器：</view>
			<view class="checkbox-list">
				<checkbox-group @change="checkboxChange">
					<label class="checkbox-label section-mg-tb" v-for="item in items" :key="item.value">
						<view>{{item.name}}</view>
						<view>
							<checkbox :value="item.value" :checked="item.checked" />
						</view>
					</label>
				</checkbox-group>
			</view>
		</view>
		<view class="section-flex section-mg-tb">
			<text>确认外观是否完整：</text> 
			<label class="radio first-radio"><radio value="r1" checked="true" />是</label>
			<label class="radio"><radio value="r2" />否</label>
		</view>
		<view class="section-flex section-mg-tb">
			<text>使用架子车数量：</text>
			<input focus />
		</view>
		<view class="section-flex section-mg-tb">
			<text>使用散货车数量：</text>
			<input />
		</view>
		<view class="section-mg-tb">
			<uni-file-picker limit="9" title="最多选择9张图片" :value="fileLists"></uni-file-picker>
		</view>
		<view class="section-mg-tb">
			<view class="section-mg-tb">内容：</view>
			<view class="section-textarea">
				<textarea @blur="bindTextAreaBlur" auto-height />
			</view>
		</view>
		<button>确认出发</button>
	</view>
</template>

<script>
	export default {
		name: 'lightering',
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
					debugger;
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
	.section-flex .first-radio {
		margin-right: 20px;
	}
	.section-textarea {
		height: 160rpx;
		border: 1rpx solid #999;
	}
	button {
		width: 200rpx;
		height: 60rpx;
		line-height: 60rpx;
		font-size: 40rpx;
		margin: 20rpx auto 0;
		color: #333;
	}

</style>
