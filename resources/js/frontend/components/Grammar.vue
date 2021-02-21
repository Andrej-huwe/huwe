<template>
  <div>
    <h1 class="text-center name">{{name}}</h1>
    <div class="container">
      <div v-for="grammar in grammarData" :key="grammar.id">
        <b-jumbotron>
          <h1>{{grammar.name}}</h1>
          <p>{{grammarText | lengthFilter(250, '...')}}</p> <!-- namiesto "grammarText" má tam byť "grammar.desc -->
          <b-button :href="'/grammar/' + grammar.id">Čítať viacej</b-button>
        </b-jumbotron>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      grammarData: [],
      name: "Gramatika",
      grammarText: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus porta est erat, sed tempus tortor tristique a. Proin eu nunc ipsum. Cras tempus vestibulum odio in ullamcorper. Mauris et condimentum erat. Donec pretium quam metus, elementum tincidunt risus placerat sed. Vivamus eros leo, condimentum vitae nulla vitae, malesuada malesuada augue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer elit neque, varius vel purus at, efficitur bibendum ligula. Aliquam interdum arcu nec sagittis volutpat. Duis et iaculis erat. Nulla faucibus feugiat euismod. Ut et orci vel eros maximus interdum.",
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
  .name {
     margin-bottom: 3rem;
  }
</style>