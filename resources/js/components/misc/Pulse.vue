
<template>
  <span class="loader">
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>
  </span>
</template>

<script>
export default {}
</script>

<style scoped>

.loader {
  width:100%;
  height:100%;
  display:flex;
  justify-content:center;
  align-items:center;
  position:relative;
}

.circle {
  position:absolute;
  width:0px;
  height:0px;
  border-radius:100%;
  background:rgba(221,25,39,1);
  animation:radar 3s ease-out infinite;
  box-shadow:0px 0px 10px rgba(221,25,39,.5);
/*   box-shadow:0px 0px 10px rgba(0,0,0,.5); */
/*   border:1px solid rgba(255,255,255,.2); */
}

.circle:nth-of-type(1){
  animation-delay:0.2s;
}

.circle:nth-of-type(2){
  animation-delay:0.6s;
}

.circle:nth-of-type(3){
  animation-delay:1s;
}

.circle:nth-of-type(4){
  animation-delay:1.4s;
}

.circle:nth-of-type(5){
  animation-delay:1.8s;
}

@keyframes radar {
  0% {}
  30% {
    width:50px;
    height:50px;
  }
  100% {
    width:50px;
    height:50px;
    opacity:0;
  }
}

</style>
