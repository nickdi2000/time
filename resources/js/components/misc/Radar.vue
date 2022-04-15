<template>
<div class="flexit">
<div class="circle">
  <div class="tr"></div>
</div>
</div>
</template>

<script>
export default {}
</script>
<style scoped>
.flexit{
  display:flex;
  flex-direction:row;
  justify-content: center;
}
.circle {
  width: 100px;
  height: 100px;
  background: #003a34;
  position:relative;
  border-radius: 50%;
  overflow: hidden;
  border: 6px solid #fff;
  box-shadow: 0 0 1px rgba(0, 0, 0, .7),
    inset 0 0 1px rgba(0, 0, 0, .7),
    0 4px 4px rgba(0, 0, 0, .3),
    inset 0px 0px 0px 29px rgba(0, 58, 52, 1),
    inset 0px 0px 0px 30px rgba(50, 120, 80, 1),
    inset 0px 0px 0px 59px rgba(0, 58, 52, 1),
    inset 0px 0px 0px 60px rgba(50, 120, 80, 1),
    inset 0px 0px 0px 89px rgba(0, 58, 52, 1),
    inset 0px 0px 0px 90px rgba(50, 120, 80, 1);
}
.tr {
  width: 100px;
  height: 100px;
  position: relative;
  animation: rt 3s infinite linear;
  border-radius: 50%;
  overflow: hidden;
}
.tr:after {
  content: '';
  width: 50%;
  height: 50%;
  top: 0px;
  background: linear-gradient(-90deg, rgba(0,58,52,.5) 0%,rgba(0,0,0,0) 100%),
  linear-gradient(to bottom, rgba(0,244,0,1) 0%,rgba(0,58,52,0) 100%);
  transform:rotate(90deg);
  position: absolute;
  border-top: 1px solid #29eb2b;
}

@keyframes rt {
  from {
    transform:rotate(0deg);
  }
  to {
    transform:rotate(360deg);
  }
}

</style>
