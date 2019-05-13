<template>
    <v-flex xs12 sm8 ref="feed" class="scroll-bar">

        <v-card flat>

            <h1 class="body-2 grey lighten-4 pa-custom">{{ userselected ? userselected.name : 'Select a user' }}</h1>
            <v-divider></v-divider>

            <div>
                <div class="message-box pl-4 pr-4"
                    v-for="conversation in conversations" 
                    :key="conversation.id"
                >
                    <v-card flat :class="`message-${conversation.to == userselected.id ? 'sent' : 'received'}`">
                        <v-avatar size="32">
                            <img 
                                v-if="conversation.to !== userselected.id"
                                :src="`/images/profile/${userselected.profile_picture}`"
                            >
                            <img 
                                v-else
                                :src="`/images/profile/${user.profile_picture}`"
                            >
                        </v-avatar>

                        <div class="message">
                            <span class="d-block">{{ conversation.message }}</span>
                            <span class="caption grey--text">{{ conversation.created_at | moment("from") }}</span>
                        </div>

                    </v-card>
                </div>
            </div>

        </v-card>

        <v-card flat class="pa-4" v-if="userselected">

            <v-textarea outline hide-details message 
                label="Message" 
                height="80px"
                v-model="message"
                @keydown.enter="send"
            ></v-textarea>

        </v-card>

    </v-flex>
</template>

<script>
export default {
    props: {
        user: {
            type: Object,
            default: null
        },
        userselected: {
            type: Object,
            default: null
        },
        conversations: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            message: ''
        }
    },
    methods: {
        send(e) {
            e.preventDefault()
            if (this.message == '') {
                return;
            }
            this.$emit('send', this.message)
            this.message = ''
        },

        scrollToBottom() {
            setTimeout(() => {
                this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
            }, 50)
        }
    },
    watch: {
        userselected(userselected) {
            this.scrollToBottom()
        },
        conversations(conversations) {
            this.scrollToBottom()
        }
    },
    mounted() {
        
    }
}
</script>

<style lang="scss" scoped>

    .message-box{
        width: 100%;
        display: inline-block;

        &:first-child{
            padding-top: 15px;
        }

        .message-received,
        .message-sent{
            width: 40%;
            display: flex;

            .v-avatar img{
                border: 5px double #f5f5f5;
            }

            .message{
                padding: 8px 12px;
                border-radius: 3px !important;
                background-color: #f5f5f5;
                position: relative;
            }
        }
        .message-received{
            float: left;

            .v-avatar{
                margin-right: 15px;
            }

            .message{
                box-shadow: 1px 1px 2px rgba(51, 51, 51, 0.40);
                &::before{
                    position: absolute;
                    content: "";
                    left: -10px;
                    width: 0;
                    height: 0;
                    border-top: 10px solid transparent;
                    border-bottom: 10px solid transparent;
                    border-right: 10px solid whitesmoke;
                }
            }
        }    
        .message-sent{
            float: right;
            text-align: right;
            flex-direction: row-reverse;

            .v-avatar{
                margin-left: 15px;
            }
            .message{ 
                box-shadow: -1px 1px 2px rgba(51, 51, 51, 0.40);
                &::before {
                    position: absolute;
                    content: "";
                    right: -10px;
                    width: 0;
                    height: 0;
                    border-top: 10px solid transparent;
                    border-bottom: 10px solid transparent;
                    border-left: 10px solid whitesmoke;
                }
            }
        }
    }

    h1.pa-custom{
        padding-top: 19px;
        padding-bottom: 20px;
        padding-left: 24px;
        padding-right: 24px;
    }

</style>


