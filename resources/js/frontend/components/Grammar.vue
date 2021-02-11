<template>
  <div>
    <div v-for="grammar in grammarData" :key="grammar.id">
      <b-jumbotron>
        <h1>{{grammar.name}}</h1>
        <p>{{grammar.desc | lengthFilter(10, '...')}}</p>
        <b-button :href="'/grammar/' + grammar.id">Čítať</b-button>
      </b-jumbotron>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      grammarData: []
    }
  },
  mounted() {
    this.getGrammar()
  },
  filters: {
    lengthFilter(text, length, suffix) {
      if (text.length > length) {
        return text.substring(0, length) + suffix;
      } else {
        return text;
      }
    }
  },
    methods: {
      getGrammar() {
        axios.get('/api/grammar').then((res) => {
          this.grammarData = res.data
          console.log(this.grammarData[0].name)
        }).catch((error) => {
          console.log(error)
        })
      }
    }
}
</script>
<style scoped>
  .btn {
    background: #622161;
    border: 1px solid #622161;
    color: white;
  }
  .jumbotron {
    border-radius: 25px;
  }
</style>