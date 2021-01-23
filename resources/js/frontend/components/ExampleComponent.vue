<template>
  <div>
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
          test: 1,
          user_id: this.$userId,
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
