<template>
  <div class="question-box-container">
    <b-jumbotron class="text-center">
      <h1 class="question"
          :style="sizeOfQuestion"
          v-if="hideElements">
        {{ currentQuestion.question }}
      </h1>

      <b-list-group
          horizontal="md"
          v-if="hideElements">
        <b-list-group-item
            v-for="(answer, index) in answers"
            :key="answer"
            @click="selectAnswer(index), submitAnswer(), onOpen()"
            :disabled="answered === true"
            :class="answerClass(index)"
        >
          {{answer}}
        </b-list-group-item>
      </b-list-group>
      <form @submit=" updateData()" action="/home">
        <div class="quiz-button">
          <b-button
              class="next"
              @click="next(),  showHideElements(), onClose()"
              :disabled="answered === false"
              v-if="hideElements"
              href="">Pokračovať</b-button>
          <transition name="bounce" mode="out-in">
            <div class="final-part" v-if="showElements">
              <h1 class="finish-text" v-if="upNumber">Výborne, test ukočený!</h1>
              <h1 class="finish-text" v-if="downNumber">Ešte na sebe musíš veľa pracovať, <br> test ukočený!</h1>
              <h3 class="text-center">Správne: {{ numCorrect  }}/ {{ numTotal }} </h3>
              <button type="submit" class="finish">Pokračovať</button>
            </div>
          </transition>
        </div>
      </form>
    </b-jumbotron>
  </div>
</template>

<script>
import _ from 'lodash'
export default {
  data() {
    return {
      shuffledAnswers: [],
      correctIndex: null,
      answered: false,
      showElements: false,
      upNumber: false,
      downNumber: false,
      hideElements: true,
      numberTest: 100,
      questionSize: "font-size: 1.5rem;",
      //"form" na vkladanie do DB
      form: new Form({
        score: "",
        actualScore: "",
        completedSteps: "",
      }),

      //Awards Data, odosielanie do DB
      awardOne: false,
      awardTwo: false,
      awardThree: false,
      awardFour: false,
      awardFive: false,
      awardSix: false,
      //Id stránky
      idOfSite: window.location.href.split('/').pop(),
      typeOfSite: window.location.href.split('/'),
      nextIdOfSite: null,
      //Get data
      completedSteps: [],
      score: [],
      words_score: [],
      sentences_score: [],
      idOfScore: [],
      idOfUser: this.$userId,
    }
  },
  props: {
    currentQuestion: Object,
    next: Function,
    increment: Function,
    index: Number,
    numCorrect: Number,
    numTotal: Number,
    onClose: Function,
    onOpen: Function,
    checkRespoData: Boolean
  },
  computed: {
    answers() {
      let answers = [...this.currentQuestion.incorrect_answers] // "..." vytvárame kópiu array namiesto odkazovania
      answers.push(this.currentQuestion.correct_answer)
      return answers
    },
    sizeOfQuestion(){
      if(this.checkRespoData === false) {
        return this.questionSize
      }
    }
  },
  watch: {
    currentQuestion: {
      immediate: true, // "immediate" a "handler" nám spustia funkciu "shuffle" hneď po načitání stránky, inakšie by to bolo až po tom ako sa zmení index
      handler() {
        this.selectedIndex = null
        this.answered = false
        this.shuffleAnswers()
      }
    }
  },
  mounted() {
    this.getDataSteps()
    this.changeIdOfSite()
    this.getDataScore()
    console.log("snetences: " + this.score)
  },
  methods: {
    updateData(){
      this.updateDataSteps()
      this.updateDataDisable()
      this.saveData()
      this.updateDataScore()
    },
    saveData(){
      //Vloženie "props" do "form"
      this.form.score = this.numCorrect
      // Je potrebné prepsíať "actualScore", pretože inakšie nefunguje funckia na ukladanie "awards". Zle tam funguje "if" v "updateAwards()
      let data = new FormData()
      //Zapísanie do databázy score + ocenenia
      if(this.awardOne == true){
        data.append('awardOne', 1)
      }
      if(this.awardTwo == true){
        data.append('awardTwo', 1)
      }
      if(this.awardThree == true){
        data.append('awardThree', 1)
      }
      if(this.awardFour == true){
        data.append('awardFour', 1)
      }
      if(this.awardFive == true){
        data.append('awardFive', 1)
      }
      if(this.awardSix == true){
        data.append('awardSix', 1)
      }
      axios.post('/api/quiz', data)
    },
    getDataScore(){
      let index = this.idOfUser
      index--
      //kontrola, či "completed_steps" = 10, ak áno, odošle 10 do tabuľky automaticky
      axios.get('/api/score').then((res) =>{
        this.score = res.data[index].total_score
        this.words_score = res.data[index].words_score
        this.sentences_score = res.data[index].sentences_score
        this.idOfScore = res.data[index].id
      }).catch((error) =>{
        console.log(error)
      })
    },
    updateDataScore(){
      // dáta ukladáme podľa "id" uživateľa
      let id = this.idOfUser
      this.form.score = this.numCorrect
      let newScore = this.form.score + this.score
      let dataScore = new FormData();
      let wordsScore = this.numCorrect + this.words_score
      let sentencesScore = this.numCorrect + this.sentences_score


      dataScore.append('_method', 'PATCH')
      dataScore.append('total_score', newScore)
      if(this.typeOfSite == "words"){
        dataScore.append('words_score', wordsScore)
      }
      if(this.typeOfSite == "sentences"){
        dataScore.append('sentences_score', sentencesScore)
      }
      axios.post('/api/score/'+ id, dataScore)
          .catch((error) => {
            this.form.errors.record(error.response.data.errors)
          })
    },
    getDataSteps(){
      let index = this.idOfSite
      index--
      this.typeOfSite = this.typeOfSite[3]
      if(this.typeOfSite == "words"){
        //kontrola, či "completed_steps" = 10, ak áno, odošle 10 do tabuľky automaticky
        axios.get('/api/words').then((res) =>{
          this.completedSteps = res.data[index].completed_steps
        }).catch((error) =>{
          console.log(error)
        })
      }
      if(this.typeOfSite == "sentences"){
        //kontrola, či "completed_steps" = 10, ak áno, odošle 10 do tabuľky automaticky
        axios.get('/api/sentences').then((res) =>{
          this.completedSteps = res.data[index].completed_steps
        }).catch((error) =>{
          console.log(error)
        })
      }
    },
    updateDataSteps(){
      this.form.completedSteps = this.numCorrect
      let id = this.idOfSite
      let dataSteps = new FormData();


      if(this.typeOfSite == "words"){
        dataSteps.append('_method', 'PATCH')
        if(this.completedSteps < 10){
          dataSteps.append('completed_steps', this.form.completedSteps)
        } else {
          dataSteps.append('completed_steps', 10)
        }
      console.log("completed steps")
        axios.post('/api/words/'+ id, dataSteps)
            .catch((error) => {
              this.form.errors.record(error.response.data.errors)
            })
      }

      if(this.typeOfSite == "sentences"){
        dataSteps.append('_method', 'PATCH')
        if(this.completedSteps < 10){
          dataSteps.append('completed_steps', this.form.completedSteps)
        } else {
          dataSteps.append('completed_steps', 10)
        }
        axios.post('/api/sentences/'+ id, dataSteps)
            .catch((error) => {
              this.form.errors.record(error.response.data.errors)
            })
      }


    },
    changeIdOfSite(){
      //prepísanie "id" stránky = id + 1
      let id = this.idOfSite
      id++
      this.nextIdOfSite = id
    },
    updateDataDisable(){
      let id = this.nextIdOfSite
      let dataTotal = new FormData();

      if(this.typeOfSite == "words"){
        dataTotal.append('_method', 'PATCH')
        if(this.numCorrect == 10){
          dataTotal.append('disable', 1)
        }
        axios.post('/api/words/'+ id, dataTotal)
            .catch((error) => {
              this.form.errors.record(error.response.data.errors)
            })
      }
      if(this.typeOfSite == "sentences"){
        dataTotal.append('_method', 'PATCH')
        if(this.numCorrect == 10){
          dataTotal.append('disable', 1)
        }
        axios.post('/api/sentences/'+ id, dataTotal)
            .catch((error) => {
              this.form.errors.record(error.response.data.errors)
            })
      }
    },
    updateAwardsData(){
      //Prepísanie pri získaní nové ocenenia
      if(this.actualScore === 50 ){
        this.awardOne = !this.awardOne//awardOne = true
        return this.awardOne
      } else if(this.actualScore === 100 ){
        this.awardTwo = !this.awardTwo
        return this.awardTwo
      } else if(this.actualScore === 150 ){
        this.awardThree = !this.awardThree
        return this.awardThree
      } else if(this.actualScore === 200 ){
        this.awardFour = !this.awardFour
        return this.awardFour
      } else if(this.actualScore === 250 ){
        this.awardFive = !this.awardFive
        return this.awardFive
      } else if(this.actualScore === 300 ){
        this.awardSix = !this.awardSix
        return this.awardSix
      }
    },
    selectAnswer(index) {
      this.selectedIndex = index
    },
    submitAnswer() {
      let isCorrect = false
      if(this.selectedIndex === this.correctIndex) {
        isCorrect = true
        this.actualScore++
        this.updateAwardsData()
      }
      this.answered = true
      this.increment(isCorrect)

    },
    shuffleAnswers() {
      let answers = [...this.currentQuestion.incorrect_answers, this.currentQuestion.correct_answer]
      this.shuffledAnswers = _.shuffle(answers) // pracujeme s algoritmom z Lodash
      this.correctIndex = this.shuffledAnswers.indexOf(this.currentQuestion.correct_answer)  // "indexOf" nájde index správnej odpovede
      console.log('correctIndex: ' + this.correctIndex)
    },
    answerClass(index) {
      let answerClass = ''
      if (this.answered && this.correctIndex === index) {
        answerClass = 'correct-list'
      } else if (this.answered && this.selectedIndex === index && this.correctIndex !== index) {
        answerClass = 'incorrect-list'
      }
      return answerClass
    },
    showHideElements(){
      if(this.index === 9) { //originíl '9'
        this.showElements = true
        this.hideElements = false
        if(this.numCorrect >= 5) {
          this.upNumber = true
        } else {
          this.downNumber = true
        }
      }
    }
  }
}
</script>

<style scoped>
.bounce-enter-active {
  animation: bounce-in .5s;
}
.bounce-leave-active {
  animation: bounce-in .5s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}
.question-box-container {
  margin-top: 15px;
}
.jumbotron {
  background-color: white;
}
.question {
  margin-top: 5%;
  min-height: 135px;
}
.list-group {
  margin-bottom: 15px;
  min-height: 139px;
}
.list-group-item {
  width: 24%;
  margin: 5% 0.95%;
  border-radius: 12px;
  border: 3px solid rgba(0,0,0, 0.125);
  font-family: 'Poppins', sans-serif;
  font-weight: 500;
  background-color: #f7f7f7;
}
.list-group-horizontal-md > .list-group-item:first-child,
.list-group-horizontal-md > .list-group-item:last-child{
  border-top-right-radius: 12px;
  border-bottom-left-radius: 12px;
  border-top-left-radius: 12px;
  border-bottom-right-radius: 12px;
}
.list-group-item:hover {
  border: 3px solid #622161;
  cursor: pointer;
}

.list-group-horizontal-md > .list-group-item + .list-group-item,
.list-group-item + .list-group-item{
  border-top-width: 3px;
  border-left-width: 3px;
}
.btn {
  margin: 0 5px;
}
.correct-list {
  background-color: #38c172;
  color: white;
}
.incorrect-list {
  background-color: #bd3231;
  color: white;
}
.correct-button {
  background-color:  #38c172;
}
.incorrect-button {
  background-color: #bd3231;
}
.next,
.finish {
  width: 50%;
  height: 50px;
  border-radius: 12px;
  background-color: #622161;
  font-family: 'Poppins', sans-serif;
  margin-top: 8%;
  color: white;
}
.btn-success {
  border-color: white;
}
.finish-text {
  margin: 10% 0;
}
@media only screen and (max-width: 900px){
  .list-group-item {
    width: 25%;
  }
  .jumbotron {
    padding: 0px;
  }
  .question {
    min-height: 50%;
  }
  .list-group {
    min-height: 0;
    margin-bottom: 0;
  }
  .finish-text {
    font-size: 1.5rem;
  }
  .next {
    margin-top: 3%;
  }
  .finish-text {
    margin: 5% 0;
  }
}
@media only screen and (max-width: 675px){
  .list-group-item {
    width: 100%;
    margin: 0;
  }
}
</style>
