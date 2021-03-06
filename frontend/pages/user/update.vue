<template>
	<view class="content">
		<view class="u-margin-left-30 u-margin-right-30">
			
			<u-navbar title="编辑会员" :is-back="true"></u-navbar>
			
			<u-form :model="form_data" label-width="120" ref="form" >
				<u-form-item label="姓名" prop="realname" label-position="left" :border-bottom="true" :required="true" >
					<u-input v-model="form_data.realname"></u-input>
				</u-form-item>
				<u-form-item label="手机号" prop="mobile" label-position="left" :border-bottom="true" :required="true" >
					<u-input v-model="form_data.mobile"></u-input>
				</u-form-item>
				<u-form-item label="性别" prop="sex" label-position="left" :border-bottom="true" >
					<u-radio-group v-model="form_data.sex" size="30rpx">
						<u-radio name="1">男</u-radio>
						<u-radio name="2">女</u-radio>
					</u-radio-group>
				</u-form-item>
				<u-form-item label="余额" prop="balance" label-position="left" :border-bottom="true" :required="true" >
					<u-input v-model="form_data.balance" :disabled="true"></u-input>
				</u-form-item>
				<u-form-item label="备注" prop="remark" label-position="left" :border-bottom="true" :required="true" >
					<u-input v-model="form_data.remark" type="textarea"></u-input>
				</u-form-item>
				<u-button class="u-margin-top-10" type="primary" size="default" shape="circle" @click="submit">保存</u-button>
			</u-form>
		
		</view>		
	</view>

</template>

<script>
	export default {
		data() {
			return {
				form_data: {
					realname: "",
					mobile: "",
					sex: 1,
					balance: 0,
					remark: ""
				},
				sex_option:[
					{text: "男", value: 1},
					{text: "女", value: 2}
				]
			};
		},
		methods:{
			submit() {
				this.$u.api.update_user(this.form_data).then(response => {
					this.$u.toast("操作成功");
					setTimeout(() => {
						uni.navigateBack()
					}, 1500)
				})
			},
		},
		created () {
			this.$u.api.user_profile({id: this.form_data.id}).then(response => {
				this.form_data = response.data
			})
		},
		onLoad(option) {
			this.form_data.id = option.id
		}
	}
</script>

<style lang="scss" scoped>

</style>
