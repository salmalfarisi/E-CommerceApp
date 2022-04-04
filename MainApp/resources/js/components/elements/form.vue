<template>
	<div v-if="type === 'text'">
		<div class="form-group">
			<label>{{ labels }}</label>
			<input type="text" v-bind:value="value" v-on:input="$emit('input', $event.target.value)" class="form-control" v-bind:id="'set_'+setid">
			<small class="text-danger" v-bind:id="'error_'+setid"></small>
		</div>
	</div>
	<div v-else-if="type === 'textarea'">
		<div class="form-group">
			<label>{{ labels }}</label>
			<textarea v-bind:value="value" v-on:input="$emit('input', $event.target.value)" class="form-control" v-bind:id="'set_'+setid" rows="6"></textarea>
			<small class="text-danger" v-bind:id="'error_'+setid"></small>
		</div>
	</div>
	<div v-else-if="type === 'checkbox'">
		<div class="form-check">
			<input class="form-check-input" type="checkbox" v-bind:value="value" v-on:input="$emit('input', $event.target.value)" v-bind:id="'set_'+setid" >
			<label class="form-check-label">{{ labels }}</label>
		</div>
	</div>
	<div v-else-if="type === 'date'">
		<div class="form-group">
			<label>{{ labels }}</label>
			<input type="date" v-bind:value="value" v-on:input="$emit('input', $event.target.value)" class="form-control" v-bind:id="'set_'+setid" >
			<small class="text-danger" v-bind:id="'error_'+setid"></small>
		</div>
	</div>
	<div v-else-if="type === 'datetime-local'">
		<div class="form-group">
			<label>{{ labels }}</label>
			<!-- perbaiki lagi disini -->
			<input type="datetime-local" v-bind:value="value" v-on:input="$emit('input', $event.target.value)" class="form-control" v-bind:id="'set_'+setid" >
			<small class="text-danger" v-bind:id="'error_'+setid"></small>
		</div>
	</div>
	<div v-else-if="type === 'email'">
		<div class="form-group">
			<label>{{ labels }}</label>
			<input type="email" v-bind:value="value" v-on:input="$emit('input', $event.target.value)" class="form-control" v-bind:id="'set_'+setid" >
			<small class="text-danger" v-bind:id="'error_'+setid"></small>
		</div>
	</div>
	<div v-else-if="type === 'file'">
		<div class="form-group">
			<label>{{ labels }}</label>
			<input type="file" v-on:input="$emit('input', $event.target.files[0])" v-bind:id="'set_'+setid">
			<small v-for="index in option">{{ index }}</small>
			<small class="text-danger" v-bind:id="'error_'+setid"></small>
		</div>
	</div>
	<div v-else-if="type === 'hidden'">
		<input type="hidden" v-bind:value="value" v-on:input="$emit('input', $event.target.value)" v-bind:id="'set_'+setid">
	</div>
	<div v-else-if="type === 'month'">
		<div class="form-group">
			<label>{{ labels }}</label>
			<input type="month" v-bind:value="value" v-on:input="$emit('input', $event.target.value)" class="form-control" v-bind:id="'set_'+setid" >
			<small class="text-danger" v-bind:id="'error_'+setid"></small>
		</div>
	</div>
	<div v-else-if="type === 'password'">
		<div class="form-group">
			<label>{{ labels }}</label>
			<input type="password"  v-on:input="$emit('input', $event.target.value)" class="form-control" v-bind:id="'set_'+setid" >
			<small class="text-danger" v-bind:id="'error_'+setid"></small>
		</div>
	</div>
	<div v-else-if="type === 'radio'">
		<!-- Perbaiki lagi -->
		<div class="form-group">
			<label>{{ labels }}</label>
			<div class="form-inline">
				<div v-for="item in option">
					<div v-if="item[0] === value">
						<label class="radio-inline">
							<input type="radio" class="mx-2" v-bind:value="item[0]" v-bind:id="'set_'+setid+item[0]" checked> {{ item[1] }}
						</label>
					</div>
					<div v-else>
						<label class="radio-inline">
							<input type="radio" class="mx-2" v-bind:value="item[0]" v-bind:id="'set_'+setid+item[0]"> {{ item[1] }}
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div v-else-if="type === 'range'">
		<div class="form-group">
			<label>{{ labels }}</label>
			<input type="range" v-bind:value="value" v-on:input="$emit('input', $event.target.value)" class="form-control" v-bind:id="'set_'+setid" >
			<small class="text-danger" v-bind:id="'error_'+setid"></small>
		</div>
	</div>
	<div v-else-if="type === 'reset'">
	</div>
	<div v-else-if="type === 'time'">
		<div class="form-group">
			<label>{{ labels }}</label>
			<input type="time" v-bind:value="value" v-on:input="$emit('input', $event.target.value)" class="form-control" v-bind:id="'set_'+setid" >
			<small class="text-danger" v-bind:id="'error_'+setid"></small>
		</div>
	</div>
	<div v-else-if="type === 'url'">
		<div class="form-group">
			<label>{{ labels }}</label>
			<input type="url" v-bind:value="value" v-on:input="$emit('input', $event.target.value)" class="form-control" v-bind:id="'set_'+setid" >
			<small class="text-danger" v-bind:id="'error_'+setid"></small>
		</div>
	</div>
	<div v-else-if="type === 'select'">
		<div class="form-group">
			<label>{{ labels }}</label>
			<select v-bind:value="value" v-on:input="$emit('input', $event.target.value)" class="form-control" v-bind:id="'set_'+setid">
				<option v-for="item in option" v-bind:value="item[0]">{{ item[1] }}</option>
			</select>
			<small class="text-danger" v-bind:id="'error_'+setid"></small>
		</div>
	</div>
	<div v-else>
		<div class="h1 text-danger">Error While Rendering</div>
	</div>
</template>

<script>
export default{
	name:'Forms',
	props: ['value', 'type', 'labels', 'setid', 'setattribute', 'option'],
	mounted(){
		this.setAttributes()
	},
	methods:{
		async setAttributes(props){
			if(this.type === 'select' || this.type === 'radio' || this.type === 'checkbox'){
				const totaloption = this.option;
				if(totaloption.length === parseInt('0')){
					const message = 'Please insert option options first!';
					alert(message)
					return false;
				}
			}
			const ids = 'set_'+this.setid;
			if(this.type !== 'hidden'){
				const input = this.setattribute;
				const pecah = input.split(" ");
				const getattribute = ['accept', 'alt', 'autocomplete', 'autofocus', 'checked', 'disabled', 'height', 'max', 'maxlength', 'min', 'minlength', 'placeholder', 'readonly', 'required', 'size', 'width']
				for(var i=0; i<pecah.length; i++){
					for(var j=0; j<getattribute.length; j++){
						const result = pecah[i].includes(getattribute[j])
						if(result === true){
							if(getattribute[j] === 'autofocus' ||  getattribute[j] === 'checked' || getattribute[j] === 'disabled' || getattribute[j] === 'readonly' || getattribute[j] === 'required'){
								if(getattribute[j] === 'autofocus'){
									document.getElementById(ids).autofocus = true;
								}
								else if(getattribute[j] === 'checked'){
									document.getElementById(ids).checked = true;
								}
								else if(getattribute[j] === 'disabled'){
									document.getElementById(ids).disabled = true;
								}
								else if(getattribute[j] === 'readonly'){
									document.getElementById(ids).readonly = true;
								}
								else if(getattribute[j] === 'required'){
									document.getElementById(ids).required = true;
								}
							} 
							else{
								const getprop = pecah[i].split("=");
								if(getprop[0] === 'accept'){
									document.getElementById(ids).accept = getprop[1].toString();
								}
								else if(getprop[0] === 'alt'){
									document.getElementById(ids).alt = getprop[1].toString();
								}
								else if(getprop[0] === 'autocomplete'){
									document.getElementById(ids).autocomplete = getprop[1].toString();
								}
								else if(getprop[0] === 'height'){
									document.getElementById(ids).height = getprop[1].toString();
								}
								else if(getprop[0] === 'max'){
									document.getElementById(ids).max = getprop[1].toString();
								}
								else if(getprop[0] === 'maxlength'){
									document.getElementById(ids).maxlength = getprop[1].toString();
								}
								else if(getprop[0] === 'min'){
									document.getElementById(ids).min = getprop[1].toString();
								}
								else if(getprop[0] === 'minlength'){
									document.getElementById(ids).minlength = getprop[1].toString();
								}
								else if(getprop[0] === 'placeholder'){
									document.getElementById(ids).placeholder = getprop[1].toString();
								}
								else if(getprop[0] === 'size'){
									document.getElementById(ids).size = getprop[1].toString();
								}
								else if(getprop[0] === 'width'){
									document.getElementById(ids).width = getprop[1].toString();
								}
							}
						}
					}
				}
			}
		},
	},
}
</script>