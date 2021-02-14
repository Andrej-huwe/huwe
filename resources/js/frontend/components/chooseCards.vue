<template>
  <div id="app" class="container text-center">
    <div>
      <div>
        <b-card-group deck>
          <b-card
              img-src= http://huwe.test/images/quiz_correct.jpg?f2381b0037263ece8eff761b8027da68
              img-alt="Image"
              img-top
              tag="article"
              style="max-width: 30rem;"
              class="mb-3"
          >
            <b-button class="next-page" href="/words" variant="primary">Slovička</b-button>
          </b-card>
          <b-card
              img-src= https://huwe.test/images/quiz_correct.jpg?f2381b0037263ece8eff761b8027da68
              img-alt="Image"
              img-top
              tag="article"
              style="max-width: 30rem;"
              class="mb-3"
          >
            <b-button class="next-page" href="/sentences" variant="primary">Vety</b-button>
          </b-card>

          <b-card
              img-src= https://huwe.test/images/quiz_correct.jpg?f2381b0037263ece8eff761b8027da68
              img-alt="Image"
              img-top
              tag="article"
              style="max-width: 30rem;"
              class="mb-3"
          >
            <b-button class="next-page" href="/grammar" variant="primary">Gramatika</b-button>
          </b-card>
        </b-card-group>
      </div>
    </div>
  </div>
</template>
<script>
export default  {
  data() {
    return {
      imageCorrect: require('../../../img/quiz_correct.jpg'),
    }
  },
}
</script>
<style scoped>
.next-page {
  background-color: #fff;
  border-color: #fff;
  color: #000;
  font-family: 'Poppins', sans-serif;
  font-size: 1.5rem;
}
.card-img-top {
  border-radius: 25px;
}
.card {
  border: none;
}
h1 {
  margin: 2% 0;
}
</style>
