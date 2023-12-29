<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {onMounted, ref} from "vue";
import useTasks from "@/Composable/useTasks.js";

const {task, tasks, fetchTasks, createTask, completeTask, removeTask } = useTasks();

const props = defineProps({
    user: Object
});

onMounted(()=>{
   fetchTasks();
});

const addTask = async () => {
    await createTask(props.user.id);
    fetchTasks();
};

const changeTaskStatus = async (task_id) => {
    await completeTask(task_id);
    fetchTasks();
}

const deleteTask = async (id) => {
    await removeTask(id);
    fetchTasks();
}

</script>


<template>
    <Head title="Tasky Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Manage Tasks</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Task Management Section -->
                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Task List -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">Tasks</h3>
                        <div class="space-y-4">
                            <template v-if="tasks && tasks.length">
                                <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                                    <div v-for="task in tasks" :key="task.id" class="flex justify-between items-center">
                                        <div>
                                            <h4 class="font-semibold text-md text-gray-800 dark:text-gray-200">Task Title: {{ task.title }}</h4>
                                            <p class="text-gray-600 dark:text-gray-400 text-sm">Description: {{ task.description }}</p>
                                            <p class="text-gray-600 dark:text-gray-400 text-sm">Due Date: {{ task.due_date }}</p>
                                            <p class="text-gray-600 dark:text-gray-400 text-sm">Status: {{ task.completed ? 'Completed' : 'Pending' }}</p>
                                        </div>
                                        <div class="flex justify-end">
                                            <button class="text-green-500" @click="changeTaskStatus(task.id)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                                </svg>
                                            </button>
                                            <button class="text-red-500" @click="deleteTask(task.id)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template v-else>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Currently there are no tasks</p>
                            </template>
                        </div>
                    </div>

                    <!-- Add New Task -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">Add New Task</h3>

                        <form @submit.prevent="addTask">
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="title">
                                    Title
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-800 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" placeholder="Task Title" v-model="task.title">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="description">
                                    Description
                                </label>
                                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-800 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="description" placeholder="Task Description" v-model="task.description"></textarea>
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="due_date">
                                    Due Date
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-800 leading-tight focus:outline-none focus:shadow-outline" id="due_date" type="date" v-model="task.due_date">
                            </div>

                            <div class="flex items-center justify-between">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                    Add Task
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
