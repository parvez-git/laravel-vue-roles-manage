<template>
    <div class="userprofile">
        <v-container>
            <v-layout row wrap>
                <v-flex xs12 md6 offset-md3>

                    <div class="d-none">
                        <input type="file" @change="onFileSelected" ref="fileField">
                        <input type="submit" @click="onUpload" ref="submitField">
                    </div>
                    
                    <v-img :src="defaultFile">
                        <v-layout column fill-height>
                            <v-card-title>
                                <v-spacer></v-spacer>
                                <v-btn v-show="!this.uploadBtn" @click="$refs.fileField.click()" fab dark color="teal">
                                    <v-icon dark>edit</v-icon>
                                </v-btn>
                                <v-btn v-show="this.uploadBtn" @click="$refs.submitField.click()" fab dark color="red">
                                    <v-icon dark>cloud_upload</v-icon>
                                </v-btn>
                            </v-card-title>
                            <v-spacer></v-spacer>
                            <v-card-title class="white--text pl-5 pt-5">
                                <div class="headline pl-5 pt-5">{{ user.name }}</div>
                            </v-card-title>
                        </v-layout>
                    </v-img>

                    <v-list two-line>
                        <v-list-tile>
                            <v-list-tile-action>
                                <v-icon color="indigo">mail</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title>{{ user.email }}</v-list-tile-title>
                                <v-list-tile-sub-title>Personal</v-list-tile-sub-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>

                    <v-snackbar v-model="snackbar" :color="snackbarcolor" bottom right>
                        {{ snackbartext }}
                        <v-btn dark flat @click="snackbar = false">Close</v-btn>
                    </v-snackbar>

                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>

export default {
    name: 'userprofile',
    props: {
        user: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            defaultFile: '/images/profile/' + this.user.profile_picture,
            selectedFile: null,
            uploadBtn: false,
            snackbartext: '',
            snackbarcolor: '',
            snackbar: false
        }
    },
    methods: {
        onFileSelected(e) {
            this.selectedFile = e.target.files[0]

            if(!this.selectedFile.type.match('image.*')) {
                this.snackbartext = (`${this.selectedFile.name} is not a image`)
                this.snackbarcolor = 'error'
                this.snackbar = true
                this.uploadBtn = false
                return;
            }

            let reader = new FileReader()
            reader.onload = (e) => {
                this.defaultFile = e.target.result
            }
            reader.readAsDataURL(this.selectedFile)

            this.uploadBtn = true
        },
        onUpload() {
            const formData = new FormData()
            formData.append('image', this.selectedFile, this.selectedFile.name)

            axios.post('/settings-upload', formData)
                .then( (response) => {
                    this.snackbartext = (response.data.message)
                    this.snackbarcolor = 'success'
                    this.snackbar = true
                    this.uploadBtn = false

                    this.onUpdateUserProfile(response.data.profile)
                })
                .catch( (error) => {
                    console.log(error);
                });         
        },
        onUpdateUserProfile(profile) {
            eventBus.$emit('onUpdateUserProfile',profile)
        },
        
    },
    mounted() {
       
    }
}
</script>
