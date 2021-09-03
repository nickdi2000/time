<template>
	<div>
		<v-footer style="position: absolute; bottom: 0;width:100%" class="w-100">
	    <v-col
	      class="text-center"
	      cols="12"
	    >
	      {{ new Date().getFullYear() }} — {{$app_name}}
				<small>
					<router-link :to="'/register'">Register</router-link> |
					<router-link :to="'/about'">About</router-link> |

				</small>
	    </v-col>
	  </v-footer>
	</div>
</template>

<script>
export default {
}
</script>
