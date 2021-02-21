<template>
  <div class="container">
    <div v-if="grammarData.length">
      <div v-for="single in grammarData" :key="single.id">
        <div v-if="single.id == idOfSite">
          <h1 class="text-center">{{single.name}}</h1>
          <p>{{grammarText}}</p> <!-- namiesto "grammarText" má byť "single.desc" -->
        </div>
      </div>
      <b-button href="/grammar">Spať na gramatiku!</b-button>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      idOfSite: window.location.href.split('/').pop(),
      index: this.idOfSite - 1,
      grammarData: [],
      grammarText: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus porta est erat, sed tempus tortor tristique a. Proin eu nunc ipsum. Cras tempus vestibulum odio in ullamcorper. Mauris et condimentum erat. Donec pretium quam metus, elementum tincidunt risus placerat sed. Vivamus eros leo, condimentum vitae nulla vitae, malesuada malesuada augue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer elit neque, varius vel purus at, efficitur bibendum ligula. Aliquam interdum arcu nec sagittis volutpat. Duis et iaculis erat. Nulla faucibus feugiat euismod. Ut et orci vel eros maximus interdum.",

    }
  },
  mounted(){
    this.getGrammar()
  },
  methods: {
    getGrammar(){
      axios.get('/api/grammar').then((res) => {
          this.grammarData = res.data
      }).catch((error) => {
        console.log(error)
      })
    }
  },
}
</script>