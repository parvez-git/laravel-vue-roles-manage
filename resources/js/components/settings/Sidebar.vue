<template>
    <div class="settings-sidebar">
        <v-container>
        <v-list class="pa-0 list-items" dense>
            <v-list-tile 
                v-for="item in items" 
                :key="item.title" 
                router-link :to="item.route"
            >
                <v-list-tile-action>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title class="body-2">{{ item.title }}</v-list-tile-title>
                </v-list-tile-content>

            </v-list-tile>
        </v-list>
        </v-container>
    </div>
</template>

<script>
    export default {
        name: 'settings-sidebar',
        data () {
            return {
                items: [
                    { 
                        title: 'Profile', 
                        icon: 'person', 
                        route: '/settings/profile' 
                    },
                    { 
                        title: 'Upload Gallery', 
                        icon: 'cloud_upload', 
                        route: '/settings/upload-gallery' 
                    },
                    { 
                        title: 'Settings', 
                        icon: 'settings', 
                        route: '/settings/general' 
                    },                    
                ]
            }
        }
    }
</script>

<style lang="scss" scoped>
    .list-items {
        border-top: 1px solid #e1e1e1;
        border-right: 1px solid #e1e1e1;
    }    
    .list-items > div {
        border-bottom: 1px solid #e1e1e1;
    }    
    
    .list-items > div:nth-child(3n) {
        border-left: 3px solid teal;
    } 
    .list-items > div:nth-child(3n+1) {
        border-left: 3px solid tomato;
    } 
    .list-items > div:nth-child(3n+2) {
        border-left: 3px solid green;
    }
</style>
