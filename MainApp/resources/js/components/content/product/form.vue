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
						<Forms v-model="data.name" v-bind:value="data.name" v-bind:type="'text'" v-bind:labels="'Nama Produk'" v-bind:setid="'name'" v-bind:setattribute="`${this.$route.params.status}` === 'show' ? 'disabled':''"/>
						<Forms v-model="data.stock" v-bind:value="data.stock" v-bind:type="'text'" v-bind:labels="'Stock'" v-bind:setid="'stock'" v-bind:setattribute="`${this.$route.params.status}` === 'show' ? 'disabled':''"/>			
						<Forms v-model="data.price" v-bind:value="data.price" v-bind:type="'text'" v-bind:labels="'Harga'" v-bind:setid="'price'" v-bind:setattribute="`${this.$route.params.status}` === 'show' ? 'disabled':''"/>			
						<Forms v-model="data.user_id" v-bind:value="data.user_id" v-bind:type="'hidden'" v-bind:labels="'Kosong'" v-bind:setid="'user_id'"/>			
						<div v-if="status === 'edit' || status === 'create'">
							<Forms v-model="newfile" v-bind:type="'file'" v-bind:labels="'Upload File'" v-bind:setid="'image'" v-bind:setattribute="''"/>
							<router-link :to='{name:"ProductIndex",}' class="float-left btn btn-danger btn-sm">Kembali</router-link>
							<div v-html="submitbutton"></div>
						</div>
						<div v-else>
							<center>
								<img v-bind:src="'/product/' + data.image" height="240px" width="240px" class="img-fluid" alt="Responsive image">
							</center>
						</div>
					</form>
				  </div>
				  <div v-if="status === 'show'" class="card-footer">
					<router-link :to='{name:"ProductIndex",}' class="float-left btn btn-danger btn-sm">Kembali</router-link>
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
				stock:'',
				price:'',
				user_id:'',
				image:'',
			},
			list:[],
			submitbutton:'',
			titles:'',
			status:'',
			newfile:'',
		}
	},
	mounted(){
		this.getData()
	},
	methods:{
		async getData(){
			this.status = `${this.$route.params.status}`;
			
			if(this.status == 'show' || this.status == 'edit'){
				let tokenStr = localStorage.getItem('token');
				await this.axios.get(`/api/product/detail/${this.$route.params.id}`, { headers: {"Authorization" : `Bearer ${tokenStr}`} }).then(response=>{
					this.data = response.data.data
					this.success = response.data.success
					this.message = response.data.message
					if(this.status == 'show'){
						this.titles = 'Detail data : ' + this.data.name;
					}
					else{
						this.titles = 'Edit data : ' + this.data.name;
						this.submitbutton = `<button type="submit" class="float-right btn btn-primary btn-sm mx-2" value="update">Ubah</button>`;
					}
					if(this.status == 'show'){
						this.list = ['Produk', 'Detail Data', this.data.name];
					}
					else{
						this.list = ['Produk', 'Edit Data', this.data.name];
					}
				}).catch(error=>{
					console.log(error)
					this.data = {}
				})
			}
			else{
				this.list = ['Produk', 'Tambah Data'];
				this.titles = 'Tambah data';
				this.data.user_id = localStorage.getItem('id');
				this.submitbutton = `<button type="submit" class="float-right btn btn-primary btn-sm mx-2" value="create">Simpan</button>`;
			}
		},
		async submitdata(){
			if(this.status == 'edit'){
				var urllink = `/api/product/update/${this.$route.params.id}`;
			}
			else{
				var urllink = `/api/product/store`;
			}
			
			const subForm = new FormData();
			subForm.append("name", this.data.name);
			subForm.append("stock", this.data.stock);
			subForm.append("price", this.data.price);
			subForm.append("user_id", this.data.user_id);
			if(this.newfile != null)
			{
				subForm.append("image", this.newfile);
			}
			document.getElementById('error_name').innerHTML = '';
			document.getElementById('error_stock').innerHTML = '';
			document.getElementById('error_price').innerHTML = '';
			document.getElementById('error_image').innerHTML = '';
			let tokenStr = localStorage.getItem('token');
			await this.axios.post(urllink, subForm, { headers: {"Authorization" : `Bearer ${tokenStr}`} }).then(response=>{
				this.success = response.data.success
				if(this.success == true){
					this.$router.push({name:"ProductIndex"})
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
	},
	components: {
		'Forms':Forms,
		'Breadcrumb':Breadcrumb,
	}
}
</script>