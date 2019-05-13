<template>
    <div class="chat">

        <h1 class="subheading grey--text text-uppercase">Start conversation with mate</h1>

        <v-container>

            <v-layout row class="chat-box">

                <userlist-component 
                    :userlist="userlist"
                    @selected="startConversationWith"
                >
                </userlist-component>

                <conversation-component 
                    :user="user"
                    :userselected="userselected" 
                    :conversations="conversations"
                    @send="sendMessage"
                >
                </conversation-component>

            </v-layout>

        </v-container>
        
    </div>
</template>

<script>

    import UserList from './chat/UserComponent'
    import ConversationComponent from './chat/ConversationComponent'

    export default {
        name: 'chat',
        components: {
			'userlist-component': UserList,
			'conversation-component': ConversationComponent
        },
        props: {
            user: {
                type: Object,
                default: null
            }
        },
        data () {
            return {
                userlist: [],
                userselected: null,
                conversations: []
            }
        },
        mounted() {

            Echo.private(`messages.${this.user.id}`)
                .listen('NewChatMessage', (e) => {

                    this.hanleIncoming(e.message);
                });

            axios.get('/chat/user-list')
                .then( (response) => {

                    this.userlist = (response.data)
                })
                .catch( (error) => {
                    console.log(error);
                });
        },

        methods: {
            startConversationWith(user) {

                this.updateUnreadCount(user, true);

                axios.get(`/chat/user-conversations/${user.id}`)
                    .then( (response) => {
                        this.conversations = (response.data)

                        this.userselected = user
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            },

            sendMessage(message) {

                axios.post('/chat-conversation/send', {
                    to: this.userselected.id,
                    message: message
                })
                .then( (response) => {
                    this.conversations.push(response.data)
                })
                .catch( (error) => {
                    console.log(error);
                });

            },

            hanleIncoming(message) {
                if (this.userselected && message.from == this.userselected.id) {
                    this.conversations.push(message);
                    return;
                }
                this.updateUnreadCount(message.from_user, false)
            },

            updateUnreadCount(user, reset) {
                this.userlist = this.userlist.map((single) => {
                    if (single.id !== user.id) {
                        return single;
                    }
                    if (reset)
                        single.unread = 0;
                    else
                        single.unread += 1;
                    return single;
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    @media only screen and (min-device-width : 320px) and (max-device-width : 480px) {
        .layout.chat-box {
            flex-wrap: wrap !important;
        }
    }
</style>
