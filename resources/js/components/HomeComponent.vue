<template>

	<v-app>

		<navbar-component :user="user"></navbar-component>

		<v-content>

			<v-container>

				<router-view :user="user"></router-view>

			</v-container>

		</v-content>

	</v-app>

</template>


<script>

	import Navbar from './NavbarComponent'

	export default {
		name: 'dashboard',
		components: {
			'navbar-component': Navbar
		},
		props: {
			user: {
				type: Object,
				default: null
			}
		},
		data() {
			return {

			}
		},
		mounted() {
			
		}
	}
</script>