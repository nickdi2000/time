<template>
	<div>
		<v-footer style="position: absolute; bottom: 0;width:100%" class="w-100">
			<v-col
				class="text-center"
				cols="12"
			>
				 <small>
					<router-link :to="'/register'">Sign Up</router-link> |
					<router-link :to="'/login'">Login</router-link> |
					<router-link :to="'/info'">About</router-link> |
					<a href="mailto:contact@webfly.io">Contact</a>
				</small>
			</v-col>
		</v-footer>
	</div>
</template>

<script>
export default {
}
</script>
