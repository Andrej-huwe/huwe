<template>
  <b-row>
    <b-col col class="character-area">
      <b-img v-bind:src="imageBg" fluid-grow></b-img>
      <div class="character" :style="inlineStyle"></div>
      <div id="tooltip-button-show-event" class="character-message">.</div>
      <b-tooltip class="character-tooltip" placement="bottom" ref="tooltip" target="tooltip-button-show-event" :title=changeText>
      </b-tooltip>
    </b-col>
    <b-col col sm="12" lg="7" class="quiz-area">
      <quiz-header
          :numTotal="numTotal"
          :school="school"
      ></quiz-header>
      <b-container  class="bv-example-row">
        <b-row><b-col>
          <quiz-school
              v-if="questions &&  questions.length>1 , school"
              :currentQuestion="questions[index]"
              :questions="questions"
              :next="next"
              :prev="prev"
              :increment="increment"
              :index="index"
              :questionIndex="index"
              :numCorrect="numCorrect"
              :numTotal="numTotal"
              :userResponses="userResponses"
              :correctAnswers="correctAnswers">
          </quiz-school>
          <quiz-questions
              v-if="questions &&  questions.length>1, !school"
              :currentQuestion="questions[index]"
              :next="next"
              :increment="increment"
              :index="index"
              :numCorrect="numCorrect"
              :numTotal="numTotal"
              :angry="angry"
              :idle="idle"
              :onClose="onClose"
              :onOpen="onOpen"
              :typeQuestion="typeQuestion">
          </quiz-questions>
        </b-col>
        </b-row>
      </b-container>
    </b-col>

    <transition name="fade">
      <div v-if="PeteModalCorrectDefault && showModalPeteCorrect()"
           v-on:click="PeteModalCorrectDefault = !PeteModalCorrectDefault" class="modalForPete">
        <div role="dialog" aria-labelledby="bv-modal-example___BV_modal_title_"
             class="modal fade show" aria-modal="true" style="display: block;">
          <div class="modal-dialog">
            <span tabindex="0"></span>
            <div tabindex="-1" class="modal-content">
              <div class="modal-body">
                <div class="d-block text-center">
                  <b-row align-v="stretch">
                    <b-col>
                      <h2 class="modalForPeteText">Tvoje scóre doposiaľ je: <br>{{numCorrect}}/10</h2>
                    </b-col>
                    <b-col>
                      <div class="motivationText">
                        <h5>{{textCorrect}}</h5>
                      </div>
                      <b-img class="modalCharacter"
                             id="tooltip-button-1"
                             v-b-tooltip.focus.left
                             :style="charaCorrectStyle"
                             src="https://huwe.test/images/respo-chara-correct.png?caec35523b37c9b45d7a9f0c0d47744d"></b-img>
                    </b-col>
                  </b-row>
                </div>
              </div><!----></div><span tabindex="0"></span>
          </div>
        </div>
      </div>
    </transition>

    <transition name="fade">
      <div v-if="PeteModalInCorrectDefault && showModalPeteInCorrect()"
           v-on:click="PeteModalInCorrectDefault = !PeteModalInCorrectDefault" class="modalForPete">
        <div role="dialog" aria-labelledby="bv-modal-example___BV_modal_title_"
             class="modal fade show" aria-modal="true" style="display: block;">
          <div class="modal-dialog">
            <span tabindex="0"></span>
            <div tabindex="-1" class="modal-content">
              <div class="modal-body">
                <div class="d-block text-center">
                  <b-row align-v="stretch">
                    <b-col>
                      <h2 class="modalForPeteText">Tvoje scóre doposiaľ je: <br>{{numCorrect}}/10</h2>
                    </b-col>
                    <b-col>
                      <div class="motivationText">
                        <h5>{{textMotivation}}</h5>
                      </div>
                      <b-img class="modalCharacter"
                             id="tooltip-button-2"
                             v-b-tooltip.focus.left
                             :style="charaCorrectStyle"
                             aria-describedby="__bv_tooltip_19__ __bv_tooltip_16__"
                             src="https://huwe.test/images/respo-chara-inCorrect.png?6fdd62a151826df5d93d55e95bbee9f3"></b-img>
                    </b-col>
                  </b-row>
                </div>
              </div><!----></div><span tabindex="0"></span>
          </div>
        </div>
      </div>
    </transition>

  </b-row>
</template>

<script>


import { bus } from '../../app'
export default {
  data() {
    return {
      //Quiz
      userResponses: null,
      correctAnswers: null,

      imageBg: "https://huwe.test/images/quiz-background.png?4c8accaf28fac92cf21bc4fa2ca0de57",
      imageBgfgg: require('../../../../img/quiz/respo-chara-correct.png'),
      imageBgfggss: require('../../../../img/quiz/respo-chara-inCorrect.png'),

      //Character Respo Correct
      charaImageCorrect: "https://huwe.test/images/respo-chara-correct.png?caec35523b37c9b45d7a9f0c0d47744d",
      charaCorrectStyle: "margin-top: 20%",
      //Type of site
      typeOfSite: window.location.href.split('/').pop(),
      //Quiz
      questions: null,
      index: 0,
      numCorrect: 0,
      numTotal: 0,

      //School
      school: false,

      //Animation
      stopAnimationDelay: 200,
      angryAnimationDelay: 1440,
      waitAnimationDelay: 5000,
      sadAnimationDelay: 6250,
      angry: 'animation-name: angry',
      idle: 'animation-name: idle',
      sad: 'animation-name: sad',
      currentAnimation: null,
      afterAnimation: null,
      animation: null,
      numAnimation: 0,
      numWaitAnimation: false,
      animationPressed: true,
      checkAnimation: true,
      time: false,

      //Text v Lg
      textWrong: null,
      textGood: null,
      //Text v Sm
      textNumber: null,
      textInCorrect: null,
      textInCorrectOne: 'ÁÁÁÁÁÁÁÁÁÁ!!!',
      textInCorrectTwo: 'Ajajajaj...',
      textInCorrectThree: 'Bla Bla Bla Bla!!!',
      textCorrect:null,
      textCorrectOne: 'Ide ti to skvele!',
      textCorrectTwo: 'To už vieš toľko slovíčok?!',
      textCorrectThree: 'Well done!!',
      textMotivation: null,
      textMotivationOne: 'Makaj viacej!',
      textMotivationTwo: 'Nevzdávaj sa',
      textMotivationThree: 'Nevadí, pokračuj ďalej',
      //NumAnimation v Sm
      smNumAnimation: null,

      //Modal Pete Correct
      showPeteModalCorrect: false,
      PeteModalCorrectDefault: true,
      //Modal Pete inCorrect
      showPeteModalInCorrect: false,
      PeteModalInCorrectDefault: true,
      //Zmena zo Speech-to-text na obyčajný quiz
      typeQuestion: true, //"true" = quiz, "false" = speech

      number: null,
      date: new Date()
    }
  },
  computed: {
    inlineStyle() {
      if (this.numAnimation === 2 && this.checkAnimation === true && this.time === true) {
        this.updateAnimation(this.angry, this.idle)
        return this.animation
      } else if(this.numWaitAnimation === true && this.animationPressed === true && this.checkAnimation === true && this.time === true){
        this.waitAnimation(this.sad, this.idle)
        return this.animation
      } else if (this.numTotal === 10){
        this.animation = this.idle
        return this.animation
      }
      else {
        this.animation = this.idle
        this.timeCheck()
        return this.animation
      }
    },
    changeText() {
      this.textWrong = this.numAnimation
      if(this.textWrong === 2) {
        this.smChangeText()
        return this.textInCorrect
      } else if (this.textGood === this.number) {
        return this.textCorrect
      } else {
        return this.textMotivation
      }
    }
  },
  methods: {
    checkLink(){
      //Nadstavenie quizu či už pre školy alebo pre normálneho uživateľa
      let str = this.typeOfSite.toString();
      let res = str.charAt(0)
      if(res == "!"){
        this.school = true
      } else {
        this.school = false
      }
    },
    date_function() {
      var currentDate = new Date()
    },
    showModalPeteCorrect(){
      if(this.textGood === this.number && window.innerWidth < 900){
        this.showPeteModalCorrect = true
        return this.showPeteModalCorrect
      } else {
        this.showPeteModalCorrect = false
        return this.showPeteModalCorrect
      }
    },
    showModalPeteInCorrect(){
      if(this.smNumAnimation === 2 && window.innerWidth < 900){
        this.showPeteModalInCorrect = true
        return this.showPeteModalInCorrect
      }else if(this.smNumAnimation === 3 && window.innerWidth < 900){
        this.smNumAnimation = 0
        return this.smNumAnimation
      } else  {
        this.showPeteModalInCorrect = false
        return this.showPeteModalInCorrect
      }
    },
    smChangeText(){
      this.textNumber = Math.floor(Math.random() * 3) + 1;
      if(this.textNumber === 1) {
        this.textInCorrect = this.textInCorrectOne
        this.textCorrect = this.textCorrectOne
        this.textMotivation = this.textMotivationOne
      } else if (this.textNumber === 2) {
        this.textInCorrect = this.textInCorrectTwo
        this.textCorrect = this.textCorrectTwo
        this.textMotivation = this.textMotivationTwo
      } else if(this.textNumber === 3) {
        this.textInCorrect = this.textInCorrectThree
        this.textCorrect = this.textCorrectThree
        this.textMotivation = this.textMotivationThree
      }
    },
    randomNumber() {
      this.number = Math.floor(Math.random() * 9) + 1;
    },
    onOpen() {
      this.textWrong = this.numAnimation
      if(this.textWrong === 2) {
        this.$refs.tooltip.$emit('open')
      } else if(this.textGood === this.number) {
        this.$refs.tooltip.$emit('open')
      }
      else {
        this.onClose()
      }
    },
    onClose() {
      this.$refs.tooltip.$emit('close')
    },
    updateAnimation(currentAnimation, afterAnimation){
      setTimeout(() => {
        this.animation = currentAnimation
      }, this.stopAnimationDelay)

      setTimeout(() => {
        this.animation = afterAnimation
        this.numAnimation = 0
        this.checkAnimation = false
      }, this.angryAnimationDelay)
    },
    waitAnimation(currentAnimation, afterAnimation){
      setTimeout(() => {
        this.animation = currentAnimation
      }, this.waitAnimationDelay)

      setTimeout(() => {
        this.animation = afterAnimation
        this.numWaitAnimation = false
        if(this.numAnimation === 1){
          this.checkAnimation = true
        } else {
          this.checkAnimation = false
        }
      }, this.sadAnimationDelay)
    },
    timeCheck(){
      this.date_function()
      if(this.time === false) {
        setTimeout(() => {
          this.time = true
        }, 4000)
      }
    },
    next() {
      this.index++
      this.numWaitAnimation = true
      this.animationPressed = true
      this.checkAnimation = true
      this.time = false

      if(this.numTotal === this.number){
        this.typeQuestion = false

      } else {
        this.typeQuestion = true
      }
    },
    prev(){
      if(this.index > 0){
        this.index--
      }
    },
    increment(isCorrect) { //funkcia na zachytávanie dát pri odpovedi na otázku
      if (isCorrect) {
        this.numCorrect++
        this.numAnimation--
        this.textGood++
      }
      this.numTotal++

      this.numAnimation++
      this.smNumAnimation++
      this.animationPressed = false
    },
  },
  mounted(){
    fetch('https://opentdb.com/api.php?amount=10&category=27&type=multiple', {
      method: 'get'
    })
        .then((response) => {
          return response.json()
        })
        .then((jsonData) => {
          this.questions = jsonData.results
          this.userResponses = Array(jsonData.results.length).fill(null)
          this.correctAnswers = Array(jsonData.results.length).fill("undefined")

        })
    this.date_function()
    this.randomNumber()
    this.smChangeText()
    this.checkLink()
  }

}
</script>
<style >
body {
  background-color: white;
  height: 100%;
}
.py-4 {
  padding-top: 0 !important;
  padding-bottom: 0 !important;
}
h1 {
  font-family: 'Poppins', sans-serif;
}.character {
   background-image: url("https://huwe.test/images/character-animation.png?89c7b6042500dcb8c4a67cb272eccb87");
   position: absolute;
   z-index: 100;
   width: 93%;
   height: 744px;
   margin-top: -744px;
   margin-left: 3px;
   background-size: 11758.5px;
   animation-iteration-count: infinite;
   animation-timing-function: steps(24);
   animation-duration: 1.2s;
 }
.character-message {
  position: absolute;
  z-index: 200;
  margin: -70% 43%;
}
.tooltip .tooltip-inner{
  padding: 14px 55px;
  background: white;
  font-family: 'Poppins', sans-serif;
  color: black;
  border-radius: 12px;
  border: 3px solid #622161;
}
.bs-tooltip-bottom .arrow::before {
  border-bottom-color: #622161;
}
@keyframes idle {
  from { background-position: 0 0; }
  to { background-position: -11782px 0; }
}
@keyframes angry {
  from { background-position: 0 1490px; }
  to { background-position: -11782px 1490px; }
}
@keyframes sad {
  from {
    background-position: 0 743px;
  }
  to {
    background-position: -11782px 742px;
  }
}
.character-area {
  flex: 0 0 495px;
  max-width: 495px;
  margin: auto;
}
.quiz-area {
  margin: auto;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
.modalForRespo .modal-dialog {
  max-width: 96% !important;
  margin: 0% !important;
  height: 100%;
}
.modalForRespo .modal-content {
  height: 100%;
}
.modalForRespo .modal-body {
  margin-top: 50%;
}
.modalForPete .modal-content {
  height: 100%;
  border: none;
}
.modalForPete .modal-dialog {
  max-width: 96%;
  margin: 0%;
  height: 100%;
}
.modalCharacter {
  width: 136%;
}
.modalForPeteText {
  margin-top: 38%;
}
.modalForPete .arrow {
  left: 160px !important;
}
.motivationText {
  width: 100px;
  height: 50px;
  background-color: green;
  position: relative;
}

.motivationText {
  margin-top: 40%;
  width: 49%;
  position: absolute;
  background: #ffffff;
}
.motivationText h5 {
  padding: 10px;
  border: 3px solid #622161;
  border-radius: 11px;
}
.motivationText:after, .motivationText:before {
  left: 98.5%;
  top: 50%;
  border: solid transparent;
  content: "";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
}

.motivationText:after {
  border-color: rgba(255, 255, 255, 0);
  border-left-color: #ffffff;
  border-width: 11px;
  margin-top: -11px;
}
.motivationText:before {
  border-color: rgba(98, 33, 97, 0);
  border-left-color: #622161;
  border-width: 15px;
  margin-top: -15px;
}
@media only screen and (max-width: 900px){
  .character-area {
    display: none;
  }
}
</style>
