<template>
	<view class="content">
		<view class="u-margin-left-30 u-margin-right-30">
			
			<u-navbar title="充值" :is-back="true"></u-navbar>
			
			<u-form  label-width="120" ref="form" >
				<u-form-item label="金额" prop="money" label-position="left" :border-bottom="true" :required="true" >
					<u-input v-model="money"></u-input>
				</u-form-item>
				<u-form-item label="赠送" label-position="left" :border-bottom="true"  >
					<u-input :value="extra" :disabled="true"></u-input>
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
				member_id: 0,
				config: {
					ratio: 0
				},
				money: 0,
				sex_option:[
					{text: "男", value: 1},
					{text: "女", value: 2}
				]
			};
		},
		computed: {
			extra() {
				return (this.config.ratio * this.money/100).toFixed(2)
			}
		},
		methods:{
			submit() {
				this.$u.api.balance_change({
					member_id: this.member_id,
					money: this.money,
					type: 1
				}).then(response => {
					this.$u.toast("操作成功");
					setTimeout(() => {
						uni.navigateBack()
					}, 1500)
				})
			},
		},
		created() {
			this.$u.api.get_config().then(response => {
				this.config = response.data
			})
		},
		onLoad(option) {
			this.member_id = option.id
		}
	}
</script>

<style lang="scss" scoped>

</style>
