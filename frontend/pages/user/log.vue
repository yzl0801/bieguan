<template>
	<view>
		<view class="container">
			<view class="log-list">
				<u-navbar title="明细" :is-back="true"></u-navbar>
				<view class="log-item u-flex" v-for="(item, index) in log_list" :key="index">
					<view class="u-flex-3">
						<view class="u-main-color u-padding-10">说明：{{item.description}}</view>
						<view class="u-content-color u-padding-10">类型：{{item.type}}</view>
						<view class="u-content-color u-padding-10">余额：{{item.value_after}}</view>
						<view class="u-tips-color u-padding-10">时间：{{item.create_time}}</view>						
					</view>
					<view class="value u-flex-1 u-text-right u-margin-right-10" :class="[ item.value > 0 ? 'greater' : 'less']">
						{{item.value}}
					</view>
				</view>
			</view>			
		</view>
		
	</view>
</template>

<script>
	export default {
		data () {
			return {
				id: 0,
				log_list: [],	
			}
		},
		methods: {
			
		},
		computed: {

		},

		onShow() {
			this.$u.api.balance_log({
				id: this.id
			}).then(response => {
				this.log_list = response.data
			})
		},
		onLoad(option) {
			this.id =option.id
		}
	}
</script>

<style lang="scss" scoped>
	.container {}
	.log-list {
		padding: 1rpx 0 20rpx;
		background-color: #f7f7f7;
		height: 100vh;
		.log-item {
			background-color: #fff;
			margin: 20rpx;
			padding: 10rpx;
			border-radius: 20rpx;
			.red {
				color: $u-type-error;
			}
			.value {
				font-size: 40rpx;
				font-weight: 600;
				&.greater {
					color: $u-type-primary;
				}
				&.less {
					color: $u-type-error;
				}
			}
			&:first-child {
				
			}
		}
	}
</style>
