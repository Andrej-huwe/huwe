<template>
  <div>
    <form @submit.prevent="saveData">
      <div class="input-group">
        <input v-model="form.title" type="text" class="form-control form-control-lg" aria-describedby="button-addon2">
        <div class="input-group-append">
          <button class="btn btn-success" type="submit" id="button-addon2">Add</button>
        </div>
      </div>
    </form>
    <div>
      <div v-for="todo in todos" :key="todo.id">{{todo.title}}</div>
    </div>
  </div>
</template>

<script>
    export default {
      data() {
        return {
          todos: '',
          form: new Form({
            title: '',
          })
        }
      },
      methods: {
        getTodos(){
          axios.get('/api/todo').then((res) =>{
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
