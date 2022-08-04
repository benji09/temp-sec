<template>
	<view class="content">
		<view>
			<text>编号：{{remarkId}}</text>
		</view>
		<!-- <view class="section-mg-tb">
			<image style="width: 100px; height: 100px; background-color: #eeeeee;" :src="src" @tap="bindChange" mode="scaleToFill" />
		</view> -->
		
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
		
		<view class="section-mg-tb">
			<view class="section-mg-tb">内容：</view>
			<view class="section-textarea">
				<textarea  v-model="remark" auto-height />
			</view>
		</view>
		<button @tap="add">添加</button>
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
		name: 'remark',
		data() {
			return {
				remarkId: '',
				src: 'https://bjetxgzv.cdn.bspapp.com/VKCEYUGU-uni-app-doc/6acec660-4f31-11eb-a16f-5b3e54966275.jpg',
				imagesArray: [],
				remark: '',			
				// test
				title: 'choose/previewImage',
				imageList: [],
				sourceTypeIndex: 2,
				sourceType: ['拍照', '相册', '拍照或相册'],
				sizeTypeIndex: 2,
				sizeType: ['压缩', '原图', '压缩或原图'],
				countIndex: 4,
				count: [1, 2, 3, 4, 5]
			} 
		},
		computed: mapState(['hasLogin', 'token', 'dept_id', 'id', 'username']),
		onLoad(option) {
			if(!this.hasLogin) {
				uni.reLaunch({
					url: '../../loginFlow/login/login'
				});
			}else {
				this.remarkId = option.id
				uni.hideLoading();
			}
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
						console.log('上传接口：', res);
						const imgSrc = res.tempFilePaths[0];
						const name = res.tempFiles[0].name;
						
						console.log(this.imagesArray);
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
			add() {
				this.request({
					url: '/terminal/innerLighter/updateRemark',
					method: 'POST',
					data: {
						type: 1,
						id: this.remarkId,
						images: this.imagesArray.join(','),
						remark: this.remark,
						userId: this.id,
						applyUser: this.username
					},
					success: res => {
						console.log('备注页添加：', res);
						if (res && res.data && res.data.status == 200) {
							if (res && res.statusCode == 200) {
								uni.showToast({
									title: '已添加成功！',
									duration: 2000
								});
							}
						}else {
							console.log('备注页添加失败');
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
		font-size: 30rpx;
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
		height: 300rpx;
		border: 1rpx solid #999;
	}
	button {
		width: 200rpx;
		height: 60rpx;
		line-height: 60rpx;
		font-size: 30rpx;
		margin: 120rpx auto 0;
		color: #333;
	}
	.test {
		width: 100rpx;
		height: 100rpx;
		border: 1rpx solid #000;
	}
	textarea {
		padding: 20rpx;
	}
	
	.cell-pd {
		padding: 22rpx 30rpx;
	}
	
	.list-pd {
		margin-top: 50rpx;
	}

</style>
