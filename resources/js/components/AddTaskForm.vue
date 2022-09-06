<template>
    <div class="mt-3">
        <div class="card">
            <div class="card-body">

                <h2>Add new task</h2>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input
                        type="email"
                        class="form-control"
                        id="name"
                        placeholder="Task title"
                        v-model="task.name"
                    >
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                        class="form-control"
                        id="description"
                        rows="1"
                        placeholder="Task description"
                        v-model="task.description"
                    ></textarea>
                </div>
                <button
                    class="btn btn-primary"
                    @click="addTask()"
                >
                    Add task
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "AddTaskForm.vue",
    data: function() {
        return {
            task: {
                name: "",
                description: "",
            }
        };
    },
    methods: {
        addTask() {
            if (this.task.name === "") {
                return;
            }
            axios
                .post("api/tasks", {
                    name: this.task.name,
                    description: this.task.description
                })
                .then(res => {
                    if (res.status === 201) {
                        this.task.name = "";
                        this.task.description = "";
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};
</script>

<style scoped>
.active {
    color: white;
    background-color: blue;
}
.inactive {
    color: gray;
}
</style>
