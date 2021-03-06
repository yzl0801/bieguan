<template>
	<view class="content">
		
		<u-tabbar :list="list" active-color="#409eff"></u-tabbar>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				list: [{
							iconPath: "home",
							selectedIconPath: "home-fill",
							text: '首页',
							isDot: false,
							customIcon: false,
							pagePath: "/pages/index/index"
						},
						{
							iconPath: "account",
							selectedIconPath: "account-fill",
							text: '会员',
							isDot: false,
							customIcon: false,
							pagePath: "/pages/user/list"
						},
						{
							iconPath: "setting",
							selectedIconPath: "setting-fill",
							text: '设置',
							customIcon: false,
							pagePath: "/pages/setting/index"
						}
					],
			}
		},
		onLoad() {

		},
		methods: {

		}
	}
</script>

<style lang="scss" scoped>
	.content {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		padding: 40rpx;
	}

	.logo {
		height: 200rpx;
		width: 200rpx;
		margin-top: 100rpx;
		margin-left: auto;
		margin-right: auto;
		margin-bottom: 50rpx;
	}

	.text-area {
		display: flex;
		justify-content: center;
	}
	
	.title {
		font-size: 28rpx;
		color: $u-content-color;
	}
	
	.button-demo {
		margin-top: 80rpx;
	}
	
	.link-demo {
		margin-top: 80rpx;
	}
</style>
