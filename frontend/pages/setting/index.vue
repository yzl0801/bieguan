<template>
	<view class="content">
		<view class="u-margin-left-30 u-margin-right-30">
			<u-navbar title="系统设置" :is-back="false"></u-navbar>

			<u-form :model="form_data" label-width="200" ref="form"  :border-bottom="false">
				<u-form-item label="赠送比例：" prop="ratio" label-position="left" :border-bottom="true" >
					<u-input v-model="form_data.ratio" type="number" placehoder="数值在0~100" ></u-input>
					<slot name="right">%</slot>
				</u-form-item>
				<u-button class="u-margin-top-10"  type="primary" size="default" shape="circle" @click="submit">保存</u-button>
			</u-form>
		</view>
		<u-tabbar :list="list" active-color="#409eff"></u-tabbar>

	</view>
</template>

<script>
	export default {
		data() {
			return {
				form_data: {
					"ratio": 0,
				},
				
				rules: {
					ratio: [
							{
								required: true,
								message: '赠送比例不能为空',
								// 可以单个或者同时写两个触发验证方式
								trigger: ['blur', 'change']
							},
							{
								min: 0,
								message: '最小值0',
								// 可以单个或者同时写两个触发验证方式
								trigger: ['blur', 'change']
							},
							{
								max: 100,
								message: '最大值100',
								// 可以单个或者同时写两个触发验证方式
								trigger: ['blur', 'change']
							}
					],
				},
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
		methods: {
			submit() {
				this.$u.api.update_config(this.form_data).then(response => {
					this.$u.toast("保存成功~");
				})
			}
		},
		onLoad() {
			this.$u.api.get_config().then(response => {
				this.form_data = response.data
			})
		},
		onReady() {
			this.$refs.form.setRules(this.rules)
		}
	}
</script>

<style lang="scss" scoped>
	
</style>
