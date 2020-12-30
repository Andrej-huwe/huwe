<template>
    <div class="text-center">
      <h1>Quiz</h1>
      <b-list-group class="list-group-one-item" :class="openNextLevel()">
        <b-list-group-item class="d-flex align-items-center">
          <div class="levelAvatar">
            <radial-progress-bar
                :diameter="diameter"
                :completed-steps="completedStepsOne"
                :total-steps="totalSteps"
                :innerStrokeColor="innerStrokeColor"
                :startColor="startColor"
                :stopColor="stopColor">
              <div class="avatar-item">
                <a :disabled=" nextLevelOne === false"
                   href="/quiz"
                   target="_self"
                   class="b-avatar avatar badge-secondary rounded-circle"
                   style="width: 6rem; height: 6rem;">
                  <span class="b-avatar-img">
                    <img src="https://huwe.test/images/apple-1.png?d2d5ddb0a77b7f26fb483b76d21795e5"
                         alt="avatar">
                  </span><!----></a>
              </div>
            </radial-progress-bar>
            <h3>{{this.levelOneName}}</h3>
          </div>
        </b-list-group-item>
      </b-list-group>

      <b-list-group class="list-group-two-item">
        <b-list-group-item class="d-flex align-items-center">
          <div class="levelAvatar">
            <radial-progress-bar
                :diameter="diameter"
                :completed-steps="completedStepsTwo"
                :total-steps="totalSteps"
                :innerStrokeColor="innerStrokeColor"
                :startColor="startColor"
                :stopColor="stopColor"
                :animateSpeed="animateSpeed"
                :timingFunc="timingFunc">
              <div class="avatar-item">
                <a  :disabled="nextLevelTwo === false"
                    href="/quiz"
                    target="_self"
                    class="b-avatar avatar badge-secondary rounded-circle"
                    style="width: 6rem; height: 6rem;">
                  <span class="b-avatar-img">
                    <img src="https://huwe.test/images/apple-1.png?d2d5ddb0a77b7f26fb483b76d21795e5"
                         :class="levelTwoFull ? 'blocked' : ''"
                         alt="avatar">
                  </span><!----></a>
              </div>
            </radial-progress-bar>
            <h3>{{this.levelTwoName}}</h3>
          </div>
          <b-avatar class="avatar-middle" :size="this.avatarSize"></b-avatar>
          <div class="levelAvatar">
            <radial-progress-bar
                :diameter="diameter"
                :completed-steps="completedStepsThree"
                :total-steps="totalSteps"
                :innerStrokeColor="innerStrokeColor"
                :startColor="startColor"
                :stopColor="stopColor">
              <div class="avatar-item">
                <a :disabled="nextLevelThree === false"
                   href="/quiz"
                   target="_self"
                   class="b-avatar avatar badge-secondary rounded-circle"
                   style="width: 6rem; height: 6rem;"
                   >
                  <span class="b-avatar-img">
                    <img
                        src="https://huwe.test/images/apple-1.png?d2d5ddb0a77b7f26fb483b76d21795e5"
                        :class="levelThreeFull ? 'blocked' : ''"
                        alt="avatar">
                  </span>
                </a>
              </div>
            </radial-progress-bar>
            <h3>{{this.levelThreeName}}</h3>
          </div>
        </b-list-group-item>
      </b-list-group>
    </div>
</template>
<script>
import RadialProgressBar from 'vue-radial-progress'
export default  {
  data() {
    return {
      //Correct Words
      correctWordsLevelOne: 10,
      correctWordsLevelTwo: 10,
      correctWordsLevelThree: 10,
      //Level Images
      imageOne: require('../../../img/level/apple-1.png'),
      avatarSize: "6rem",
      //Next Level
      nextLevelOne: true,
      nextLevelTwo: false,
      nextLevelThree: false,
      // Level Names
      levelOneName: "Základy",
      levelTwoName: "Pozdravy",
      levelThreeName: "Jedlo",
      //Radial progress bar
      innerStrokeColor: "rgb(235,235,235)",
      stopColor: "rgb(253, 160, 0)",
      startColor: "rgb(252,185,18)",
      animateSpeed: 1000,
      diameter: 120,
      timingFunc: "linear",
      //Radial progress bar Single Level
      totalSteps: 10,
      completedStepsOne: 0,
      completedStepsTwo: 0,
      completedStepsThree: 0,
      //Čierno Biely Level
      levelThreeFull: false,
      levelTwoFull: false,
      scoreLevel: 11,
    }
  },
  methods: {
    openNextLevel() {
      if(this.scoreLevel >= 0 && this.scoreLevel < 10){
        this.levelTwoFull = true
        this.levelThreeFull = true
      } else if (this.scoreLevel >= 10 && this.scoreLevel < 20){
        this.completedStepsOne = 10
        this.nextLevelTwo = true
        this.levelTwoFull = false
        this.levelThreeFull = true
      }
      /*
      if(this.completedStepsOne >= this.correctWordsLevelOne){
        this.nextLevelTwo = true
        this.levelTwoFull = false
      } else {
        this.completedStepsTwo = 0
        this.nextLevelTwo = false
        this.levelTwoFull = true
      }
      if(this.completedStepsTwo >= this.correctWordsLevelTwo ){
        this.nextLevelThree = true
        this.levelThreeFull = false
      } else {
        this.completedStepsThree = 0
        this.nextLevelThree = false
        this.levelThreeFull = true
      }
      */
    }
  },
  components: {
    RadialProgressBar
  }
}
</script>
<style scoped>
.list-group-one-item {
  max-width: 14%;
  margin: auto;
}
.list-group-two-item {
  max-width: 33%;
  margin: auto;
}

.list-group-item {
  border: none;
  margin-bottom: 11%;
}
.avatar-middle {
  background: white;
}
.avatar{
}
.b-avatar-img img {
  border: 7px solid white;
  background: #b0e0e6;
  padding: 9%;
  transition: 2s;
}
.b-avatar-img img.blocked {
  filter: grayscale(100%)
}
.badge-secondary {
  background-color: white;
}
</style>