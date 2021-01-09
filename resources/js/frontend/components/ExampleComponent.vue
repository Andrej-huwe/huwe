<template>
  <div>
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
        <span class="mr-2">
                <svg v-on:click="toggleTodo(todo)" v-if="todo.completed == false" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFC107" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z"/>
                    <circle cx="12" cy="12" r="9" />
            </svg>
            <svg v-if="todo.completed == true" v-on:click="toggleTodo(todo)" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#4CAF50" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z"/>
            <circle cx="12" cy="12" r="9" />
            <path d="M9 12l2 2l4 -4" />
            </svg>
            </span>

        <div  class="font-weight-bolder"><span>{{todo.title}}</span>


          <div class="ml-auto mr-2 d-flex align-items-center">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
      data() {
        return {
          todos: '',
          form: new Form({
            title: 5,
          }),
          test: 1
        }
      },
      methods: {
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
        }
      },
      mounted(){
        this.getTodos()
      }
    }
</script>
