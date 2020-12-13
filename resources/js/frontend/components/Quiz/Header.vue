<template>
  <div class="container">
    <b-progress :max="max">
      <b-progress-bar class="progress-bar" :value=" numTotal"></b-progress-bar>
    </b-progress>

  </div>
</template>

<script>
export default {
  props: {
    numTotal: Number
  },
  data() {
    return {
      max: 10
    }
  },
}
</script>
<style>
.progress {
  margin-top: 5%;
  height: 1.5rem;
}
.progress-bar {
  background-color: #622161;
}
.header-top-text {
  margin-top: 5%;
}
.name-of-category {
  color: #622161;
}
@media only screen and (max-width: 900px){
  .progress {
    height: 1rem;
  }
}
</style>