// 如果没有通过拦截器配置域名的话，可以在这里写上完整的URL(加上域名部分)


// 此处第二个参数vm，就是我们在页面使用的this，你可以通过vm获取vuex等操作，更多内容详见uView对拦截器的介绍部分：
// https://uviewui.com/js/http.html#%E4%BD%95%E8%B0%93%E8%AF%B7%E6%B1%82%E6%8B%A6%E6%88%AA%EF%BC%9F
const install = (Vue, vm) => {
	// 此处没有使用传入的params参数
	// let get_config = (params = {}) => vm.$u.get('/config/get', params);
	vm.$u.api = {}
	
	vm.$u.api.login = (params = {}) => vm.$u.post('/login', params);
	
	vm.$u.api.get_config = (params = {}) => vm.$u.get('/config/get', params);
	// 此处使用了传入的params参数，一切自定义即可
	vm.$u.api.update_config = (params = {}) => vm.$u.post('/config/save', params);
	
	vm.$u.api.user_list = (params = {}) => vm.$u.get('/member/list', params);
	
	vm.$u.api.create_user = (params = {}) => vm.$u.post('/member/create', params);
	
	vm.$u.api.update_user = (params = {}) => vm.$u.post('/member/update', params);
	
	vm.$u.api.delete_user = (params = {}) => vm.$u.post('/member/delete', params);
	
	vm.$u.api.user_profile = (params = {}) => vm.$u.get('/member/profile', params);
	
	vm.$u.api.balance_change = (params = {}) => vm.$u.post('/member/account-change', params);
	
	vm.$u.api.balance_log = (params = {}) => vm.$u.get('/member/balance-log-list', params);
	
	
	// 将各个定义的接口名称，统一放进对象挂载到vm.$u.api(因为vm就是this，也即this.$u.api)下
	// vm.$u.api = {get_config, update_config, user_list, , , };
}

export default {
	install
}