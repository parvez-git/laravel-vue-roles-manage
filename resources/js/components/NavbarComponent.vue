<template>
	<nav>
		<v-toolbar flat app>

			<v-toolbar-side-icon @click.stop="mini = !mini"></v-toolbar-side-icon>

			<v-toolbar-title class="text-uppercase grey--text">
				<span class="font-weight-light">Laravel</span>
				<span>Admin</span>
			</v-toolbar-title>

			<v-spacer></v-spacer>

			<v-btn flat @click="signOut">
				<span>Sign Out</span>
				<v-icon right>exit_to_app</v-icon>
			</v-btn>

		</v-toolbar>

		<v-navigation-drawer :mini-variant.sync="mini" v-model="drawer" app stateless>
			<v-toolbar flat class="transparent">
				<v-list class="pa-0">
					<v-list-tile avatar>
						<v-list-tile-avatar>
							<img :src="defaultFile">
						</v-list-tile-avatar>

						<v-list-tile-content>
							<v-list-tile-title>{{ user.name }}</v-list-tile-title>
							<span class="caption grey--text text--lighten-1">{{ user.email }}</span>
						</v-list-tile-content>

						<v-list-tile-action>
							<v-btn icon @click.stop="mini = !mini">
								<v-icon>chevron_left</v-icon>
							</v-btn>
						</v-list-tile-action>
					</v-list-tile>
				</v-list>
			</v-toolbar>

			<v-list class="pt-0" dense>
				<v-divider></v-divider>

				<v-list-tile v-for="item in items" :key="item.title" router-link :to="item.route">
					<v-list-tile-action>
						<v-icon>{{ item.icon }}</v-icon>
					</v-list-tile-action>

					<v-list-tile-content>
						<v-list-tile-title>{{ item.title }}</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
			</v-list>
			
  		</v-navigation-drawer>
	
	</nav>
</template>

<script>
export default {
	props: {
		user: {
			type: Object,
			default: null
		}
	},
    data () {
        return {
            drawer: true,
            items: [
                { title: 'Dashboard', icon: 'dashboard', route: '/home' },
                { title: 'Users', icon: 'people', route: '/users' },
                { title: 'Roles & Permissions', icon: 'how_to_reg', route: '/roles-permissions' },
                { title: 'Chat', icon: 'chat', route: '/chat' },
                { title: 'Settings', icon: 'settings', route: '/settings' },
            ],
			mini: true,

			defaultFile: '/images/profile/' + this.user.profile_picture
        }
	},
	created() {
		eventBus.$on('onUpdateUserProfile', (profile) => {
			this.defaultFile = '/images/profile/' + profile
		})
	},
	methods: {
		signOut() {
			axios.post('logout').then(response => {
				if (response.status === 302 || 401) {
					document.location.href = "/login";
				}
				return;
			}).catch(error => {
				console.log(error);
			});
		}
	},
	mounted() {

	}
}
</script>