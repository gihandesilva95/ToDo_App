<template>
    <div class="title-wrapper">
        <h1 class="app-title"> TO-DO TASK APP</h1>
    </div>

    <div class="task-container">
        <div class="task-form">
            <h2>Add a Task</h2>
            <input v-model="newTask.task_name" placeholder="Title" class="input-field" />
            <textarea v-model="newTask.description" placeholder="Description" class="text-field"></textarea>
            <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
            <button @click="addTask" class="add-btn">Save</button>
        </div>

        <div class="divider"></div>

        <div class="task-list">
            <h2>Task List</h2>
            <div v-for="task in tasks" :key="task.task_id" class="task-card">
                <div class="task-info">
                <h3>{{ task.task_name }}</h3>
                <p>{{ task.description }}</p>
                </div>
                <button @click="markAsDone(task.task_id)" class="done-btn">
                {{ task.status === 'done' ? "✔ Done" : "Done" }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                tasks: [],
                newTask: { task_name: '', description: '', status: 'pending' },
                errorMessage: ''
            };
        },

        methods: {
            fetchTasks() {
                axios.get('http://127.0.0.1:8000/api/tasks').then((res) => (this.tasks = res.data));
            },
            
            addTask() {
                const { task_name, description } = this.newTask;

                if (!task_name.trim() || !description.trim()) {
                    this.errorMessage = "Both title and description are required.";
                    return;
                }

                this.errorMessage = '';
                axios.post('http://127.0.0.1:8000/api/tasks', this.newTask).then(() => {
                    this.newTask.task_name = '';
                    this.newTask.description = '';
                    this.fetchTasks();
                });
            },

            markAsDone(taskId) {
                axios.put(`http://127.0.0.1:8000/api/tasks/${taskId}`, { status: 'done' }).then(this.fetchTasks);
            }
        },
        mounted() {
            this.fetchTasks();
        },
    };
</script>