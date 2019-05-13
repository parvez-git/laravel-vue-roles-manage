<template>
    <v-dialog v-model="dialog" persistent max-width="290">
        <v-card color="red">
            <v-card-title class="headline">
                <div class="headline text-xs-center white--text">
                    {{ deletemessage }}
                </div>
            </v-card-title>

            <div class="text-xs-center pt-3 pb-5">
                <i class="material-icons">delete_forever</i>
            </div>

            <div class="text-xs-center pb-3">
                <v-btn outline color="white" flat @click="dialog = false">Disagree</v-btn>
                <v-btn outline color="white" flat @click="submit">Agree</v-btn>
            </div>

        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        data() {
            return {
                dialog: false,
                deletemessage: '',
                userid: null
            }
        },
        created() {
            eventBus.$on("openDeleteUserDialog", (data) => {
                this.dialog = data.dialog
                this.userid = data.user.id
                this.deletemessage = 'Are you sure you want to delete user: ' + data.user.name + '?'
            })
        },
        methods: {
            submit() {
                if (this.userid) {
                    axios.delete('/deleteuser/' + this.userid)
                        .then(response => {
                            this.dialog = false
                            this.updateUser(response.data)
                        }).catch(error => {
                            console.log(error.response)
                        })
                }   
            },
            updateUser(data) {
                eventBus.$emit("updateDeletedUser", data)
            }
        }
    }
</script>

<style scoped>
    i.material-icons {
        font-size: 68px;
        color: white;
        border: 5px solid;
        border-radius: 50%;
        padding: 10px;
    }
</style>
