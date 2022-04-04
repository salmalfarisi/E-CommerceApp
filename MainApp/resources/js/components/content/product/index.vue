<template>
	<div>
		<Breadcrumb v-bind:title="'Data Produk'" v-bind:list="['Produk']" />
		<div>
            <div class="card scroll-bar-table table-wrapper">
              <div class="card-header">
                <div class="card-title">Data produk</div>
                <div class="card-tools">
					<div v-if="is_admin == false">
						<router-link :to='{name:"ProductForm", params: {status: "create", id: "0"}, }' class="btn btn-primary btn-sm mx-1">Tambah Data</router-link>
					</div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table" id="Table">
                  <thead>
                    <tr>
                      <th col="10%">No</th>
                      <th col="40%">Nama</th>
                      <th col="10%">Stock</th>
                      <th col="10%">Harga</th>
                      <th col="30%">Pilihan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(loopdata, key) in data" :key="key" v-bind:id="'rows_'+ key">
						<td>{{ key+1 }}</td>
						<td>{{ loopdata.name }}</td>
						<td>{{ loopdata.stock }}</td>
						<td>{{ loopdata.price }}</td>
						<td v-if="loopdata.id != null" class="d-flex justify-content-center">
							<div v-if="is_admin == true">
								<router-link :to='{name:"ProductForm", params: {status: "show", id: loopdata.id}, }' class="btn btn-info btn-sm mx-1">Detail</router-link>
								<button v-on:click="confirmdelete(loopdata.id, loopdata.name, key)" type="button" class="btn btn-danger btn-sm mx-1" data-toggle="modal" data-target="#exampleModal">Hapus</button>
							</div>
							<div v-else>
								<router-link :to='{name:"ProductForm", params: {status: "show", id: loopdata.id}, }' class="btn btn-info btn-sm mx-1">Detail</router-link>
								<router-link :to='{name:"ProductForm", params: {status: "edit", id: loopdata.id}, }' class="btn btn-warning btn-sm mx-1">Edit</router-link>
								<button v-on:click="confirmdelete(loopdata.id, loopdata.name, key)" type="button" class="btn btn-danger btn-sm mx-1" data-toggle="modal" data-target="#exampleModal">Hapus</button>
							</div>
						</td>  
					</tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
			
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin ingin menghapus data ini ?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<div id="judulmodal"></div>
					<input id="rowsdata" type="hidden"/>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
					<button type="button" id="iddata" v-on:click="deleteData" class="btn btn-primary" data-dismiss="modal">Yes</button>
				  </div>
				</div>
			  </div>
			</div>
        </div>
	</div>
</template>

<script>
import Breadcrumb from '../../elements/breadcrumb.vue';

export default {
	data(){
		return {
			data:{
				success:false,
				message:'',
				data:[],
			},
			is_admin:localStorage.getItem('is_admin'),
		}
	},
	mounted(){
		this.loaddata()
	},
	methods:{
		async loaddata(){
			let tokenStr = localStorage.getItem('token');
			let checkadmin = this.is_admin;
			let userid = localStorage.getItem('id');
			let url = ``;
			if(checkadmin == true){
				url = `/api/product/index`;
			}
			else{
				url = `/api/product/index/` + userid;
			}
			await this.axios.get(url, { headers: {"Authorization" : `Bearer ${tokenStr}`} }).then(response=>{
				this.data = response.data.data
				this.success = response.data.success
				this.message = response.data.message
			}).catch(error=>{
				alert(error.data.message)
				this.data = []
			})
		},
		async confirmdelete(id, title, row){
			document.getElementById('judulmodal').innerHTML = title;
			document.getElementById('iddata').value = id;
			document.getElementById('rowsdata').value = row;
		},
		async deleteData(){
			var rows = document.getElementById('rowsdata').value;
			var id = document.getElementById('iddata').value;
			var urllink = `/api/user/delete/` + id
			let tokenStr = localStorage.getItem('token');
			await this.axios.patch(urllink, '', { headers: {"Authorization" : `Bearer ${tokenStr}`} }).then(response=>{
				this.success = response.data.success
				this.message = response.data.message
				this.data.splice(rows, 1);
				//location.replace('/');
				//location.reload();
				return false;
			}).catch(error=>{
				alert(error.data.message)
			})
		}
	},
	components:{
		Breadcrumb,
	},
}
</script>