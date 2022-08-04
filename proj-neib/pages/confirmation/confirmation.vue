<template>
	<view class="content">
		<view>
			<text>编号：{{confirmId}}</text>
		</view>
		<view class="section-flex section-mg-tb">
			<text>确认货物类型：</text>
			<picker @change="cargoTypePickerChange" :value="cargoTypeArray[typeIndex].code" :range="cargoTypeArray" range-key="name">
				<view class="select-input">{{cargoTypeArray[typeIndex].name}}</view>
			</picker>
		</view>
		<view class="section-flex section-mg-tb">
			<text>确认货物性质：</text>
			<picker @change="cargoPropertyPickerChange" :value="cargoPropertyArray[propertyIndex].code" :range="cargoPropertyArray" range-key="name">
				<view class="select-input">{{cargoPropertyArray[propertyIndex].name}}</view>
			</picker>
		</view>
		<view class="section-flex section-mg-tb">
			<text>板箱号/散货车号：</text>
			<view class="uldNo-wrap">
				<button @tap="add">添加</button>
				<view v-for="(item, index) in uldNoData" :key="index">
					<input v-model="uldNoData[index].uldNo" />
					<button @tap="del(index)">移除</button>
				</view>
				
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
		<view class="section-mg-tb">
		<!-- 上传图片 begin -->
		<view class="uni-common-mt">
			<form>
				<view class="uni-list list-pd">
					<view class="uni-list-cell">
						<view class="uni-uploader">
							<view class="uni-uploader-head">
								<view class="uni-uploader-title">点击可预览选好的图片</view>
								<view class="uni-uploader-info">{{imageList.length}}/5</view>
							</view>
							<view class="uni-uploader-body">
								<view class="uni-uploader__files">
									<block v-for="(image,index) in imageList" :key="index">
										<view class="uni-uploader__file">
											<image class="uni-uploader__img" :src="image" :data-src="image" @tap="previewImage"></image>
										</view>
									</block>
									<view class="uni-uploader__input-box">
										<view class="uni-uploader__input" @tap="bindChange()"></view>
									</view>
								</view>
							</view>
						</view>
					</view>
				</view>
			</form>
		</view>
		<!-- 上传图片over -->
		</view>
		<view class="section-mg-tb">
			<view class="section-mg-tb">备注：</view>
			<view class="section-textarea">
				<textarea @blur="textAreaBlur" auto-height />
			</view>
		</view>
		<button class="confirm" @tap="confirmBtn">确认</button>
	</view>
</template>

<script>
	import {mapState} from 'vuex';
	import permision from "@/common/permission.js"
	var sourceType = [
		['camera'],
		['album'],
		['camera', 'album']
	]
	var sizeType = [
		['compressed'],
		['original'],
		['compressed', 'original']
	]
	export default {
		name: 'confirmation',
		data() {
			return {
				confirmId: '',
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
				cargoType: '',
				cargoProperty: '',
				typeIndex: 0,
				typeCode: 'C',
				propertyCode: '冷',
				propertyIndex: 0,
				uldNoIndex: 0,
				remark: '',
				uldNoData: [{uldNo: ''}],
				//image相关
				imageList: [],
				src: 'https://bjetxgzv.cdn.bspapp.com/VKCEYUGU-uni-app-doc/6acec660-4f31-11eb-a16f-5b3e54966275.jpg',
				imagesArray: [],
				title: 'choose/previewImage',
				imageList: [],
				sourceTypeIndex: 2,
				sourceType: ['拍照', '相册', '拍照或相册'],
				sizeTypeIndex: 2,
				sizeType: ['压缩', '原图', '压缩或原图'],
				countIndex: 4,
				count: [1, 2, 3, 4, 5],
				isIntact: 1
			} 
		},
		computed: mapState(['hasLogin', 'id', 'username']),
		onLoad(option) {
			this.confirmId = option.id
		},
		onUnload() {
			this.imageList = [],
			this.sourceTypeIndex = 2,
			this.sourceType = ['拍照', '相册', '拍照或相册'],
			this.sizeTypeIndex = 2,
			this.sizeType = ['压缩', '原图', '压缩或原图'],
			this.countIndex = 8;
		},
		methods: {
			bindChange: async function () {
				// #ifdef APP-PLUS
				// TODO 选择相机或相册时 需要弹出actionsheet，目前无法获得是相机还是相册，在失败回调中处理
				if (this.sourceTypeIndex !== 2) {
					let status = await this.checkPermission();
					if (status !== 1) {
						return;
					}
				}
				// #endif
				
				if (this.imageList.length === 5) {
					let isContinue = await this.isFullImg();
					console.log("是否继续?", isContinue);
					if (!isContinue) {
						return;
					}
				}
				uni.chooseImage({
					count: 1,
					sizeType: ['compressed'],
					sourceType: ['album'],
					success: (res) => {
						// const imagesArray = this.imagesArray;
						console.log('上传接口：', res);
						const imgSrc = res.tempFilePaths[0];
						const name = res.tempFiles[0].name;
						const type = res.tempFiles[0].type;
						//test 
						this.imageList = this.imageList.concat(res.tempFilePaths);
						uni.showLoading({
							title: '上传中',
							mask: true
						});
						// 将图片上传到服务器
						this.uploadFile({
							url: "/pactl/uploadfile",
							filePath: imgSrc,
							// file: imgSrc,
							name: 'file',
							type: type,
							success: (res) => {
								uni.hideLoading();
								const obj = JSON.parse(res.data);
								if (obj && obj.status == 200) {
									this.imagesArray.push(obj.data.remoteFilename);
								}
							},
							fail: (err) => {
								uni.showModal({
									content:err.errMsg,
									showCancel:false
								});
							},
							complete: () => {
							}
						});
					},
					fail: (err) => {
						console.log('选择图片失败', err);
					}
				});
			},
			cargoTypePickerChange: function(e) {
				console.log(e.detail);
				// this.typeIndex = e.detail.value
				const index = e.detail.value;
				this.typeCode = this.cargoTypeArray[index].code;
			},
			cargoPropertyPickerChange: function(e) {
				// this.propertyIndex = e.detail.value
				const index = e.detail.value;
				this.propertyCode = this.cargoPropertyArray[index].code;
			},
			allUldNoPickerChange: function(e) {
				this.uldNoIndex = e.detail.value
			},
			radioChange: function(e) {
				var checked = e.target.value
				console.log('checked', checked);
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
			textAreaBlur: function (e) {
				this.remark = e.detail.value;
			},
			confirmBtn() {
				const arr = this.uldNoData.map((item) => {return item.uldNo});
				const uldNo = arr.join(',');
				this.request({
					url: '/terminal/innerLighter/updateData',
					method: 'POST',
					data: {
						status: 3,
						id: this.confirmId,
						cargoType: this.typeCode,
						cargoProperty: this.propertyCode,
						isIntact: this.isIntact.toString(),
						uldNo: uldNo,
						images: this.imagesArray.join(','),
						remark: this.remark,
						userId: this.id,
						applyUser: this.username
					},
					success: res => {
						console.log('确认： ', res);
						if (res && res.data && res.data.status == 200) {
							uni.showToast({
							    title: '已确认成功！',
							    duration: 2000
							});
							//更新成功跳转页面
							uni.reLaunch({
								url: '../tabBar/pendingApplication/pendingApplication'
							});
						}else {
							uni.showToast({
							    title: '确认提交失败！',
							    duration: 2000
							});
						}
						
					}
				})
			},
			
			sourceTypeChange: function(e) {
				this.sourceTypeIndex = parseInt(e.detail.value)
			},
			sizeTypeChange: function(e) {
				this.sizeTypeIndex = parseInt(e.detail.value)
			},
			countChange: function(e) {
				this.countIndex = e.detail.value;
			},
			isFullImg: function() {
				return new Promise((res) => {
					uni.showModal({
						content: "已经有5张图片了,是否清空现有图片？",
						success: (e) => {
							if (e.confirm) {
								this.imageList = [];
								res(true);
							} else {
								res(false)
							}
						},
						fail: () => {
							res(false)
						}
					})
				})
			},
			previewImage: function(e) {
				var current = e.target.dataset.src
				uni.previewImage({
					current: current,
					urls: this.imageList
				})
			},
			async checkPermission(code) {
				let type = code ? code - 1 : this.sourceTypeIndex;
				let status = permision.isIOS ? await permision.requestIOS(sourceType[type][0]) :
					await permision.requestAndroid(type === 0 ? 'android.permission.CAMERA' :
						'android.permission.READ_EXTERNAL_STORAGE');
			
				if (status === null || status === 1) {
					status = 1;
				} else {
					uni.showModal({
						content: "没有开启权限",
						confirmText: "设置",
						success: function(res) {
							if (res.confirm) {
								permision.gotoAppSetting();
							}
						}
					})
				}
			
				return status;
			},
			add() {
				this.uldNoData.push({uldNo: ''})
			},
			del(index){
				this.uldNoData.splice(index, 1);
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
	.section-flex .select-input {
		width: 200rpx;
		border: 1rpx solid #999;
		display: inline-block;
	}
	
	uni-label {
		/* background-color: pink; */
		display: inline-block;
		width: 90px;
	}
	.section-textarea {
		height: 160rpx;
		border: 1rpx solid #999;
		padding: 10rpx;
	}
	.section-flex button {
		width: 120rpx;
		height: 50rpx;
		line-height: 50rpx;
		font-size: 40rpx;
		color: #333;
		display: inline-block;
		margin-left: 10rpx;
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
