<template>
    <div class="text-center">
      <h1>{{name}}</h1>
      <div v-for="level in levelData" :key="level.id">
        <div v-if="level.userId == idOfUser">
          <div class="container">
            <div class="row justify-content-md-center">
              <div class="col">
                <radial-progress-bar
                    :diameter="diameter"
                    :completed-steps="level.completed_steps"
                    :total-steps="totalSteps"
                    :innerStrokeColor="innerStrokeColor"
                    :startColor="startColor"
                    :stopColor="stopColor">
                  <div class="avatar-item">
                    <a :disabled="!level.disable"
                       :href="typeOfSite + '/quiz/' + level.id"
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
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
<script>
import RadialProgressBar from 'vue-radial-progress'
export default  {
  data() {
    return {
      typeOfSite: window.location.href.split('/').pop(),
      name: "",
      idOfUser: Vue.prototype.$userId = document.querySelector("meta[name='user_id']").getAttribute('content'),

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
    this.getLevels()
  },
  methods: {
    name(type){

    },
    getLevels(){
      if(this.typeOfSite == "words"){
        axios.get('/api/words').then((res) => {
          this.levelData = res.data
          this.name = "Slovíčka"
        }).catch((error) => {
          console.log(error)
        })
      }
      if(this.typeOfSite == "sentences"){
        axios.get('/api/sentences').then((res) => {
          this.levelData = res.data
          this.name = "Vety"
        }).catch((error) => {
          console.log(error)
        })
      }

    },
  },
  components: {
    RadialProgressBar
  }
}
</script>
<style scoped>
.col {
  margin: 0 50%;
}
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