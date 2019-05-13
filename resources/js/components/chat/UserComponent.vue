<template>
    <v-flex xs12 sm4 class="scroll-bar">

        <v-card flat>

            <v-list two-line class="pa-0" dense>

                <template v-for="(user, index) in sortedusers">

                    <v-list-tile 
                        :key="user.id"
                        @click="selectUser(user)"
                        :class="{ 'grey lighten-4': user == selected }"
                        class="listitem"
                        avatar
                    >
                        <v-list-tile-avatar>
                            <img :src="`/images/profile/${user.profile_picture}`" color="red lighten-5">
                        </v-list-tile-avatar>

                        <v-list-tile-content>
                            <v-list-tile-title 
                                class="body-2"
                                :class="{ 'teal--text': user == selected }" 
                                v-html="user.name"
                            ></v-list-tile-title>
                            <v-list-tile-sub-title v-html="user.email"></v-list-tile-sub-title>
                        </v-list-tile-content>

                        <v-list-tile-action v-show="user.unread">
                            <v-list-tile-action-text>
                                <v-badge left>
                                    <template v-slot:badge>
                                        <span>{{ user.unread }}</span>
                                    </template>
                                </v-badge>
                            </v-list-tile-action-text>
                        </v-list-tile-action>

                    </v-list-tile>
                    
                    <v-divider v-if="index + 1 < userlist.length" :key="`divider-${index}`"></v-divider>

                </template>

            </v-list>

        </v-card>

    </v-flex>
</template>

<script>
    export default {
        props: {
            userlist: {
                type: Array,
                default: []
            }
        },
        data() {
            return {
                selected: this.userlist.length ? this.userlist[0] : null
            }
        },
        methods: {
            selectUser(user){
                this.selected = user

                this.$emit('selected', user)
            }
        },
        computed: {
            sortedusers() {
                return _.sortBy(this.userlist, [(user) => {

                    if (user == this.selected) {
                        return Infinity
                    }

                    return user.unread

                }]).reverse()
            }
        },
        mounted() {

        }
    }
</script>
