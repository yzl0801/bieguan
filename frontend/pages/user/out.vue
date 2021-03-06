<template>
	<view class="content">
		<view class="u-margin-left-30 u-margin-right-30">
			
			<u-navbar title="消费" :is-back="true"></u-navbar>
			
			<u-form  label-width="120" ref="form" >
				<u-form-item label="金额" prop="money" label-position="left" :border-bottom="true" :required="true" >
					<u-input v-model="form_data.money"></u-input>
				</u-form-item>
				<u-form-item label="类别" :border-bottom="true" :required="true">
					<u-radio-group v-model="form_data.type" size="30rpx">
						<u-radio name="51">消费</u-radio>
						<u-radio name="52">古物文玩</u-radio>
					</u-radio-group>
				</u-form-item>
				<u-button class="u-margin-top-10" type="primary" size="default" shape="circle" @click="submit" :throttleTime="1000">确认</u-button>
			</u-form>
		
		</view>		
	</view>

</template>

<script>
	export default {
		data() {
			return {
				form_data: {
					member_id: 0,
					money: 0,
					type: 51					
				},

			};
		},
		computed: {

		},
		methods:{
			submit() {
				this.$u.api.balance_change(this.form_data).then(response => {
					this.$u.toast("操作成功");
					setTimeout(() => {
						uni.navigateBack()
					}, 1500)
				})
			},
		},
		created() {
		},
		onLoad(option) {
			this.form_data.member_id = option.id
		}
	}
</script>

<style lang="scss" scoped>

</style>
