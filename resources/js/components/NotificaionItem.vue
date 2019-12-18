<template>
	<div>
		<!--<a :href="'/read-notification/'+ unread.id">{{ unread['data']['follower_name'] }}  {{ unread['data']['msg'] }}</a>-->
        <li role="presentation">
		  <a :href="url" class="dropdown-menu-header">{{ unread['data']['follower_name'] }}  {{ unread['data']['msg'] }}</a>
	    </li>
	</div>
</template>


<script>
	export default{
		name:'NotificationItem',
		props:['unread'],

		data(){
			return{
				url:"",
			}
		},

		mounted(){
			this.url = "/user/notification-mark-as-read/" + this.unread.id
		}

	}
</script>

<style scoped>
.dropdown-menu-header{
	font-size:13px;
}
</style>