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
      <div class="quiz-button">
        <b-button
            class="next"
            @click="next(),  showHideElements(), onClose()"
            :disabled="answered === false"
            v-if="hideElements"
            href="">Pokračovať</b-button>

        <transition name="bounce" mode="out-in">
          <div class="final-part" v-if="showElements">
            <h1 class="finish-text" v-if="upNumber">Výborne, testt ukočený!</h1>
            <h1 class="finish-text" v-if="downNumber">Ešte na sebe musíš veľa pracovať, <br> test ukočený!</h1>
            <h3 class="text-center">Správne: {{ numCorrect  }}/ {{ numTotal }} </h3>
            <b-button class="finish" href="/home">Pokračovať</b-button>
          </div>
        </transition>
      </div>

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
      questionSize: "font-size: 1.5rem;"
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
      let answers = [...this.currentQuestion.incorrect_answers]
      answers.push(this.currentQuestion.correct_answer)
      return answers
    },
    sizeOfQuestion(){
      if(this.checkRespoData === false) {
        console.log("question test")
        return this.questionSize
      }
    }
  },
  watch: {
    currentQuestion: {
      immediate: true,
      handler() {
        this.selectedIndex = null
        this.answered = false
        this.shuffleAnswers()
      }
    }
  },
  methods: {
    selectAnswer(index) {
      this.selectedIndex = index
    },
    submitAnswer() {
      let isCorrect = false
      if(this.selectedIndex === this.correctIndex) {
        isCorrect = true
      }
      this.answered = true
      this.increment(isCorrect)

    },
    shuffleAnswers() {
      let answers = [...this.currentQuestion.incorrect_answers, this.currentQuestion.correct_answer]
      this.shuffledAnswers = _.shuffle(answers)
      this.correctIndex = this.shuffledAnswers.indexOf(this.currentQuestion.correct_answer)
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

      if(this.index === 9) {
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
