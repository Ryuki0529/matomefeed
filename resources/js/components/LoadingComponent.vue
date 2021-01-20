<template>
  <div>
    <div id="loading-screen" :class="{ show: is_show }">
      <span><vue-loaders name="ball-scale-ripple-multiple" color="white" scale="2"></vue-loaders></span>
    </div>
  </div>
</template>

<style scoped>
#loading-screen {
  position: fixed;
  top: 0;
  right: 0;
  width: 100%;
  height: 100%;
  background: rgb(1 1 0 / 71%);
  z-index: 100;
  visibility: hidden;
  opacity: 0;
  transition: all .7s;
}

#loading-screen.show {
  opacity: 1;
  visibility: visible;
}

#loading-screen > span {
  display: block;
  position: absolute;
  top: 50%;
  right: 50%;
  transform: translate(50%, -50%);
}
</style>

<script>
export default {
  props: ["is_show"],
  methods: {
    increment() {
      this.number += 1;
    },
  },
};
</script>