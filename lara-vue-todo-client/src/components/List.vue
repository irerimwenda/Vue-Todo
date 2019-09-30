<template>
  <div id="todo-list" class="container">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <h1 class="text-center">TODO List App</h1>

        <form v-on:submit.prevent="addNewTask">
          <label for="tasknameinput">Task Name</label>
          <input type="text" v-model="taskname" id="tasknameinput" class="form-control" placeholder="Add New Task">

          <button v-if="this.isEdit == false" type="submit" class="btn btn-success btn-block mt-3">Submit</button>
          <button v-else type="button" v-on:click="updateTask()" class="btn btn-primary btn-block mt-3">Update</button>
        </form>

        <table class="table">
          <tr v-for="(todo) in todos" v-bind:key="todo.id" v-bind:title="todo.title">
            <td class="text-left">{{todo.title}}</td>
            <td class="text-right">
              <button v-on:click="editTask(todo.title, todo.id)" class="btn btn-info">Edit</button>
              <button v-on:click="deleteTask(todo.id)" class="btn btn-danger">Delete</button>
            </td>
          </tr>
        </table>

      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      todos: [],
      id: '',
      taskname: '',
      isEdit: false
    }
  },
  mounted() {
    this.getTasks()
  },
  methods: {
    getTasks() {
      //axios.get('/api/tasks').then(
      axios({method: 'GET', url: '/api/tasks'}).then(
        response => {
          console.log(response.data)
          this.todos = response.data
        },
        error => {
          console.log(error)
        }
      )
    },
    addNewTask() {
      axios.post('/api/task', {title: this.taskname}).then(
        response => {
          this.taskname = ''
          this.getTasks()
          console.log(response)
        }
      ).catch(error => {
        console.log(error)
      })
    },
    editTask(title, id) {
      this.id = id
      this.taskname = title
      this.isEdit = true
    },
    updateTask() {
      //axios.put('/api/task/${this.id}',
      axios.put('/api/task/' + this.id,
      {title: this.taskname})
      .then(response => {
        this.taskname = ''
        this.isEdit = false
        this.getTasks()
        console.log(response)
      })
      .catch(error => {
        console.log(error)
      })
    },
    deleteTask(id) {
      //axios.delete('/api/task/${id}')
      axios.delete('/api/task/' + id)
      .then(response => {
        this.taskname = ''
        this.getTasks()
        console.log(response)
      })
      .catch(error => {
        console.log(error)
      })
    }
  }
}
</script>