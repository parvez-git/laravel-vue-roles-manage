<template>

	<v-app>

		<navbar-component></navbar-component>

		<v-content>

			<v-container>

				<router-view></router-view>

			</v-container>

		</v-content>

	</v-app>

</template>


<script>

	import Navbar from './NavbarComponent'

	export default {
		name: 'Dashboard',
		components: {
			'navbar-component': Navbar
		},
		data() {
			return {

			}
		}
	}
</script>