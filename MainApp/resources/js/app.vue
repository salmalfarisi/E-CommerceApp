<template>
    <main>
		<Navbar/>
		<div class="content-wrapper overflow-hidden">
			<div class="container">
				<router-view></router-view>
			</div>
			<footer class="fixed-bottom main-footer">
				<div class="float-right d-none d-sm-inline">
					PT. Dantech Teknologi Indonesia
				</div>
			</footer>
		</div>
    </main>
</template>

<script>
import Navbar from './components/elements/navbar.vue';

export default {
	data(){
		return{
			status:'',
		}
	},
	mounted(){
		this.loadSession()
	},
	methods:{
		async loadSession(){
			this.status = localStorage.getItem('login');
			if(this.status == 'true'){
				document.getElementById('bodyclass').className = 'sidebar-mini';
				this.$router.push({name:"ProductIndex"})
			}
			else{
				document.getElementById('bodyclass').className = 'overflow-hidden layout-top-nav sidebar-collapse';
				this.$router.push({name:"Main"})
			}
		},
	},
	components: {
		Navbar,
	}
}
</script>