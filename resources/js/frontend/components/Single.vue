<template>
  <div v-if="grammarData.length">
    <div v-for="single in grammarData" :key="single.id">
      <div v-if="single.id == idOfSite">
        <h1>{{single.name}}</h1>
        <p>{{single.desc}}</p>
      </div>
    </div>
    <b-button href="/grammar">Spať na gramatiku!</b-button>
  </div>
</template>
<script>
export default {
  data() {
    return {
      idOfSite: window.location.href.split('/').pop(),
      index: this.idOfSite - 1,
      grammarData: []
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