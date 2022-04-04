<template>
	<div class="content-header pt-5 mt-3">
		<div class="container">
            <div class="h1">
                Registrasi Akun Baru
            </div>
			<form @submit.prevent="regis">
				<Forms v-model="data.email" v-bind:type="'email'" v-bind:labels="'Email'" v-bind:setid="'email'" v-bind:setattribute="''"/>
				<Forms v-model="data.name" v-bind:type="'text'" v-bind:labels="'Nama'" v-bind:setid="'name'" v-bind:setattribute="''"/>
				<Forms v-model="data.password" v-bind:type="'password'" v-bind:labels="'Password'" v-bind:setid="'password'" v-bind:setattribute="''"/>
				<Forms v-model="data.repeat_password" v-bind:type="'password'" v-bind:labels="'Repeat Password'" v-bind:setid="'repeat_password'" v-bind:setattribute="''"/>
				<div class="mt-4 d-flex justify-content-between">
					<div>
						<router-link :to='{name:"Main",}' class="btn btn-danger float-left" >Kembali</router-link>
					</div>
					<div>
						<button type="submit" class="btn btn-primary float-right" value="save">Daftar</button>
					</div>
				</div>
			</form>
        </div>
	</div>
</template>

<script>
import Forms from '../../elements/form.vue';

export default{
	data(){
		return {
			data:{
				success:false,
				message:'',
				token:'',
				id:'',
				email:'',
				name:'',
				password:'',
				repeat_password:'',
			},
		}
	},
	mounted(){
		this.checklogin()
	},
	methods:{
		async regis(){
			document.getElementById('error_name').innerHTML = '';
			document.getElementById('error_email').innerHTML = '';
			document.getElementById('error_password').innerHTML = '';
			document.getElementById('error_repeat_password').innerHTML = '';
			await this.axios.post(`/api/account/register`, this.data).then(response=>{
				this.success = response.data.success
				this.data = response.data.data
				if(this.success == true){
					alert('Akun berhasil dibuat')
					this.$router.push({ name: 'Main' })
					return false;
				}
				else{
					console.log(this.message);
				}
			}).catch(error=>{
				const message = error.response
				const geterror = message.data.data
				for (let key of Object.keys(geterror)) {
					const setvar = 'error_' + key;
					const sethtml = 'geterror.' + key;
					document.getElementById(setvar).innerHTML = eval(sethtml);
				}
			})
		},
		async checklogin(){
			// belum tahu mau ngapain disini
		},
	},
	components: {
		'Forms':Forms,
	}
}
</script>