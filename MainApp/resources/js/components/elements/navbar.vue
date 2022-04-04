<template>
	<div>
		<!-- Navbar -->
		<nav class="fixed-top main-header navbar navbar-expand navbar-white navbar-light">
			<div class="container-fluid">
				<!-- Left navbar links -->
				<ul class="navbar-nav">
				  <div v-if="data.checktoken === true">
					  <li class="nav-item">
						<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					  </li>
				  </div>
				</ul>

				<!-- Right navbar links -->
				<ul class="navbar-nav ml-auto">
					<div v-if="data.checktoken === true">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<span class="nav-link" style="cursor: pointer;" v-on:click="logout">Logout</span>
							</li>
						</ul>
					</div>
					<div v-else>
						<ul class="navbar-nav ml-auto">
						  <li class="nav-item">
							<div class="nav-link">
								<router-link :to='{name:"Registration",}'>Daftar</router-link>
							</div>
						  </li>
						  <li class="nav-item">
							<div class="nav-link">
							  <div data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Login
							  </div>
							  <div class="dropdown-menu w-25 dropdown-menu-right">
								<form @submit.prevent="login">
									<div class="px-3">
										<Forms v-model="data.email" v-bind:type="'email'" v-bind:labels="'Email'" v-bind:setid="'email_navbar'" v-bind:setattribute="''"/>
										<Forms v-model="data.password" v-bind:type="'password'" v-bind:labels="'Password'" v-bind:setid="'password_navbar'" v-bind:setattribute="''"/>
									</div>
									<div class="px-3">
										<button type="submit" class="btn btn-primary btn-sm btn-block" value="save">Login</button>
									</div>
								</form>
							  </div>
							</div>
						  </li>
						</ul>
					</div>
				</ul>
			</div>
		</nav>
		<!-- /.navbar -->
		<div v-if="data.checktoken === true">
			<!-- Main Sidebar Container -->
			<aside class="main-sidebar sidebar-dark-primary main-sidebar sidebar-dark-primary vh-100 d-inline-block">
				<!-- Brand Logo -->
				<a href="#" class="brand-link">
				  <img v-bind:src="'/adminlte/dist/img/AdminLTELogo.png'" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
				  <span class="brand-text font-weight-light">ECommerce</span>
				</a>

				<!-- Sidebar -->
				<div class="sidebar overflow-hidden pb-5 mb-5">
				  <!-- Sidebar user panel (optional) -->
				  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
					  <img v-bind:src="'/adminlte/dist/img/avatar.png'" class="img-circle elevation-2" alt="User Image">
					</div>
					<div class="info">
					  <a href="#" class="d-block" v-html="data.name"></a>
					</div>
				  </div>

				  <!-- Sidebar Menu -->
				  <nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					  <li class="nav-item">
						<router-link :to='{name:"ProductIndex"}' class="nav-link">
						  <i class="nav-icon fas fa-database"></i>
						  <p>Product</p>
						</router-link>
					  </li>
					  <li class="nav-item" v-if="data.is_admin == true">
						<router-link :to='{name:"UserIndex"}' class="nav-link">
						  <i class="nav-icon fas fa-user"></i>
						  <p>User</p>
						</router-link>
					  </li>
					</ul>
				  </nav>
				  <!-- /.sidebar-menu -->
				</div>
				<!-- /.sidebar -->
			</aside>
		</div>
	</div>
</template>

<script>
import Forms from './form.vue';

export default {
	data(){
		return {
			data:{
				success:false,
				message:'',
				token:'',
				id:'',
				name:localStorage.getItem('name'),
				email:'',
				password:'',
				is_admin:localStorage.getItem('is_admin'),
				checktoken:false,
			},
		}
	},
	mounted(){
		this.loadSession()
	},
	methods:{
		async login(){
			await this.axios.post(`/api/account/login`, this.data).then(response=>{
				this.success = response.data.success
				this.data = response.data.data
				if(this.success == true){
					localStorage.setItem('token', this.data.token);
					localStorage.setItem('id', this.data.id);
					localStorage.setItem('email', this.data.email);
					localStorage.setItem('name', this.data.name);
					localStorage.setItem('login', this.success);
					localStorage.setItem('is_admin', this.data.is_admin);
					this.data.checktoken = this.success
					location.reload();
					//document.getElementById('bodyclass').className = 'sidebar-mini';
					//this.$router.push({ name: 'ProductIndex' })
					return false;
				}
				else{
					console.log(this.message);
				}
			}).catch(error=>{
				const message = error.response
				const geterror = message.data.data
				if(geterror !== null){
					alert(message.data.message);
				}
				else{
					for (let key of Object.keys(geterror)) {
						const setvar = 'error_' + key + '_navbar';
						const sethtml = 'geterror.' + key;
						document.getElementById(setvar).innerHTML = eval(sethtml);
					}
				}
			})
		},
		async logout(){
			let tokenStr = localStorage.getItem('token');
			await this.axios.get(`/api/account/logout`, { headers: {"Authorization" : `Bearer ${tokenStr}`} }).then(response=>{
				this.success = response.data.success
				this.data = response.data.data
				if(this.success == true){
					//document.getElementById('bodyclass').className = 'overflow-hidden layout-top-nav sidebar-collapse';
					localStorage.clear();
					location.replace('/');
					//this.data.checktoken = false
					//this.$router.push({ name: 'Main' })
					return false;
				}
				else{
					console.log(this.message);
				}
			}).catch(error=>{
				console.log(error)
				this.data = {}
			})
		},
		async loadSession(){
			const status = localStorage.getItem('login');
			if(status == 'true'){
				this.data.checktoken = true;
			}
			else{
				this.data.checktoken = false;
			}
			
		},
	},
	components: {
		'Forms':Forms,
	}
}
</script>