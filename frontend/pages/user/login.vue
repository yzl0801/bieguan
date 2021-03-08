<template>
	<view class="login-box">
		<view class="padding">
			<view class="u-text-left title">
				登录
			</view>
			<u-form ref="form" :model="form_data" class="u-margin-20">
				<u-form-item>
					<u-input v-model="form_data.account" placeholder="请输入手机号"></u-input>
				</u-form-item>
				<u-form-item>
					<u-input type="password" v-model="form_data.password" placeholder="请输入密码"></u-input>
				</u-form-item>
			</u-form>
			
			<u-button type="primary" @click="submit" class="u-margin-top-40">登录</u-button>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				form_data: {
					account: "",
					password: ""
				},
			};
		},
		methods:{
			async submit(){
				this.$u.api.login(this.form_data).then((response) => {
					this.$u.vuex('vuex_token', response.data.token);
					this.$u.vuex('vuex_expire_time', response.data.expire_time);
					this.$u.toast(response.msg)
					setTimeout(() => {
						this.$u.route({
							type: 'tab',
							url: "/pages/user/list"
						})						
					}, 1500)
				})
			}
		}
		
	}
</script>

<style lang="scss" scoped>
	page{
		background: #FFFFFF;
	}
	.login-box{
		margin: 0 20rpx;
		.title {
			padding-top: 100rpx;
			font-size: 30px;
		}
	}

</style>
