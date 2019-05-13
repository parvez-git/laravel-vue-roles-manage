<template>

	<v-dialog v-model="dialog" max-width="400">
        <v-card>
            <v-card-title class="subheading grey--text text-uppercase">Add New Role</v-card-title>

			<v-form @submit.prevent="submit">
	            <v-card-text>
	                <v-container py-0>
	                    <v-layout wrap>
	                  		<v-flex xs12>
	                    		<v-text-field 
	                    			label="Role Name" 
	                    			v-model="fields.name" 
	                    			prepend-icon="person_outline" 
	                    			hide-details 
	                    			required>
	                    		</v-text-field>
	                    		<div 
	                    			v-if="errors && errors.name" 
	                    			class="caption red--text font-italic mt-1">
	                    			{{ errors.name[0] }}
	                    		</div>
	                  		</v-flex>
	                  		<v-flex xs12>
	                  			<v-checkbox 
	                  				v-for="permission in fields.permissions" 
	                  				:key="permission.id" 
	                  				:label="permission.name" 
	                  				:value="permission.name" 
	                  				v-model="fields.selectedpermissions"
	                  				hide-details
	                  				multiple>
	                  			</v-checkbox>
	                  		</v-flex>
	                  </v-layout>
	              </v-container>
	            </v-card-text>

	            <v-card-actions>
	                <v-spacer></v-spacer>

	                <v-btn color="red" flat="flat" @click="closeDialog">
	                    Close
	                </v-btn>

	                <v-btn color="green" flat="flat" :loading="loading" type="submit">
	                    Save
	                </v-btn>
	            </v-card-actions>
            </v-form>

        </v-card>
    </v-dialog>

</template>

<script>
    export default {
        data() {
            return {
            	dialog: false,
            	fields: {},
				errors: {},
				loading: false
            }
        },
        created() {
        	eventBus.$on('openCreateRoleDialog', (data) => { 
        		this.dialog = data.dialog
        		this.fields.permissions = data.permissions
        	})
        },
		methods: {
		    submit() {
			    if (true) {
			        this.loading = true
			        this.errors = {}
			        axios.post('/role-store', this.fields).then(response => {
			          this.fields = {}
			          this.pushRoleData(response.data)
			          this.loading = false
			          this.dialog = false
			        }).catch(error => {
			          	this.loading = false
			          	if (error.response.status === 422) {
			            	this.errors = error.response.data.errors || {}
			          	}
			        })
			    }
		    },
		    closeDialog() {
		    	this.dialog = false
				this.errors = {}
				this.fields.name = null
				this.fields.selectedpermissions = []
		    },
            pushRoleData(userData) {
                eventBus.$emit('pushRoleData',userData)
            }
		 },
    }
</script>