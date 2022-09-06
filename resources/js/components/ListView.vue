<template>
    <div class="mt-4">
        <h4>Tasks:</h4>
        <div class="row"
             v-for="task in tasks"
             :key="task.id"
        >
            <div class="col">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-2">
                                <button
                                    type="button" class="btn btn-outline-info btn-sm"
                                    @click="this.editableTask = task"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                    title="Edit task"
                                >
                                    🖊️
                                </button>
                            </div>

                            <div class="col-8">
                                {{ task.name }}
                            </div>

                            <div class="col-2">
                                <button
                                    type="button" class="btn btn-outline-danger btn-sm"
                                    @click="this.deletableTask = task.id"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"
                                    title="Delete task"
                                >
                                    🗑
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                {{ task.description }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal delete (could be separate to another component)-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deleting task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure to delete a task?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button
                            type="button"
                            class="btn btn-danger"
                            @click="removeTask(this.deletableTask)"
                            data-bs-dismiss="modal">
                            Delete task
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal delete end -->

        <!-- Modal edit (could be separate to another component)-->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Deleting task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure to EDIT a task?
                        <div v-if="this.editableTask">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="name"
                                    placeholder="Task title"
                                    v-model="this.editableTask.name"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea
                                    class="form-control"
                                    id="description"
                                    rows="1"
                                    placeholder="Task description"
                                    v-model="this.editableTask.description"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="editTask(this.editableTask)"
                            data-bs-dismiss="modal">
                            Edit task
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal edit end -->
    </div>

</template>

<script>
import axios from "axios";

export default {
    components: {},
    data: function() {
        return {
            deletableTask: null,
            editableTask: null,
        };
    },

    props: ["tasks"],
    methods: {
        editTask(task) {
            if (this.editableTask.name === "") {
                return;
            }

            axios
                .put(`api/tasks/${task.id}`, {
                    name: task.name,
                    description: task.description
                })
                .then(res => {
                    if (res.status === 200) {
                    }
                })
                .catch(error => {
                    console.log("error from axios put", error);
                });
        },

        removeTask(taskId) {
            axios
                .delete(`api/tasks/${taskId}`)
                .then(res => {
                    if (res.status === 200) {
                        this.$emit("itemchanged");
                    }
                })
                .catch(error => {
                    console.log("error from axios delte ", error);
                });

            this.deletableTask = null;
        }
    }
};
</script>

<style scoped></style>
