<template>
  <div id="app">
    <b-row>
      <b-col col sm="6" col md="4">
        <b-img v-bind:src="imageBg" fluid-grow></b-img>
        <div class="character" :style="inlineStyle"></div>
        <div id="tooltip-button-show-event" class="character-message">.</div>
        <b-tooltip class="character-tooltip" placement="bottom" ref="tooltip" target="tooltip-button-show-event" :title=changeText>
        </b-tooltip>
      </b-col>
      <b-col col sm="6" col md="8">
        <header-vue
            :numTotal="numTotal"
        ></header-vue>
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
            ></quiz-questions>
          </b-col>
          </b-row>
        </b-container>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  data() {
    return {
      imageBg: require('../../../../img/quiz-background.png'),
      angryImg: require('../../../../img/character-animation.png'),
      questions: [],
      index: 0,
      numCorrect: 0,
      numTotal: 0,
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
      textCorrect: 'Výborne!!!',
      textInCorrect: 'Ajajajaj...',
      textMotivation: 'Makaj viacej!',
      textWrong: null,
      textGood: null,


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
<style>
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
</style>
