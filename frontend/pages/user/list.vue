<template>
	<view>
		<view class="container">
			<view class="u-padding-20">
				<u-search placeholder="输入会员姓名|手机号" v-model="keyword" :animation="true"  @change="s"></u-search>
			</view>
			<view class="user-list">
				<u-swipe-action v-for="(item, index) in user_list2" :index="index" :key="item.id" :show="item.show" 
				@click="click" @open="open" :options="options" btn-width="120">
					<view class="user-item" >
						<view class="profile u-flex">
							<view class="u-margin-left-10 u-margin-right-10">
								<u-image width="100rpx" height="100rpx" :src='item.sex|avatar' shape="circle"></u-image>
							</view>
							<view  class="u-margin-left-40 ">
								<view class="u-margin-top-20">
									<u-icon name="account" class="u-margin-right-16"></u-icon><text class="u-font-32 u-main-color">{{item.realname}}</text>
								</view>
								<view class="u-margin-top-20">
									<u-icon name="phone" class="u-margin-right-16"></u-icon><text class="u-font-32 u-content-color">{{item.mobile}}</text>								
								</view>
								<view class="u-margin-top-20 " >
									<u-icon name="rmb" class="u-margin-right-16"></u-icon><text class="u-font-32 ">{{item.balance}}</text>	
								</view>			
							</view>
						</view>
						<!-- <u-line></u-line> -->
						<view class="btn-group u-text-right">
							<u-button type="primary" class="u-margin-10" size="mini" plain="" @click="edit(item)">编辑</u-button>
							<u-button type="error" class="u-margin-10" size="mini"  plain="" @click="ins(item)">充值</u-button>
							<u-button type="error" class="u-margin-10" size="mini"  plain="" @click="out(item)">消费</u-button>
							<u-button type="warning" class="u-margin-10" size="mini"  plain="" @click="log(item)">明细</u-button>
							<!-- <u-button type="error" class="u-margin-10" size="mini"  plain="" @click="del(item.id)">删除</u-button> -->
						</view>
					</view>					
				</u-swipe-action>
			</view>
			<uni-fab horizontal="left" vertical="bottom" :popMenu="false" @fabClick="add" :pattern="{buttonColor:'#2979ff'}"></uni-fab>
			
		</view>
		<u-tabbar :list="list" active-color="#409eff"></u-tabbar>
		
	</view>
</template>

<script>
	import Vue from 'vue'
	export default {
		data () {
			return {
				keyword: "",
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
				user_list: [],
				options: [
					{
						text: '删除',
						style: {
							backgroundColor: '#dd524d'
						}
					}
				]
			}
		},
		methods: {
			s(event)  {
				this.$u.debounce(()=>{
					this.keyword = event
				})
			},
			add() {
				uni.navigateTo({
					url: '/pages/user/add'
				})
			},
			edit(item) {
				uni.navigateTo({
					url: '/pages/user/update?id=' + item.id
				})
			},
			ins(item) {
				uni.navigateTo({
					url: '/pages/user/in?id=' + item.id
				})				
			},
			out(item) {
				uni.navigateTo({
					url: '/pages/user/out?id=' + item.id
				})				
			},
			log(item) {
				uni.navigateTo({
					url: '/pages/user/log?id=' + item.id
				})
			},
			del(id) {
				uni.showModal({
					title: "确定删除该会员？",
					success: () => {
						this.$u.api.delete_user({id}).then(() => {
							this.$u.toast(`删除成功`);
							this.getList()
						})						
					}
				})
			},
			click(index, index1) {
				console.log(index);
				if(index1 == 0) {
					this.del(this.user_list[index].id)
				}
			},
			// 如果打开一个的时候，不需要关闭其他，则无需实现本方法
			open(index) {
				// 先将正在被操作的swipeAction标记为打开状态，否则由于props的特性限制，
				// 原本为'false'，再次设置为'false'会无效
				this.user_list[index].show = true;
				this.user_list.map((val, idx) => {
					if(index != idx) this.user_list[idx].show = false;
				})
			},
			getList() {
				this.$u.api.user_list().then(response => {
					this.user_list = response.data
					this.user_list.forEach((item, key) => {
						Vue.set(this.user_list[key], 'show', false)
					})
				})				
			}
		},
		computed: {
			user_list2() {
				return this.user_list.filter((item, key) => {
					return (!this.keyword || 
					(this.keyword && -1 !== item.realname.indexOf(this.keyword)) || 
					(this.keyword && -1 !== item.mobile.indexOf(this.keyword))
					)
				})
			}
		},
		filters: {
			avatar: function(value) {
				if (value == 1) {
					return '/static/man.png'
				} else {
					return '/static/woman.png'					
				}
			}
		},
		onShow() {
			this.getList()
		},
	}
</script>

<style lang="scss" scoped>
	.container {}
	.user-list {
		padding: 1rpx 0 30rpx;
		background-color: #f7f7f7;
		// height: 90vh;
		.user-item {
			background-color: #fff;
			margin: 20rpx;
			padding: 10rpx;
			border-radius: 20rpx;
			.red {
				color: $u-type-error;
			}
			&:first-child {
				
			}
		}
	}
</style>
