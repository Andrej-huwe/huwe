<template>
  <div class="text-center b-container">
    <h1>Ocenenia</h1>
    <b-row class="awards justify-content-md-center">
    <div v-for="award in badges.data" :key="award.id">

        <b-col v-if="award.userId == idOfUser"
               :style="award.new_award ? colStyleSpecific : ''"
               class="awardsSingle">
          <b-img thumbnail fluid
                 :style="award.new_award ? imgStyleSpecific : ''"
                 :class=" award.status ? statusOld : ''"
                 :src="awardOneImg"></b-img>
          <h4>{{award.name}}</h4>
        </b-col>
      </div>
    </b-row>

    <div class="table-section text-center">
      <div class="container">
        <h1>Tvoje úspechy</h1>
        <table class="table">
          <thead>
          <th scope="col">Celkové skóre</th>
          <th scope="col">Skóre v slovíčkach</th>
          <th scope="col">Skóre vo vetách</th>
          </thead>
          <tbody>
          <tr>
            <td>{{score.total_score}}</td>
            <td>{{score.words_score}}</td>
            <td>{{score.sentences_score}}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

    <transition name="fade">
      <div v-if="modalAward" >
        <div role="dialog" aria-labelledby="bv-modal-example___BV_modal_title_" aria-describedby="bv-modal-example___BV_modal_body_" class="modal fade show" aria-modal="true" style="display: block;">
          <div class="modal-dialog modal-md">
            <span tabindex="0"></span>
            <div tabindex="-1" class="modal-content">
              <header class="modal-header">
                <button v-on:click="modalAward = !modalAward" type="button" aria-label="Close" class="close">×</button>
              </header>
              <div class="modal-body">
                <div class="d-block text-center">
                  <h2>Vyhral si ocenenie <b>{{ newAwardName }}</b></h2>
                  <b-col class="awardsSingle">
                    <b-img thumbnail fluid
                           :class="statusOld"
                           :src=awardOneImg></b-img>
                    <h4>{{ newAwardName }}</h4>
                  </b-col>
                  <h1>Gratulujeme!</h1>
                </div>
              </div></div><span tabindex="0"></span>
          </div>
        </div>
        <div class="modal-backdrop"></div>
      </div>
    </transition>

  </div>
</template>
<script>

export default {
  data() {
    return {

      //Awards Image
      awardOneImg: "https://huwe.test/images/award_0.png?581d15dd551124da1b8d05b888c181c0",
      awardTwoImg: "https://huwe.test/images/award_1.png?37df38faf333d98395b2a43bd569887f",
      awardThreeImg: "https://huwe.test/images/award_2.png?2a6ad27ebabc7f8b15adfdc5c629c3f8",
      awardFourImg: "https://huwe.test/images/award_3.png?b4bc068fe1041679ff38042604b836f1",
      awardFiveImg: "https://huwe.test/images/award_4.png?7fbf4070787a2a7d0794b63fb5c6f816",
      awardSixImg: "https://huwe.test/images/award_5.png?10dfb8da588c143052540b453c7ec947",

      //Data na bezfarebné data
      statusOld: "old",
      idOfUser: this.$userId,
      testScore: null,
      score: [],
      badges: {
        length: [],
        data: [],
        newAward: [],
        name: [],
        id: []
      },
      //Styles
      newAward: true,
      newAwardName: null,
      imgStyleSpecific: "transition: 2s; background: rgb(235,235,235);",
      colStyleSpecific: "transition: 2s; box-shadow: 4px 4px rgb(253, 160, 0);background: rgb(235,235,235); border-radius: 25px;",
      //Modal
      modalAward: false,
    }
  },
  mounted() {
    this.getDataScore()
    this.getDataBadges()
  },
  methods: {
    getDataScore(){
      let index = this.idOfUser
      index--
      axios.get('/api/score').then((res) =>{
        this.score = res.data[index]
      }).catch((error) =>{
        console.log(error)
      })
    },
    getDataBadges(){
      let index = 0
      axios.get('/api/badges').then((res) => {
        this.badges.length = res.data.length
        this.badges.data = res.data
        //Vďaka "for" mi načíta všetky údaje, nie iba posledný
        for(index = 0; index <= this.badges.length; index++){
          this.badges.userId =res.data[index].userId
          this.badges.name = res.data[index].name
          this.badges.newAward = res.data[index].new_award
          this.badges.id = res.data[index].id
          this.setAward( this.badges.newAward, this.badges.name)
          this.updateBadges(this.badges.newAward, this.badges.id)
        }
      }).catch((error) =>{
        console.log(error)
      })
    },
    updateBadges(newAward, id){
      let dataBadges = new FormData();
      dataBadges.append('_method', 'PATCH')
      if(newAward == 1) {
        console.log("data: " + newAward + id)
        dataBadges.append('new_award', 0)
        axios.post('/api/badges/'+ id, dataBadges)
            .catch((error) => {
              this.form.errors.record(error.response.data.errors)
            })
      }

    },
    setAward( newAward, name){

      if(newAward == 1){
        this.modalAward = !this.modalAward
        this.newAwardName = name
      }
    }
  }
}
</script>
<style scoped>
h1 {
  margin: 2% 0;
}
h4 {
  font-weight: 700;
}
.awards {
  margin-bottom: 2%;
}
.img-thumbnail {
  border: none;
}
/* Farebnosť ocenenia */
img{
  -webkit-filter: grayscale(100%);
  filter: grayscale(100%);

}
img.old {
  -webkit-filter: grayscale(0%);
  filter: grayscale(0%);
}
.awardsSingle {
  background: none;
  border-radius: 0px;
  border: none;
  box-shadow: none;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to{
  opacity: 0;
}
.modal-body h2 {
  font-weight: 900;
}
.modal-header {
  border-bottom: none;
}
.modal-content {
  border-radius: 25px;
}
.modal-backdrop {
  opacity: 0.6;
}
.table-section {
  margin-top: 5%;
}
@media only screen and (max-width: 900px){
  .modal-content {
    border-radius: 0;
  }
  .modal-dialog {
    margin: 0;
    max-width: 100%;
  }
  .modal-header {
    padding: 0;
  }
  .modal-body h1 {
    margin: 0;
  }
  .modal-header .close {
    margin: 0rem 2rem -1rem auto;
  }
  .awards {
    width: 75%;
    margin: auto;
  }
  .table {
    margin: auto;
  }
}
</style>