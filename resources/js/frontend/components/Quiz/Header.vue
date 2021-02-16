<template>
  <div class="container">
    <h1 v-if="school">Školský test: {{nameOfTest}}</h1>
    <b-progress v-if="!school" :max="max">
      <b-progress-bar class="progress-bar" :value=" numTotal"></b-progress-bar>
    </b-progress>

  </div>
</template>

<script>
export default {
  props: {
    numTotal: Number,
    school: Boolean
  },
  data() {
    return {
      nameOfTest: 'Teória z informatiky č.7',
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