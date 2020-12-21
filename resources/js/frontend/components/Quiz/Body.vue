<template>
  <b-row>
    <b-col col class="character-area" :style="inlineStyleArea">
      <b-img v-bind:src="imageBg" fluid-grow></b-img>
      <div class="character" :style="inlineStyle"></div>
      <div id="tooltip-button-show-event" class="character-message">.</div>
      <b-tooltip class="character-tooltip" placement="bottom" ref="tooltip" target="tooltip-button-show-event" :title=changeText>
      </b-tooltip>
    </b-col>
    <b-col col sm="12" lg="7" class="quiz-area">
      <quiz-header
          :numTotal="numTotal"
      ></quiz-header>
      <b-container  class="bv-example-row">
        <b-row><b-col>
          <quiz-questions
              v-if="questions.length"
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
              :checkRespoData="checkRespoData"
          ></quiz-questions>
        </b-col>
        </b-row>
      </b-container>
    </b-col>

    <transition name="fade">
      <div v-if="showModal && showModalPete()" v-on:click="showModal = !showModal" class="modalForPete">
        <div role="dialog" aria-labelledby="bv-modal-example___BV_modal_title_"
             class="modal fade show" aria-modal="true" style="display: block;">
          <div class="modal-dialog">
            <span tabindex="0"></span>
            <div tabindex="-1" class="modal-content">
              <div class="modal-body">
                <div class="d-block text-center">
                  <b-tooltip class="modalTooltip" show
                             boundary-padding="25px"
                             placement="topleft"
                             positioning="left"
                             target="tooltip-button-2">Nevzdávaj sa!!</b-tooltip>
                  <b-img class="modalCharacter"
                         id="tooltip-button-2"
                         v-b-tooltip.focus.left
                         :style="charaCorrectStyle"
                         src="https://huwe.test/images/respo-chara-correct.png?caec35523b37c9b45d7a9f0c0d47744d"></b-img>
                </div>
              </div><!----></div><span tabindex="0"></span>
          </div>
        </div>
      </div>
    </transition>

    <transition name="fade">
      <div v-if="showModal && showModalRespo()"  class="modalForRespo">
        <div role="dialog" aria-labelledby="bv-modal-example___BV_modal_title_"
             class="modal fade show" aria-modal="true" style="display: block;">
          <div class="modal-dialog">
            <span tabindex="0"></span>
            <div tabindex="-1" class="modal-content">
              <div class="modal-body">
                <div class="d-block text-center">
                  <h2>Je potrebné si telefón otočiť na šírku</h2>

                </div>
              </div><!----></div><span tabindex="0"></span>
          </div>
        </div>
        <div class="modal-backdrop"></div>
      </div>
    </transition>

  </b-row>
</template>

<script>

export default {
  data() {
    return {
      imageBg: require('../../../../img/quiz-background.png'),
      imageBgfgg: require('../../../../img/quiz/respo-chara-correct.png'),

      //Character Respo Correct
      charaImageCorrect: "https://huwe.test/images/respo-chara-correct.png?caec35523b37c9b45d7a9f0c0d47744d",
      charaCorrectStyle: "margin-left: 56%; margin-top: 16%; transform: rotate(-45deg)",

      //Quiz
      questions: [],
      index: 0,
      numCorrect: 0,
      numTotal: 0,

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

      //Text
      textCorrect: 'Výborne!!!',
      textInCorrect: 'Ajajajaj...',
      textMotivation: 'Makaj viacej!',
      textWrong: null,
      textGood: null,

      //Modal Respo
      showModal: true,
      showRespoModal: false,
      checkRespoData: false,

      //Modal Pete
      showPeteModal: false,


      number: null,
      date: new Date()
    }
  },
  computed: {
    inlineStyleArea(){
      if(this.checkRespoData === true){

      }
    },
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
        return this.textInCorrect
      } else if (this.textGood === this.number) {
        return this.textCorrect
      } else {
        return this.textMotivation
      }
    }
  },
  methods: {
    date_function() {
      var currentDate = new Date()
    },
    showModalPete(){
      if(window.innerWidth < 900 && this.textGood === this.number ){
        this.showPeteModal = true
        return this.showPeteModal
      } else {
        this.showPeteModal = false
        return this.showPeteModal
      }
    },
    checkPete(){

    },
    changeRespo(){
      setInterval(() => this.checkRespo(), 1000)
    },
    showModalRespo(){
      this.changeRespo()
      if(this.checkRespoData === true){
        this.showRespoModal = true
        return this.showRespoModal
      } else {
        this.showRespoModal = false
        return  this.showRespoModal
      }
    },
    checkRespo(){
      if(window.innerWidth < window.innerHeight){
        this.checkRespoData = true
      } else {
        this.checkRespoData = false
      }
    },
    randomNumber() {
      this.number = Math.floor(Math.random() * 9) + 1;
      console.log('číslo prvé: ' + this.number)

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
        console.log('in angry: ' + this.checkAnimation)
      }, this.angryAnimationDelay)
    },
    waitAnimation(currentAnimation, afterAnimation){
      setTimeout(() => {
        this.animation = currentAnimation
        console.log('v sad animation, ak sa zavolá: ' + this.animation)
      }, this.waitAnimationDelay)

      setTimeout(() => {
        this.animation = afterAnimation
        this.numWaitAnimation = false
        if(this.numAnimation === 1){
          this.checkAnimation = true
        } else {
          this.checkAnimation = false
        }
        console.log('in sad: ' + this.checkAnimation)
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
      console.log('in next: ' + this.checkAnimation)
    },
    increment(isCorrect) {
      if (isCorrect) {
        this.numCorrect++
        this.numAnimation--
        this.textGood++
        console.log('správny text: ' + this.textGood)
      }
      this.numTotal++
      this.numAnimation++
      this.animationPressed = false
    },
  },
  mounted() {
    fetch('https://opentdb.com/api.php?amount=10&category=27&type=multiple', {
      method: 'get'
    })
        .then((response) => {
          return response.json()
        })
        .then((jsonData) => {
          this.questions = jsonData.results
        })
    this.date_function()
    this.randomNumber()
  },

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
  width: 68%;
}
.modalForPete .arrow {
  left: 160px !important;
}
@media only screen and (max-width: 900px){
  .character-area {
    display: none;
  }
}
</style>
