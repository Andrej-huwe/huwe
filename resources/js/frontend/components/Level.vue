<template>
    <div class="text-center">
      <h1>{{this.testId}}</h1>
      <div v-for="data in testData" :key="data.id">
        <h2 style="color: red">{{data.id + data.actualScore | testFilter(data.id, data.actualScore, testId)}}</h2>
      </div>
      <h1>Quiz</h1>

      <div v-for="level in levelData" :key="level.name">
        <b-list-group class="list-group-one-item"> <!--Ak bude tréba dať 2 bunky  do jedného radu = "list-group-two-item" = donastavovať -->
          <b-list-group-item class="d-flex align-items-center">
            <div class="levelAvatar">
              <radial-progress-bar
                  :diameter="diameter"
                  :completed-steps="level.completed_steps"
                  :total-steps="totalSteps"
                  :innerStrokeColor="innerStrokeColor"
                  :startColor="startColor"
                  :stopColor="stopColor">
                <div class="avatar-item">
                  <a :disabled="!level.disable"
                     href="/quiz"
                     target="_self"
                     class="b-avatar avatar badge-secondary rounded-circle"
                     style="width: 6rem; height: 6rem;">
                  <span class="b-avatar-img">
                    <img src="https://huwe.test/images/apple-1.png?d2d5ddb0a77b7f26fb483b76d21795e5"
                         alt="avatar"
                         :class="!level.disable ? 'blocked' : ''">
                  </span><!----></a>
                </div>
              </radial-progress-bar>
              <h3>{{level.name}}</h3>
            </div>
          </b-list-group-item>
        </b-list-group>
      </div>
    </div>
</template>
<script>
import RadialProgressBar from 'vue-radial-progress'
export default  {
  data() {
    return {
      testId: window.location.href.split('/').pop(),
      testData: [],

      //Data Test na Level
      levelData: [],
      scoreData: [],
      nextLevelDis: false,
      testScore: null,

      //Level Images
      imageOne: require('../../../img/level/apple-1.png'),
      avatarSize: "6rem",
      //Radial progress bar
      innerStrokeColor: "rgb(235,235,235)",
      stopColor: "rgb(253, 160, 0)",
      startColor: "rgb(252,185,18)",
      animateSpeed: 1000,
      diameter: 120,
      //Radial progress bar Single Level
      totalSteps: 10,
    }
  },
  mounted(){
    this.getData()
    this.getLevels()
    this.getScore()
  },
  filters: {
    testFilter(value, id, score, siteId){
      if(id == siteId){
        return score
      } else {
        score = null
        return score
      }
      return score
    },
  },
  methods: {
    // Testovancie Get
    getData(){
      axios.get('/api/quiz').then((res) =>{
        this.testData = res.data
      }).catch((error) =>{
        console.log(error)
      })
    },
    getLevels(){
      axios.get('/api/lesson').then((res) => {
        this.levelData = res.data
      }).catch((error) => {
        console.log(error)
      })
    },
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