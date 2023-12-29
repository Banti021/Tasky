import {reactive, ref} from "vue";

export default function useTasks(){
    const task = reactive({
        title: '',
        description: '',
        due_date: null
    });
    const tasks = ref({});

    const fetchTasks = async() => {
        try {
            const response = await axios.get('/tasks');
            tasks.value = response.data.data;
        } catch (error) {
            console.error('Error fetching tasks:', error);
        }
    }

    const createTask = async(user_id) => {
        try{
            const response = await axios.post('/tasks', {
                title: task.title,
                description: task.description,
                due_date: task.due_date,
                user_id: user_id,
            });
        } catch (error){
        }
    }

    const completeTask = async(id) => {
        try{
            await axios.post(`/tasks/complete/${id}`);
        }catch(error){
            console.log("Error during removing task. Error: ".error);
        }
    }

    const removeTask = async (id) => {
        try {
            await axios.delete(`/tasks/${id}`);
            await fetchTasks();
        } catch (error) {
            console.error("Error during removing task. Error:", error);
        }
    };


    return {
        task,
        tasks,
        fetchTasks,
        createTask,
        completeTask,
        removeTask,
    }
}
