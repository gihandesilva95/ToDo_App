import { createApp } from 'vue';
import './style.css';
import './task.css';
import TaskList from './components/TaskList.vue';
import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: TaskList },
  ],
});

createApp(TaskList)  // Use TaskList as the root component
  .use(router)
  .mount('#app');
