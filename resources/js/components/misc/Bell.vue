
<template>
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19 19">
	<g class="too-big-actually">
		<g class="bell-whole">
			<path class="bell-part bell-part--ringer" d="M9.5,17.5a2,2,0,0,0,2-2h-4A2,2,0,0,0,9.5,17.5Z"/>
			<path class="bell-part bell-part--main" d="M16.23,12.82c-.6-.65-1.73-1.62-1.73-4.82a4.93,4.93,0,0,0-4-4.85V2.5a1,1,0,0,0-2,0v.65A4.94,4.94,0,0,0,4.5,8c0,3.2-1.13,4.17-1.73,4.82a1,1,0,0,0-.27.68,1,1,0,0,0,1,1h12a1,1,0,0,0,1-1A1,1,0,0,0,16.23,12.82Z"/>
		</g>
	</g>
</svg>
</template>

<script>
export default {}
</script>
<style scoped>
html {
	background: "yellow"; /* #313037;*/
	color_: #fb5;
  color: "yellow";
}

svg {
	display: block;
	font-size: 30vw;
	height: 1em;
	left: 50%;
	position: fixed;
  z-index: 99;
	top: 50%;
	transform: translate(-50%, -50%);
	width: 1em;
  color: "yellow";
}

.too-big-actually {
	transform-origin: 9.5px 9.5px;
	transform: scale(0.5);
}

.bell-whole {
	animation: ring 20s linear infinite;
	transform-origin: 9.5px 2.4781px;
}

.bell-part {
	fill: currentColor;
}

.bell-part--ringer {
	animation: ding 20s linear infinite;
}

@keyframes ring {

	0% {
		transform: rotate(0deg);
	}

	1.5% {
		transform: rotate(30deg);
	}

	2.5% {
		transform: rotate(-25deg);
	}

	3.75% {
		transform: rotate(20deg);
	}

	5.15% {
		transform: rotate(-10deg);
	}

	6.65% {
		transform: rotate(5deg);
	}

	8.0% {
		transform: rotate(-2deg);
	}

	10.0% {
		transform: rotate(0deg);
	}

	100% {
		transform: rotate(0deg);
	}

}

@keyframes ding {

	0% {
		transform: translateX(0);
	}

	1.2% {
		transform: translateX(4px);
	}

	1.5% {
		transform: translateX(4px);
	}

	2.3% {
		transform: translateX(-4px);
	}

	2.5% {
		transform: translateX(-4px);
	}

	3.55% {
		transform: translateX(4px);
	}

	3.75% {
		transform: translateX(4px);
	}

	5.45% {
		transform: translateX(-3px);
	}

	7.15% {
		transform: translateX(2px);
	}

	9.0% {
		transform: translateX(-1px);
	}

	11.0% {
		transform: translateX(0);
	}

	100% {
		transform: rotate(0deg);
	}

}
</style>
