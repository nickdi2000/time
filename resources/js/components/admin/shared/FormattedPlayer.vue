<template>
	<v-content v-if="player">
		<h3 v-if="player.name">{{ player.name}} </h3>
    <h3 v-else>{{ player.alias }} </h3>
    <b>{{player.created_at | moment("h:mm a") }}</b><br/>
    <small>{{ player.created_at | duration('humanize', true) }}</small>
	</v-content>
</template>

<script>
import moment from 'moment'

export default {
  name: 'formatted-player',
  props: ['player'],
}
</script>
