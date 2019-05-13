<template>
    <div class="settings">

         <h1 class="subheading grey--text text-uppercase">settings</h1>

        <v-container>
            <v-layout row wrap white>

                <v-flex xs12 sm4>
                    <v-card flat>
                        <sidebar-settings></sidebar-settings>
                    </v-card>
                </v-flex>

                <v-flex xs12 sm8>
                    <v-card flat>
                        <router-view :user="user"></router-view>
                    </v-card>
                </v-flex>

            </v-layout>
        </v-container>
    </div>
</template>

<script>

    import Sidebar from './settings/Sidebar'

    export default {
        name: 'settings',
		props: {
			user: {
				type: Object,
				default: null
			}
		},
        components: {
            'sidebar-settings': Sidebar
        },
        data () {
            return {
               
            }
        }
    }
</script>
