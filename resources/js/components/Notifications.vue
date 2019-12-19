<template>
	<div class="notifications">
	<li class="nav-item dropdown" style="margin-right:20px">
 
    <a  href="#"  onclick="return false;" role="button" data-toggle="dropdown" id="dropdownMenu1" data-target="#" style="float: left" aria-expanded="true" class="nav-link">
        Notifications
    
    <span v-if="unreadNotifications.length == 0" class="badge"></span>
    <span v-else class="badge badge-danger">{{unreadNotifications.length}}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-left pull-right" role="menu" aria-labelledby="dropdownMenu1">
        <li role="presentation">
            <a>Notifications</a>
        </li>

        <NotificaionItem v-for="unread in unreadNotifications" :unread="unread" :key="unread.id" />  

        <li role="presentation">
            <a :href="url_all_notifications" class="dropdown-menu-header" v-if="allnotifications.length > 0">All Notifications</a>
            <a class="dropdown-menu-header" v-else="">No Notifications</a>
        </li>
    </ul>
</li>
	</div>
</template>


<script>

import NotificaionItem from './NotificaionItem'
	export default{

		name:'Notification',
		props:['userid', 'unreads','allnotifications'],

		data(){
          return{
           url_all_notifications:"",
           unreadNotifications: this.unreads,
          }
        },

		mounted(){

		this.url_all_notifications = "/users/all-notifications/" + this.userid
        
        // Читање на податоците од Pusher прекy дефиниран Event

		/*Echo.channel('notification-tracker')
          .listen('NotificationEvent', (notification) => {
                //console.log(notification);
        console.log(JSON.stringify(notification));
        let newUnreadNotifications = {id: notification.follower.id, data:{ name: notification.follower.name, msg: notification.msg}};
        this.unreadNotifications.push(newUnreadNotifications);
        });*/

        
        //читање на податоци од Pusher
		Echo.private('App.User.' + this.userid)
        .notification((notification) => {
        //console.log(JSON.stringify(notification))
        this.unreadNotifications.unshift({
                   	'id': notification.id,
                   	data:{
                   	'follower_id': notification.follower_id,
                   	'follower_name': notification.follower_name,
                   	'msg': notification.msg
                    }
                   	});

        });


        },


	}
</script>


<style scoped>
.dropdown-menu{
	padding:10px;
	min-width:250px;
}

.notifications{
  min-width:140px;
}

</style>