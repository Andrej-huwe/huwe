<template>
  <div>
    <transition name="fade">
      <div v-if="showModal && showModalRespo()"  class="modalForRespo">
        <div role="dialog" aria-labelledby="bv-modal-example___BV_modal_title_"
             class="modal fade show" aria-modal="true" style="display: block;">
          <div class="modal-dialog">
            <span tabindex="0"></span>
            <div tabindex="-1" class="modal-content">
              <div class="vertical-center">
                <div class="text-center">
                  <h2>Huwe</h2>
                  <h1>Je potrebné si telefón otočiť na šírku :)</h1>
              </div></div><span tabindex="0"></span>
          </div>
        </div>
        </div>
        <div class="modal-backdrop"></div>
      </div>
    </transition>
  </div>
</template>
<script>
export  default {
  data() {
    return {
      //Modal Respo
      showModal: true,
      showRespoModal: false,
      checkRespoData: false,
    }
  },
  methods: {
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
  }
}
</script>
<style>
.vertical-center {
  min-height: 100%;
  min-height: 100vh;

  display: flex;
  align-items: center;
}
</style>