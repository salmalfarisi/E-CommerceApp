<template>
	<div>
		<div>
		<Breadcrumb v-bind:title="titles" v-bind:list="list" />
            <div class="pb-5 mb-5">
				<div class="card">
				  <div class="card-header">
					<h3 class="card-title">{{ titles }}</h3>
				  </div>
				  <div class="card-body">
					<form @submit.prevent="submitdata" enctype="multipart/form-data">
						<Forms v-model="data.name" v-bind:value="data.name" v-bind:type="'text'" v-bind:labels="'Nama User'" v-bind:setid="'name'" v-bind:setattribute="`${this.$route.params.status}` === 'show' ? 'disabled':''"/>
						<Forms v-model="data.email" v-bind:value="data.email" v-bind:type="'email'" v-bind:labels="'Email'" v-bind:setid="'email'" v-bind:setattribute="`${this.$route.params.status}` === 'show' ? 'disabled':''"/>			
						<div v-if="status === 'create'">
							<Forms v-model="data.password" v-bind:value="data.password" v-bind:type="'hidden'" v-bind:labels="'Password'" v-bind:setid="'password'"/>			
							<Forms v-model="data.repeat_password" v-bind:value="data.repeat_password" v-bind:type="'hidden'" v-bind:labels="'Repeat Password'" v-bind:setid="'repeat_password'"/>			
							<router-link :to='{name:"UserIndex",}' class="float-left btn btn-danger btn-sm">Kembali</router-link>
							<div v-html="submitbutton"></div>
						</div>
					</form>
				  </div>
				  <div v-if="status === 'show'" class="card-footer">
					<router-link :to='{name:"UserIndex",}' class="float-left btn btn-danger btn-sm">Kembali</router-link>
				  </div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import Breadcrumb from '../../elements/breadcrumb.vue';
import Forms from '../../elements/form.vue';

export default{
	name:"Formdata",
	data(){
		return {
			data:{
				success:'',
				message:'',
				name:'',
				password:'',
				repeat_password:'',
				email:'',
			},
			list:[],
			submitbutton:'',
			titles:'',
			status:'',
		}
	},
	mounted(){
		this.getData()
	},
	methods:{
		async getData(){
			this.status = `${this.$route.params.status}`;
			
			if(this.status == 'show'){
				let tokenStr = localStorage.getItem('token');
				await this.axios.get(`/api/account/detail/${this.$route.params.id}`, { headers: {"Authorization" : `Bearer ${tokenStr}`} }).then(response=>{
					this.data = response.data.data
					this.success = response.data.success
					this.message = response.data.message
					this.titles = 'Detail data : ' + this.data.name;
					this.list = ['User', 'Detail Data', this.data.name];
				}).catch(error=>{
					alert(error.data.message)
					this.data = {}
				})
			}
			else{
				this.list = ['User', 'Tambah Data'];
				this.titles = 'Tambah data';
				this.data.user_id = localStorage.getItem('id');
				this.submitbutton = `<button type="submit" class="float-right btn btn-primary btn-sm mx-2" value="create">Simpan</button>`;
			}
		},
		async submitdata(){
			document.getElementById('error_name').innerHTML = '';
			document.getElementById('error_email').innerHTML = '';
			await this.axios.post(`/api/account/register`, this.data).then(response=>{
				this.success = response.data.success
				this.data = response.data.data
				if(this.success == true){
					alert('Akun berhasil dibuat')
					this.$router.push({ name: 'UserIndex' })
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
	},
	components: {
		'Forms':Forms,
		'Breadcrumb':Breadcrumb,
	}
}
</script>