<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import useDashboard from "@/Composable/useDashboard.js";
import {onMounted, ref} from "vue";
import TextInput from "@/Components/TextInput.vue";
import Modal from "@/Components/Modal.vue";

const { totalTasks,completedTasks,pendingTasks,fetchStatistics, nearDueTasks, fetchNearDueTasks } = useDashboard()


onMounted(() => {
    fetchStatistics();
    fetchNearDueTasks();
});

</script>

<template>
    <Head title="Tasky Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tasky Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Statistics Section -->
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">Statistics</h3>

                    <!-- Statistics data display -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="statistic-card">
                            <h4>Total Tasks</h4>
                            <p class="font-bold text-3xl">{{ totalTasks }}</p>
                        </div>
                        <div class="statistic-card">
                            <h4>Completed Tasks</h4>
                            <p class="font-bold text-3xl">{{ completedTasks }}</p>
                        </div>
                        <div class="statistic-card">
                            <h4>Pending Tasks</h4>
                            <p class="font-bold text-3xl">{{ pendingTasks }}</p>
                        </div>
                    </div>
                    <div class="my-10">
                        <h4 class="font-semibold text-gray-300">Tasks Near Due Date</h4>
                        <div class="space-y-2">
                            <template v-for="task in nearDueTasks" :key="task.id">
                                <div class="statistic-card my-3">
                                    <p><strong>{{ task.title }}</strong> (Due: {{ task.due_date }})</p>
                                </div>
                            </template>
                            <template v-if="nearDueTasks.length === 0">
                                <p>No tasks are near due date.</p>
                            </template>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped>
    .statistic-card {
        @apply bg-gray-100 dark:bg-gray-700 text-gray-300 p-4 rounded-lg shadow;
    }
</style>

