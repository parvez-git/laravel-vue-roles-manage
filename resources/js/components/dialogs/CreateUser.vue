<template>

	<v-dialog v-model="dialog" max-width="400">
        <v-card>
            <v-card-title class="subheading grey--text text-uppercase">Add New User</v-card-title>

			<v-form @submit.prevent="submit">
	            <v-card-text>
	                <v-container py-0>
	                    <v-layout wrap>

	                  		<v-flex xs12>
	                    		<v-text-field label="Name" v-model="fields.name" prepend-icon="person_outline" required></v-text-field>
	                    		<div v-if="errors && errors.name" class="caption red--text font-italic">{{ errors.name[0] }}</div>
	                  		</v-flex>
	                  		<v-flex xs12>
	                    		<v-text-field label="Email" v-model="fields.email" prepend-icon="mail_outline" required></v-text-field>
	                    		<div v-if="errors && errors.email" class="caption red--text font-italic">{{ errors.email[0] }}</div>
	                  		</v-flex>
	                  		<v-flex xs12>
	                    		<v-text-field label="Password" v-model="fields.password" type="password" prepend-icon="lock_open" required></v-text-field>
	                    		<div v-if="errors && errors.password" class="caption red--text font-italic">{{ errors.password[0] }}</div>
	                  		</v-flex>
							
	                  </v-layout>
	              </v-container>
	            </v-card-text>

	            <v-card-actions>
	                <v-spacer></v-spacer>

	                <v-btn color="red" flat="flat" @click="closeDialog">
	                    Close
	                </v-btn>

	                <v-btn color="green" flat="flat" :loading="loading" @click="submit">
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
				loading: false,
            }
        },
        created() {
        	eventBus.$on('openCreateUserDialog', (dialog) => { 
        		this.dialog = dialog 
        	})
        },
		methods: {
		    submit() {
			    if (true) {
			        this.loading = true
			        this.errors = {}
			        axios.post('/storeuser', this.fields).then(response => {
			          this.fields = {}
			          this.loading = false
			          this.pushUserData(response.data)
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
            pushUserData(userData) {
                eventBus.$emit('pushUserData',userData)
            }
		 },
    }
</script>

<style scoped>
	.caption.red--text.font-italic{
		margin-top: -16px !important;
	}
</style>