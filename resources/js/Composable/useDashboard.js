import {ref} from "vue";

export default function useDashboard(){
    const totalTasks = ref(0);
    const completedTasks = ref(0);
    const pendingTasks = ref(0);
    const nearDueTasks = ref([]);

    const fetchStatistics = async () => {
        try {
            const response = await axios.get('/dashboard/statistics');
            totalTasks.value = response.data.totalTasks;
            completedTasks.value = response.data.completedTasks;
            pendingTasks.value = response.data.pendingTasks;
            // Set other statistics as needed
        } catch (error) {
            console.error('Error fetching statistics:', error);
        }
    };

    const fetchNearDueTasks = async () => {
        try {
            const response = await axios.get('/dashboard/tasks/near-due');
            nearDueTasks.value = response.data;
            console.log(nearDueTasks);
        } catch (error) {
            console.error('Error fetching near due tasks:', error);
        }
    };

    return {
        totalTasks,
        completedTasks,
        pendingTasks,
        nearDueTasks,
        fetchStatistics,
        fetchNearDueTasks,
    }
}
