<template>
    <div v-if="data.checktoken !== null">
		<!-- Content Header (Page header) -->
		<div class="content-header pt-5 mt-3">
		  <div class="container">
			<div class="row mb-2">
			  <div class="col-sm-6">
				<h1 class="m-0">{{ title }}</h1>
			  </div><!-- /.col -->
			  <div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<div v-for="(val, key) of list">
						<li class="(key == Object.keys(list).length - 1) ? 'breadcrumb-item active' : 'text-decoration-none'" v-html="(key == Object.keys(list).length - 1) ? val : val + ' / '"></li>
					</div>
				</ol>
			  </div><!-- /.col -->
			</div><!-- /.row -->
		  </div>
		</div>
		<!-- /.content-header -->
	</div>
</template>

<script>
export default{
	name:'Breadcrumb',
	props: ['title', 'list'],
	data(){
		return {
			data:{
				checktoken:localStorage.getItem('token'),
			},
		}
	},
}
</script>