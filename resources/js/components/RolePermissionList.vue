<template>
    <div class="rolepermissionlist">

        <h1 class="subheading grey--text text-uppercase">role permission list</h1>

        <v-container>

            <v-layout wrap class="mb-3">

                <v-tooltip top>
                    <v-btn small flat color="grey" @click="sortBy('name')" slot="activator">
                        <v-icon left small>sort</v-icon>
                        <span class="caption">Name</span>
                    </v-btn>
                    <span>sort role by name.</span>
                </v-tooltip>

                <v-tooltip top>
                    <v-btn small flat color="grey" @click="sortBy('created_at')" slot="activator">
                        <v-icon left small>sort</v-icon>
                        <span class="caption">Created</span>
                    </v-btn>
                    <span>sort role by created date.</span>
                </v-tooltip>

                <v-spacer></v-spacer>

                <v-btn small flat outline color="green" @click="openCreateRoleDialog">
                    <v-icon left small>add_circle</v-icon>
                    <span class="caption">Role</span>
                </v-btn>
                <v-btn small flat outline color="green" @click="openCreatePermissionDialog">
                    <v-icon left small>add_circle</v-icon>
                    <span class="caption">Permission</span>
                </v-btn>

            </v-layout>

            <v-card flat v-for="rolepermission in rolepermissionlist" :key="rolepermission.id" class="cardborder">
                <v-layout row wrap class="pa-3">
                    <v-flex xs12 md2>
                        <div class="caption grey--text">Role</div>
                        <div>{{ rolepermission.name }}</div>
                    </v-flex>
                    <v-flex xs12 md6>
                        <div class="caption grey--text">Permission</div>
                        <div>
                            <v-chip v-for="permission in rolepermission.permissions" :key="permission.id" small color="green" outline>{{ permission.name }}</v-chip>
                        </div>
                    </v-flex>
                    <v-flex xs12 md2>
                        <div class="caption grey--text">Created</div>
                        <div>{{ rolepermission.created_at }}</div>
                    </v-flex>
                    <v-flex xs12 md2>
                        <v-btn flat small fab outline color="red" class="right" @click="deleteRole(rolepermission)">
                            <v-icon>delete</v-icon>
                        </v-btn>
                        <v-btn flat small fab outline color="blue" class="right" @click="openEditRoleDialog(rolepermission)">
                            <v-icon small>edit</v-icon>
                        </v-btn>
                    </v-flex>
                </v-layout>
                <v-divider></v-divider>
            </v-card>

            <div class="text-xs-center mt-3">
                <v-card flat>
                    <v-btn small flat @click="fetchPaginateRole(pagination.prev_page_url)" :disabled="!pagination.prev_page_url">Prev</v-btn>
                    <v-btn small flat disabled v-text="`page ${pagination.current_page} of ${pagination.last_page}`"></v-btn>
                    <v-btn small flat @click="fetchPaginateRole(pagination.next_page_url)" :disabled="!pagination.next_page_url">Next</v-btn>
                </v-card>
            </div>

            <v-layout>
                <dialog-create-role></dialog-create-role>
            </v-layout>

            <v-layout>
                <dialog-create-permission></dialog-create-permission>
            </v-layout>

            <v-layout>
                <dialog-edit-role></dialog-edit-role>
            </v-layout>

            <v-layout>
                <dialog-delete-role></dialog-delete-role>
            </v-layout>

            <v-snackbar v-model="snackbar" color="success" bottom right>
                <span>Role deleted successfully.</span>
                <v-btn dark flat @click="snackbar = false">Close</v-btn>
            </v-snackbar>

        </v-container>

    </div>
</template>

<script>

    import CreateRole from './dialogs/CreateRole'
    import EditRole from './dialogs/EditRole'
    import DeleteRole from './dialogs/DeleteRole'
    import CreatePermission from './dialogs/CreatePermission'

    export default {
        name: 'roles-permissions',
        components: {
            'dialog-create-role': CreateRole,
            'dialog-create-permission': CreatePermission,
            'dialog-edit-role': EditRole,
            'dialog-delete-role': DeleteRole
        },
        data() {
            return {
                rolepermissionlist: [],
                permissions: [],
                roles: [],
                url: '/role-permission-list',
                pagination: [],
                role: {},
                snackbar: false
            }
        },
        created(){
            this.getRolesPermissions()
            this.getPermissions()
            this.getRoles()

            eventBus.$on('pushRoleData', (role) => { 
                this.rolepermissionlist.unshift(role)
                this.getRoles()
            })
            eventBus.$on('pushUpdatedRole', (data) => { 
                this.getRolesPermissions()
            })
            eventBus.$on('pushPermissionData', (data) => { 
                this.getRolesPermissions()
                this.getPermissions()
            })
            eventBus.$on('updateDeletedRole', (data) => {
                this.getRolesPermissions()
                this.getRoles()
            })
        },
        methods: {
            sortBy(prop) {
                this.rolepermissionlist.sort( (a,b) => a[prop] < b[prop] ? -1 : 1)
            },
            getRolesPermissions() {
                let vm = this
                axios.get(this.url)
                    .then( (response) => {
                        this.rolepermissionlist = (response.data.data)
                        vm.makePagination(response.data)
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            },
            getPermissions() {
                let vm = this
                axios.get('/permission-list')
                    .then( (response) => {
                        this.permissions = (response.data)
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            },
            getRoles() {
                let vm = this
                axios.get('/role-list')
                    .then( (response) => {
                        this.roles = (response.data)
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            },
            openCreateRoleDialog() {
                eventBus.$emit('openCreateRoleDialog',{
                    dialog: true,
                    permissions: this.permissions
                })
            },             
            openCreatePermissionDialog() {
                eventBus.$emit('openCreatePermissionDialog',{
                    dialog: true,
                    roles: this.roles
                })
            },            
            openEditRoleDialog(rolepermission) {
                eventBus.$emit('openEditRoleDialog', {
                    dialog: true,
                    rolepermission: rolepermission,
                    allpermission: this.permissions
                })
            },
            deleteRole(role) {
                if (role.id) {
                    eventBus.$emit('openDeleteRoleDialog', {
                        dialog: true,
                        role: role 
                    })
                }
            },
            makePagination(data) {
                let pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url
                }
                this.pagination = pagination
            },
            fetchPaginateRole(url) {
                this.url = url
                this.getRolesPermissions()
            }
        },
        mounted() {
            console.log('Role Component mounted.')
        }
    }
</script>

<style scoped>
    .cardborder:nth-child(4n+1){
        border-left: 4px solid green;
    }    
    .cardborder:nth-child(4n+2){
        border-left: 4px solid orange;
    }
    .cardborder:nth-child(4n+3){
        border-left: 4px solid teal;
    } 
    .cardborder:nth-child(4n+0){
        border-left: 4px solid tomato;
    }

    .v-chip.editor{
        background-color: green;
    }    
    .v-chip.caption{
        background-color: orange;
    }  
    .v-chip.writer{
        background-color: tomato;
    }
</style>
