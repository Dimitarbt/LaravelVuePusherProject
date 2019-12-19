<template>
	<div class="info-user">
		<ul>
            <li v-if="!user.profile_photo"><a :href="profile_url"><img :src="'/img/avatar.png'" alt="Me" class="profile-photo"></a></li>
            <li v-else ><a :href="profile_url"><img :src="'/storage/'+ user.profile_photo" alt="Me" class="profile-photo"></a></li>
        </ul>
	</div>
</template>


<script>
	export default{
		name:'InfoUserComponent',
		props:['user'],

		data(){
			return{
				profile_url:'',
			}
		},

		mounted(){
			this.profile_url = '/user/'+ this.user.id;
			console.log('component mounted.');
		}
	}
</script>


<style scoped>
.info-user{
	width:100%;
}
ul{
	padding:0;
}

li{
	list-style:none;
}
a{
	color:#545b62;
	font-size:18px;
}
.profile-photo{
	width:45px;
	height:45px;
	border-radius:50%;
	border:1px solid #a96262;

}
</style>