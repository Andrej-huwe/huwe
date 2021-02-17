<template>
  <div class="question-box-container">
    <b-jumbotron class="text-center">
      <div>
        <b-form @submit.prevent="toInformation" v-if="showForm">
          <h2>Pre začatie testu musíte vyplniť následujúce údaje:</h2>
          <b-form-group
              label="Meno:"
              label-for="input-1">
            <b-form-input
                v-model="form.name"
                placeholder="Vložte meno"
                required
            ></b-form-input>
          </b-form-group>
          <b-button type="submit" class="finish">Pokračovať</b-button>
        </b-form>
        <div v-if="showInfo">
          <h1>Dôležité informácie</h1>
          <h2>Váš čas na vypracovanie: {{timeLeft}} min</h2>
          <h2>Celkový počet otázok: {{questions.length}}</h2>
          <b-button @click="toQuiz" class="finish">Pokračovať na quiz</b-button>
        </div>
      </div>
      <div v-if="!showForm && !showInfo">
        <h3><b>{{ timeLeft }}</b></h3>
        <h1 class="question"
            v-if="hideElements">
          Otázka č. {{numberQuestion}}: {{ currentQuestion.question }}
        </h1>
        <div>
        </div>
        <b-list-group
            horizontal="md"
            v-if="hideElements">
          <b-list-group-item
              v-for="(answer, index) in answers"
              :key="answer"
              @click="selectAnswer(index, answer), submitAnswer(), showHideElements()"
              :class="{'correct-list': userResponses[questionIndex] == index}"
          >
            {{answer}}
          </b-list-group-item>
        </b-list-group>
        <form @submit=" updateData()" action="/home">
          <div>
            <b-row align-h="between" class="button-group" v-if="hideElements">
              <b-col cols="3">
                <b-button
                    class="button"
                    @click="prev(),  showHideElements(), (shuffleActive = false)"
                    :disabled="index == 0"
                    href="">Spať</b-button>
              </b-col>
              <b-col cols="3">
                <b-button
                    class="button"
                    :class="(userResponses[questionIndex]==null)?'':'is-active'"
                    @click="next(),  showHideElements(), (shuffleActive = true)"
                    :disabled="questionIndex>=questions.length"
                    href="">{{ (userResponses[questionIndex]==null)? 'Preskočiť': 'Ďalšia' }}</b-button>
              </b-col>
            </b-row>
            <transition name="bounce" mode="out-in">
              <div class="final-part" v-if="showElements">
                <h1 class="finish-text">{{formUser.name}}</h1>
                <h1 class="finish-text">Počet správnych odpovedí: {{quizScore}} / {{questions.length}}</h1>
                <h1>Čas ukončenia: {{endQuizTime}}</h1>
                <button type="submit" class="finish">Ukončiť</button>
              </div>
            </transition>
          </div>
        </form>
      </div>
    </b-jumbotron>
  </div>
</template>

<script>
import _ from 'lodash'
import { bus } from '../../app'
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
  data() {
    return {
      //Formulár
      shuffleActive: true,
      formUser: {
        name: '',
      },
      endQuizTime: null,
      startQuizTime: null,
      numberQuestion: null,
      quizScore: 0,
      showForm: true,
      showInfo: false,
      color: '#622161',
      backgroundColor: 'none',
      loader: 'bars',
      isLoading: false,
      fullPage: false,
      //Timer
      time: 10, //v sekudnách
      timer: null,
      timeStart: false,



      shuffledAnswers: [],
      correctIndex: null,
      answered: false,
      showElements: false,
      hideElements: true,
      numberTest: 100,
      //"form" na vkladanie do DB
      form: new Form({
        score: "",
        actualScore: "",
        completedSteps: "",
      }),
      //Quiz

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
      badges: {
        length: [],
        data: [],
        userId: [],
        status: [],
        unlock_at: {},
        id: [],
      },
      //Speech to text
      btnAnswerSpeech: '',
      btnAnswerText: 'Tap to speak'
    }
  },
  components: {
    Loading
  },
  props: {
    questions: Array,
    currentQuestion: Object,
    next: Function,
    prev: Function,
    increment: Function,
    index: Number,
    questionIndex: Number,
    numCorrect: Number,
    numTotal: Number,
    randomNumber: Number,
    typeQuestion: Boolean,
    userResponses: Array,
    correctAnswers: Array,
  },
  computed: {
    timeLeft () {
      return `${this.minutes} : ${this.seconds} `

    },
    minutes () {
      return String(Math.floor(this.time / 60)).padStart(2, '0')
    },
    seconds () {
      return String(this.time % 60).padStart(2, '0')
    },
    answers() {
      let answers = [...this.currentQuestion.incorrect_answers] // "..." vytvárame kópiu array namiesto odkazovania
      answers.push(this.currentQuestion.correct_answer)
      return answers
    },
  },
  watch: {
    currentQuestion: {
      immediate: true, // "immediate" a "handler" nám spustia funkciu "shuffle" hneď po načitání stránky, inakšie by to bolo až po tom ako sa zmení index
      handler() {
        this.selectedIndex = null
        this.selectedAnswer = null
        this.answered = false
        this.numberQuestionMethod()
        this.shuffleAnswers()
      }
    }
  },
  mounted() {
    this.getDataSteps()
    this.changeIdOfSite()
    this.getDataScore()
  },
  created () {
    this.timer = setInterval(this.decrementOrAlert, 1000)
  },
  methods: {
    numberQuestionMethod(){
      this.numberQuestion = this.index
      this.numberQuestion++
      return this.numberQuestion
    },
    //Formulár
    toQuiz(){
      this.timeStart = true
      this.showInfo = false
      this.startQuizTime = new Date()
    },
    toInformation(){
      this.showForm = false
      this.showInfo = true
    },
    decrementOrAlert () {
      if(this.timeStart == true){
        if (this.time > 0) {
          this.time--
          return
        }
        this.endQuiz()
        this.endQuizTime = new Date()
        clearInterval(this.timer)
      }

    },
    updateData(){
      this.updateDataSteps()
      this.updateDataDisable()
      this.updateDataScore()
      this.updateBadges()
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
    //Načítať údaje si môžme až po skončení quizu, nepotrebujem v priebehu quizu s nimi pracovať
    updateBadges(){
      let index = 0
      axios.get('/api/badges').then((res) => {
        this.badges.length = res.data.length
        //Vďaka "for" mi načíta všetky údaje, nie iba posledný
        for(index = 0; index <= this.badges.length; index++){
          this.badges.status = res.data[index].status
          this.badges.unlock_at = res.data[index].unlock_at
          this.badges.userId =res.data[index].userId
          this.badges.id = res.data[index].id
          //Zavoláme si funkciu, aby sme pracovali s "for". Inakšie by nám odoslalo iba jeden údaj, takto nám odošle všetky
          this.setBadges(this.badges.userId, this.badges.id, this.badges.unlock_at)
          this.setBadgesNew(this.badges.userId, this.badges.id, this.badges.unlock_at)
        }
      }).catch((error) =>{
        console.log(error)
      })
    },
    setBadges(userIdDB, id, unlock){
      let newScore = this.form.score + this.score
      let userId = this.idOfUser
      let dataBadges = new FormData()
      //Ak uživateľské ID sa musí rovnať s "userId" v "badges"
      if(userIdDB == userId){
        dataBadges.append('_method', 'PATCH')
        //Ak scóre je väčšie ako "unlock_at"
        if(newScore >= unlock){
          dataBadges.append('status', 1)
        } else {
          dataBadges.append('status', 0)
        }
        dataBadges.append('new_award', 0)
        axios.post('/api/badges/'+ id, dataBadges)
            .catch((error) => {
              this.form.errors.record(error.response.data.errors)
            })
      }
    },
    setBadgesNew(userIdDB, id, unlock){
      let score = this.score
      let count
      let newScore = this.form.score + this.score
      let dataBadges = new FormData()
      dataBadges.append('_method', 'PATCH')
      //skontroluje mi čísla od starého po nové skóre, ak jedno z tých čísel sa rovná "unlock" zapíše mi do "new_award" = 1
      for(count = score ; count <= newScore; count++ ) {
        if(count == unlock) {
          dataBadges.append('new_award', 1)
          axios.post('/api/badges/' + id, dataBadges)
        }
      }
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
        // Ak správne odpovede ako 10 (číže už som urobil na plný počet daný level)
        // a ak moje aktuálne kroky sú menšie ako moje predošlé, uloží mi moje správne odpovede
        if(this.form.completedSteps > this.completedSteps){
          dataSteps.append('completed_steps', this.form.completedSteps)
        } else {
          dataSteps.append('completed_steps', this.completedSteps)
        }
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
      //slúži na ocenenia
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
    selectAnswer(index, answer) {
      this.selectedIndex = index
      this.selectedAnswer = answer
    },

    submitAnswer() {
      this.increment()
      Vue.set(this.userResponses, this.questionIndex, this.selectedIndex);
      console.log("User Responses" + this.userResponses);

    },
    shuffleAnswers() {
      //Po stlačený "spať" aby sa nesputil "shuffle"
      if(this.shuffleActive == true){
        let answers = [...this.currentQuestion.incorrect_answers, this.currentQuestion.correct_answer]
        this.shuffledAnswers = _.shuffle(answers) // pracujeme s algoritmom z Lodash
        this.correctIndex = this.shuffledAnswers.indexOf(this.currentQuestion.correct_answer)  // "indexOf" nájde index správnej odpovede
        Vue.set(this.correctAnswers, this.questionIndex, this.correctIndex);
        console.log('Correct Answers: ' + this.correctAnswers)
      }

    },
    endQuiz(){
      //Vyhodnotenie až po dokončení quizu
      for(let i = 0; i < this.userResponses.length; i++){
        if(this.correctAnswers[i] === this.userResponses[i]){
          this.quizScore++
        }
        console.log("score: " + this.quizScore)
      }
      this.showElements = true
      this.hideElements = false
      return this.quizScore
    },
    showHideElements(){
      let index = this.questionIndex
      index++
      if(index == this.questions.length) {
        clearInterval(this.timer)
        this.endQuizTime = new Date()
        this.endQuiz()
      }
    },
  },
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
.button {
  width: 100%;
  border-radius: 12px;
  border: 2px solid #622161;
  background: none;
  font-family: 'Poppins', sans-serif;
  color: black;
  margin-top: 5%;
}
.button.is-active {
  background: #622161;
  color: white;
  border-color: transparent;
}
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
.btnSpeech {
  margin: 0 auto;
  width: 50%;
  font-size: 1.4rem;
  border-radius: 12px;
  border: 3px solid rgba(0,0,0, 0.125);
  font-weight: 300;
  background-color: #f7f7f7;
  color: #212529;
  font-family: 'Poppins', sans-serif;
}
.btnSpeech:hover {
  border: 3px solid #622161;
  cursor: pointer;
}
#btnSpeak {
  background: none;
  border: none;
  color: #622161;
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
    font-size: 1rem !important;
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
    height: 38px;
  }
  .finish-text {
    margin: 5% 0;
  }
  .btnSpeech {
    width: 80%;
    margin: 2% 10%;
    padding: 5%;
  }
}
@media only screen and (max-width: 675px){
  .list-group-item {
    width: 100%;
    margin: 0;
    padding: 1%;
  }
  .btnSpeech {
    width: 80%;
    margin: 0% 10%;
    padding: 1%;
  }
}
</style>
