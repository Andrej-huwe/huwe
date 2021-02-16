<template>
  <div>
    test
    <h1>stuska</h1>
    <h1>{{user_id}}</h1>
    <form @submit.prevent="saveData">
      <div class="input-group">
        <h1 >{{this.form.title}}</h1>
        <p v-on:click="addToTest">pridať</p>
        <input type="text" class="form-control form-control-lg" aria-describedby="button-addon2">
        <div class="input-group-append">
          <button class="btn btn-success" type="submit" id="button-addon2">Add</button>
        </div>
      </div>
    </form>
    <div>
      <div v-for="todo in todos" :key="todo.id"  class="w-100 d-flex align-items-center p-3 bg-white border-bottom">
        {{todo.id}}
      </div>
    </div>

  <div class="speech">
    <button id='btnGiveCommand'>Give Command!</button>
    <br><br>
    <span id='message'></span>
    <br><br>

    <input id='chkSteve' type="checkbox"> Hello
    <br>
    <input id='chkTony' type="checkbox"> How are you?
    <br>
    <input id='chkBruce' type="checkbox">  Bla bla bla
    <br>
    <input id='chkNick' type="checkbox"> What's up
  </div>
    <div id="app2">
      <Test v-bind:header="header"/>
      <Test2 v-bind:header="header"/>
    </div>

    <div class="vld-parent">
      <loading :active.sync="isLoading"
               :can-cancel="true"
               :on-cancel="onCancel"
               :color="color"
               :loader="loader"
               :background-color="backgroundColor"
               :is-full-page="fullPage"></loading>

      <label><input type="checkbox" v-model="fullPage">Full page?</label>
      <button @click.prevent="doAjax">fetch Data</button>
    </div>


    <div>
      Select Voice: <select id='voiceList'></select> <br><br>
      <input id='txtInput' /> <br><br>
      <button id='btnSpeak'>Speak!</button>
    </div>
    <h1> {{ timeLeft }} remaining...</h1>
  </div>

</template>

<script>

// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
    export default {
      data() {
        return {
          time: 3, //in seconds
          timer: null,
          imgOne: require('../../../img/index/information.jpg'),
          imgTwo: require('../../../img/index/our-plan.jpg'),
          imgThree: require('../../../img/index/main-pagepsd.jpg'),
          color: '#622161',
          backgroundColor: 'none',
          loader: 'bars',
          isLoading: false,
          fullPage: false,
          header: 'initial header',
          todos: '',
          form: new Form({
            title: 5,
          }),
          test: 1,
          user_id: this.$userId,
        }
      },
      components: {
        Loading
      },
      computed: {
        timeLeft () {
          return `${this.minutes} minutes ${this.seconds} seconds`
        },
        minutes () {
          return String(Math.floor(this.time / 60)).padStart(2, '0')
        },
        seconds () {
          return String(this.time % 60).padStart(2, '0')
        }
      },
      created () {
        this.timer = setInterval(this.decrementOrAlert, 1000)
      },
      methods: {
        decrementOrAlert () {
          if (this.time > 0) {
            this.time--
            return
          }

          console.log("Times up...")
          clearInterval(this.timer)
        },
        doAjax() {
          this.isLoading = true;
          // simulate AJAX
          setTimeout(() => {
            this.isLoading = false
          },2000)
        },
        onCancel() {
          console.log('User cancelled the loader.')
        },
        addToTest(){
          this.form.title++
        },
        toggleTodo(e){
          e.completed = !e.completed
          let data = new FormData();
          data.append('_method', 'PATCH')
          if(e.completed == true){
            data.append('completed', this.test);
          }
          if(e.completed == false){
            data.append('completed', 0);
          }
          axios.post('/api/todo/' + e.id, data)
        },
        getTodos(){
          axios.get('/api/questions').then((res) =>{
            this.todos = res.data
          }).catch((error) =>{
            console.log(error)
          })
        },
        saveData(){
          let data = new FormData()
          data.append('title', this.form.title)
          axios.post('/api/todo', data).then((res) =>{
            this.form.reset()
            this.getTodos()
          })
        },
        speechLoud(){
          var btnSpeak = document.querySelector('#btnSpeak');
          var synth = window.speechSynthesis;
          var voices = [];

          PopulateVoices();
          if(speechSynthesis !== undefined){
            speechSynthesis.onvoiceschanged = PopulateVoices;
          }

          btnSpeak.addEventListener('click', ()=> {
            var toSpeak = new SpeechSynthesisUtterance("My name is Andy, and yours?");
            var selectedVoiceName =  'Google UK English Female';
            voices.forEach((voice)=>{
              if(voice.name === selectedVoiceName){
                toSpeak.voice = voice;
              }
            });
            synth.speak(toSpeak);
          });

          function PopulateVoices(){
            voices = synth.getVoices();
          }
        },
        speech(){
          var message = document.querySelector('#message');

          var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition; // SpeechRecognition pre FireFox, webkitSpeechRecognition pre Chrome
          var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList;

          var grammar = '#JSGF V1.0;' // Typ Gramatiky, ktorú používame

          var recognition = new SpeechRecognition();
          var speechRecognitionList = new SpeechGrammarList();
          speechRecognitionList.addFromString(grammar, 1); //Definovanie gramatiky
          recognition.grammars = speechRecognitionList; // Vloženie gramatiky do rozpoznania
          recognition.lang = 'en-US';
          recognition.interimResults = false; // S kódom pracuje, až keď dohovoríme

          recognition.onresult = function(event) {
            var last = event.results.length - 1;
            var command = event.results[last][0].transcript;
            message.textContent = 'Voice Input: ' + command + '.';

            if(command.toLowerCase() === 'hello'){
              document.querySelector('#chkSteve').checked = true;
            }
            else if (command.toLowerCase() === 'how are you'){
              document.querySelector('#chkTony').checked = true;
            }
            else if (command.toLowerCase() === 'select bruce'){
              document.querySelector('#chkBruce').checked = true;
            }
            else if (command.toLowerCase() === 'select nick'){
              document.querySelector('#chkNick').checked = true;
            }
          };

          recognition.onspeechend = function() {
            recognition.stop();
          };

          recognition.onerror = function(event) {
            message.textContent = 'Error occurred in recognition: ' + event.error;
          }

          document.querySelector('#btnGiveCommand').addEventListener('click', function(){
            recognition.start();

          });
        },
      },
      mounted(){
        this.getTodos()
        this.speech()
        this.speechLoud()
      }
    }
</script>
<style>
.vld-parent {
  width: 50%;
  background-color: black;
  height: 50%;
  margin: auto;
}
</style>
