<template>
	<div >
		<h3 v-if="player.name">{{ player.name}} </h3>
    <h3 v-else>{{ player.alias }} </h3>
    <div v-if="player.created_at">
			<b>{{player.created_at | moment("h:mm a") }}</b><br/>
    	<small>{{ timeAgo }}</small>
			<div>
				<div class="mb-2" :title="player.status_id" ><v-chip :color="player.status_id == 1 ? 'primary' : 'secondary'">{{ player.status }}</v-chip></div>
				<div>
					<v-btn @click="$emit('delete-player', player.id)" size="small" color="info">
						<v-icon left>mdi-check</v-icon> Mark Done
					</v-btn>
				</div>
			</div>

		</div>
	</div>
</template>

<script>
import moment from 'moment'

export default {
  name: 'formatted-player',
  props: ['player'],
	computed: {
		timeAgo(){
			return moment(this.player.created_at).fromNow()
		}
	}
}
</script>

<style>
	.gm-style .gm-style-iw-d::-webkit-scrollbar-track,
	.gm-style .gm-style-iw-d::-webkit-scrollbar-track-piece,
	.gm-style .gm-style-iw-c,
	.gm-style .gm-style-iw-t::after {
	  background: #131a26;
	}

</style>
