<template>

	<v-dialog v-model="dialog" max-width="400">
        <v-card>
            <v-card-title class="subheading grey--text text-uppercase">Edit Role and Permissions</v-card-title>

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
	                    			class="caption red--text font-italic">
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
        	eventBus.$on('openEditRoleDialog', (data) => { 
        		this.dialog = data.dialog
        		this.fields.id = data.rolepermission.id
        		this.fields.name = data.rolepermission.name
        		this.fields.permissions = data.allpermission

        		let permissions = []
        		data.rolepermission.permissions.map( (item) => {
        			permissions.push(item['name'])
        		})
        		this.fields.selectedpermissions = permissions

        	})
        },
		methods: {
		    submit() {
			    if (this.fields.id) {
			        this.loading = true
			        this.errors = {}
			        axios.put('/role-update', this.fields).then(response => {
			          this.fields = {}
			          this.loading = false
			          this.pushUpdatedRole(response.data)
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
		    },
            pushUpdatedRole(data) {
                eventBus.$emit('pushUpdatedRole',data)
            }
		 },
    }
</script>