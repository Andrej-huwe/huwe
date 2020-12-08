<template>
  <div class="text-center b-container">
    <h1>Ocenenie</h1>
    <b-row class="awards">
      <b-col class="awardsSingle"
             :style="awardNewOneMethodOut"
             :class="awardOneFull ? this.statusOutside : ''">
        <b-img thumbnail fluid
               class="awardTest"
               :style="awardNewOneMethodIn"
               :class="awardOneFull ? this.statusInside : ''"
               loading="lazy" @load="awardsMethod"
               :src=this.awardOneImg></b-img>
        <h4>{{this.awardOneName}}</h4>
      </b-col>

      <b-col class="awardsSingle"
             :style="awardNewTwoMethodOut"
             :class="awardTwoFull ? this.statusOutside : ''">
        <b-img thumbnail fluid
               :style="awardNewTwoMethodIn"
               :class="awardTwoFull ? this.statusInside : ''"
               loading="lazy" @load="awardsMethod"
               :src=this.awardTwoImg></b-img>
        <h4>{{this.awardTwoName}}</h4>
      </b-col>

      <b-col class="awardsSingle"
             :style="awardNewThreeMethodOut"
             :class="awardThreeFull ? this.statusOutside : ''">
        <b-img thumbnail fluid
               :style="awardNewThreeMethodIn"
               :class="awardThreeFull ? this.statusInside : ''"
               loading="lazy" @load="awardsMethod"
               :src=this.awardThreeImg></b-img>
        <h4>{{this.awardThreeName}}</h4>
      </b-col>

      <b-col class="awardsSingle"
             :style="awardNewFourMethodOut"
             :class="awardFourFull ? this.statusOutside : ''">
        <b-img thumbnail fluid
               :style="awardNewFourMethodIn"
               :class="awardFourFull ? this.statusInside : ''"
               loading="lazy" @load="awardsMethod"
               :src=this.awardFourImg></b-img>
        <h4>{{this.awardFourName}}</h4>
      </b-col>

      <b-col class="awardsSingle"
             :style="awardNewFiveMethodOut"
             :class="awardFiveFull ? this.statusOutside : ''">
        <b-img thumbnail fluid
               :style="awardNewFiveMethodIn"
               :class="awardFiveFull ? this.statusInside  : ''"
               loading="lazy" @load="awardsMethod"
               :src=this.awardFiveImg ></b-img>
        <h4>{{this.awardFiveName}}</h4>
      </b-col>

      <b-col class="awardsSingle"
             :style="awardNewSixMethodOut"
             :class="awardSixFull ? this.statusOutside : ''">
        <b-img thumbnail fluid
               :style="awardNewSixMethodIn"
               :class="awardSixFull ? this.statusInside  : '' "
               loading="lazy" @load="awardsMethod"
               :src=this.awardSixImg></b-img>
        <h4>{{this.awardSixName}}</h4>
      </b-col>
    </b-row>
      <transition name="fade">
        <div v-if="showModal && showAwardModalMethod()" >
          <div role="dialog" aria-labelledby="bv-modal-example___BV_modal_title_" aria-describedby="bv-modal-example___BV_modal_body_" class="modal fade show" aria-modal="true" style="display: block;">
            <div class="modal-dialog modal-md">
              <span tabindex="0"></span>
              <div tabindex="-1" class="modal-content">
                <header class="modal-header">
                  <button v-on:click="showModal = !showModal" type="button" aria-label="Close" class="close">×</button>
                </header>
                <div class="modal-body">
                  <div class="d-block text-center">
                    <h2>Vyhral si ocenenie <b>{{this.modalAwardName()}}</b></h2>
                    <b-col class="awardsSingle">
                      <b-img thumbnail fluid
                             :style="modalAwardNewInMethod"
                             :class="this.modalAwardImgClass() ? this.statusInside  : '' "
                             loading="lazy" @load="awardsMethod"
                             :src=this.modalAwardImg() ></b-img>
                      <h4>{{this.modalAwardName()}}</h4>
                    </b-col>
                    <h1>Gratulujeme!</h1>
                  </div>
                </div><!----></div><span tabindex="0"></span>
            </div>
          </div>
          <div class="modal-backdrop"></div>
        </div>
      </transition>
  </div>
</template>
<script>
export default  {
  data() {
    return {
      //Awards Data
      awardOneNew: false,
      awardTwoNew: false,
      awardOneFull: false,
      awardTwoFull: false,
      awardThreeFull: false,
      awardFourFull: false,
      awardFiveFull: false,
      awardSixFull: false,
      //Awards Image
      awardOneImg:"https://huwe_final.test/images/award_0.png?581d15dd551124da1b8d05b888c181c0",
      awardTwoImg:"https://huwe_final.test/images/award_1.png?37df38faf333d98395b2a43bd569887f",
      awardThreeImg:"https://huwe_final.test/images/award_2.png?2a6ad27ebabc7f8b15adfdc5c629c3f8",
      awardFourImg:"https://huwe_final.test/images/award_3.png?b4bc068fe1041679ff38042604b836f1",
      awardFiveImg:"https://huwe_final.test/images/award_4.png?7fbf4070787a2a7d0794b63fb5c6f816",
      awardSixImg:"https://huwe_final.test/images/award_5.png?10dfb8da588c143052540b453c7ec947",
      //Awards Name
      awardOneName: "Úroveň 1",
      awardTwoName:"Úroveň 2",
      awardThreeName:"Úroveň 3",
      awardFourName:"Úroveň 4",
      awardFiveName:"Úroveň 5",
      awardSixName:"Úroveň 6",
      //Awards Score
      scoreLevelOne: 50,
      scoreLevelTwo: 100,
      scoreLevelThree: 150,
      scoreLevelFour: 200,
      scoreLevelFive: 250,
      scoreLevelSix: 300,
      //Award Status
      statusInside: null,
      statusOutside: null,
      statusOld: "old",
      //Award Method Inside
      awardNewIn: "transition: 2s; background: rgb(235,235,235);",
      awardOldIn: "transition: 0s;",
      //Award Method Outside
      awardNewOut: "transition: 2s; box-shadow: 4px 4px rgb(253, 160, 0);background: rgb(235,235,235); border-radius: 25px;",
      awardOldOut: "",
      //Modal
      showModal: true,
      showAwardModal: false,
      modalAwardNewIn: "transition: 3s;",
      //Award Actual
      statusOneNew: false,
      statusTwoNew: false,
      statusThreeNew: false,
      statusFourNew: false,
      statusFiveNew: false,
      statusSixNew: false,
      //Score of user
      score: 200,
    }
  },
  computed: {
    modalAwardNewInMethod(){
      this.testTime()
      return this.test
    },
    awardNewOneMethodOut(){
      if(this.statusOneNew === true){
        return this.awardNewOut
      }else {
        return this.awardOldOut;
      }
    },
    awardNewTwoMethodOut(){
      if(this.statusTwoNew === true){
        return this.awardNewOut
      }else {
        return this.awardOldOut;
      }
    },
    awardNewThreeMethodOut(){
      if(this.statusThreeNew === true){
        return this.awardNewOut
      }else {
        return this.awardOldOut;
      }
    },
    awardNewFourMethodOut(){
      if(this.statusFourNew === true){
        return this.awardNewOut
      }else {
        return this.awardOldOut;
      }
    },
    awardNewFiveMethodOut(){
      if(this.statusFiveNew === true){
        return this.awardNewOut
      }else {
        return this.awardOldOut;
      }
    },
    awardNewSixMethodOut(){
      if(this.statusSixNew === true){
        return this.awardNewOut
      }else {
        return this.awardOldOut;
      }
    },
    awardNewOneMethodIn(){
      if(this.statusOneNew === true){
        return this.awardNewIn
      }else {
        return this.awardOldIn;
      }
    },
    awardNewTwoMethodIn(){
      if(this.statusTwoNew === true){
        return this.awardNewIn
      } else {
        return this.awardOldIn
      }
    },
    awardNewThreeMethodIn(){
      if(this.statusThreeNew === true){
        return this.awardNewIn
      } else {
        return this.awardOldIn
      }
    },
    awardNewFourMethodIn(){
      if(this.statusFourNew === true){
        return this.awardNewIn
      } else {
        return this.awardOldIn
      }
    },
    awardNewFiveMethodIn(){
      if(this.statusFiveNew === true){
        return this.awardNewIn
      } else {
        return this.awardOldIn
      }
    },
    awardNewSixMethodIn(){
      if(this.statusSixNew === true){
        return this.awardNewIn
      } else {
        return this.awardOldIn
      }
    },
  },
  methods: {
    testTime(){
      this.test = this.modalAwardNewIn
      // modal dokončiť TimeOut
    },
    modalAwardName(){
      if(this.statusOneNew === true){
        return this.awardOneName
      }else if(this.statusTwoNew === true){
        return this.awardTwoName
      }else if(this.statusThreeNew === true){
        return this.awardThreeName
      }else if(this.statusFourNew === true){
        return this.awardFourName
      }else if(this.statusFiveNew === true){
        return this.awardFiveName
      }else if(this.statusSixNew === true){
        return this.awardSixName
      }

    },
    modalAwardImg(){
      if(this.statusOneNew === true){
        return this.awardOneImg
      }else if(this.statusTwoNew === true){
        return this.awardTwoImg
      }else if(this.statusThreeNew === true){
        return this.awardThreeImg
      }else if(this.statusFourNew === true){
        return this.awardFourImg
      }else if(this.statusFiveNew === true){
        return this.awardFiveImg
      }else if(this.statusSixNew === true){
        return this.awardSixImg
      }
    },
    modalAwardImgClass(){
      if(this.statusOneNew === true){
        return this.awardOneFull
      }else if(this.statusTwoNew === true){
        return this.awardTwoFull
      }else if(this.statusThreeNew === true){
        return this.awardThreeFull
      }else if(this.statusFourNew === true){
        return this.awardFourFull
      }else if(this.statusFiveNew === true){
        return this.awardFiveFull
      }else if(this.statusSixNew === true){
        return this.awardSixFull
      }
    },
    showAwardModalMethod(){
      if(this.statusOneNew === true){
        this.showAwardModal = true
        return this.showAwardModal
      }else if(this.statusTwoNew === true){
        this.showAwardModal = true
        return this.showAwardModal
      } else if(this.statusThreeNew === true){
        this.showAwardModal = true
        return this.showAwardModal
      } else if(this.statusFourNew === true){
        this.showAwardModal = true
        return this.showAwardModal
      } else if(this.statusFiveNew === true){
        this.showAwardModal = true
        return this.showAwardModal
      } else if(this.statusSixNew === true){
        this.showAwardModal = true
        return this.showAwardModal
      }

    },
    awardChangeStatusInside(){
      this.statusInside = this.statusOld
    },
    awardsMethod(){
      if(this.score >= this.scoreLevelOne){
        this.awardOneFull = true
        this.awardChangeStatusInside()
      }
      if(this.score >= this.scoreLevelTwo){
        this.awardTwoFull = true
      }
      if(this.score >= this.scoreLevelThree){
        this.awardThreeFull = true
      }
      if(this.score >= this.scoreLevelFour){
        this.awardFourFull = true
      }
      if(this.score >= this.scoreLevelFive){
        this.awardFiveFull = true
      }
      if(this.score >= this.scoreLevelSix){
        this.awardSixFull = true
      }
    },
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
img{
  -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
  filter: grayscale(100%);

}
img.old {
  -webkit-filter: grayscale(0%); /* Safari 6.0 - 9.0 */
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
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
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
</style>