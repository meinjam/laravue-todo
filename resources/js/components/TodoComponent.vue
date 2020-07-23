<template>
    <div v-loading.fullscreen.lock="fullscreenLoading">
        <form @submit.prevent="createTodo">
            <div class="input-group mb-3 w-100">
                <input
                    type="text"
                    class="form-control form-control-lg"
                    v-model="data.todo"
                />
                <div class="input-group-append">
                    <button class="btn btn-outline-success" type="submit">
                        Add Todo
                    </button>
                </div>
            </div>
        </form>

        <div class="w-100">
            <div
                v-for="(todo, i) in todos"
                :key="i"
                class="w-100 d-flex align-items-center p-3 bg-white border-bottom rounded"
            >
                <span class="mr-2">
                    <svg
                        @click="toggleTodo(todo, i)"
                        v-if="!todo.completed"
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-circle"
                        width="23"
                        height="23"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="#FF9800"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <circle cx="12" cy="12" r="9" />
                    </svg>
                    <svg
                        @click="toggleTodo(todo, i)"
                        v-if="todo.completed"
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-circle-check"
                        width="23"
                        height="23"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="#4CAF50"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <circle cx="12" cy="12" r="9" />
                        <path d="M9 12l2 2l4 -4" />
                    </svg>
                </span>

                <span class="todofont" :class="{ completde: todo.completed }">
                    {{ todo.todo }}
                </span>

                <span class="ml-auto">
                    <svg
                        @click="editTodo(todo, i)"
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-edit"
                        width="25"
                        height="25"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="#FF9800"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <path
                            d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"
                        />
                        <path
                            d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"
                        />
                        <line x1="16" y1="5" x2="19" y2="8" />
                    </svg>

                    <svg
                        @click="deleteTodo(todo, i)"
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-trash"
                        width="25"
                        height="25"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="#F44336"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <line x1="4" y1="7" x2="20" y2="7" />
                        <line x1="10" y1="11" x2="10" y2="17" />
                        <line x1="14" y1="11" x2="14" y2="17" />
                        <path
                            d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"
                        />
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                    </svg>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            data: {
                todo: ""
            },
            todos: [],
            updateTodo: {
                id: "",
                todo: ""
            }
        };
    },
    methods: {
        createTodo() {
            axios
                .post("todo", this.data)
                .then(resp => {
                    this.todos.unshift(resp.data);
                    this.s("Todo added successfully.");
                    this.data.todo = "";
                })
                .catch(e => {
                    this.$message.error(e.response.data.errors.todo[0]);
                    // this.e(e.response.data.errors.todo[0]);
                });
        },
        toggleTodo(todo, i) {
            todo.completed = !todo.completed;
            if (todo.completed == true) {
                axios.post("markcomplete", todo);
            }
            if (todo.completed == false) {
                axios.post("markincomplete", todo);
            }
        },
        editTodo(todo, i) {
            console.log(todo.id);
            this.$prompt("Enter todo name", "Edit todo", {
                confirmButtonText: "OK",
                cancelButtonText: "Cancel",
                inputValue: todo.todo
            }).then(({ value }) => {
                this.updateTodo.id = todo.id;
                this.updateTodo.todo = value;
                axios.post("edit_todo", this.updateTodo).then(resp => {
                    this.s("Todo has been updated successfully!");
                    this.todos[i].todo = value;
                });
            });
        },
        deleteTodo(todo, i) {
            this.$confirm("Are you sure?", "Warning", {
                confirmButtonText: "OK",
                cancelButtonText: "Cancel",
                type: "error",
                center: true
            }).then(() => {
                axios
                    .post("delete_todo", todo)
                    .then(resp => {
                        this.s("Todo has been deleted successfully!");
                        this.todos.splice(i, 1);
                    })
                    .catch(e => {
                        this.swr();
                    });
            });
        }
    },
    mounted() {
        axios
            .get("todo")
            .then(resp => {
                this.todos = resp.data;
            })
            .catch(e => {
                this.e("Something went wrong for loading todos.");
            });
        // this.fullscreenLoading = false;
        this.$loading().close();
    },
    beforeCreate() {
        // this.fullscreenLoading = true;
        const loading = this.$loading({
            lock: true,
            text: "Loading, please wait",
            spinner: "el-icon-loading",
            background: "rgba(0, 0, 0, 0.7)"
        });
    }
};
</script>

<style scoped>
svg {
    cursor: pointer;
}
.todofont {
    font-size: 1rem;
    color: #000;
}
.completde {
    text-decoration: line-through;
}
</style>
