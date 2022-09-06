<template>
    <div class="container text-center">
        <h1 class="text-primary mt-3">My TODO list 👋🏼</h1>
        <div class="row">
            <div class="col-6 text-center m-auto">
                <div class="row">
                    <div class="col-10">
                        <input
                            type="email"
                            class="form-control"
                            id="name"
                            placeholder="Find tasks"
                            v-model="this.searchTask"
                        >
                    </div>
                    <div class="col-2">
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="findTasks()"
                        >
                            Find
                        </button>
                    </div>
                </div>

                <add-task-form />

                <div v-if="tasks.length !== 0">
                    <list-view
                        :tasks="this.tasks"
                        class="text-center"
                    />
                </div>
                <div v-else>
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import AddTaskForm from "./AddTaskForm";
import Pusher from "pusher-js";
import ListView from "./ListView";

var pusher = new Pusher('4f2e607e5ff1634e559b', {
    cluster: 'eu'
});

var channel = pusher.subscribe('Tasks');
export default {
    name: "App",
    components: {ListView, AddTaskForm},

    data: function() {
        return {
            tasks: [],
            searchTask: "",
        };
    },

    methods: {
        getTasks() {
            axios
                .get("api/tasks")
                .then(res => {
                    this.tasks = res.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        findTasks() {
            axios
                .get(`api/tasks/find?search=${this.searchTask}`)
                .then(res => {
                    this.tasks = res.data;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },

    mounted() {
        this.getTasks();
        pusher.subscribe('Tasks')
            .bind('tasks-updated', function(data) {
                if (data['message'] === 'task-updated') {
                    this.getTasks();
                }
            }, this);
    }
}
</script>

<style scoped>
</style>
