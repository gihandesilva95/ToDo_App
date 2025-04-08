import { shallowMount } from '@vue/test-utils';
import TaskList from '@/components/TaskList.vue';
import axios from 'axios';
import MockAdapter from 'axios-mock-adapter';

describe('TaskList.vue', () => {
  let mock;

  beforeEach(() => {
    // Create a new instance of MockAdapter before each test
    mock = new MockAdapter(axios);
  });

  afterEach(() => {
    // Reset the mock after each test
    mock.restore();
  });

  it('fetches tasks from the API and displays them', async () => {
    // Mock the GET request for tasks
    mock.onGet('http://127.0.0.1:8000/api/tasks').reply(200, [
      { task_id: 1, task_name: 'Test Task 1', description: 'Description 1', status: 'pending' },
      { task_id: 2, task_name: 'Test Task 2', description: 'Description 2', status: 'done' },
    ]);

    // Mount the component
    const wrapper = shallowMount(TaskList);

    
    await wrapper.vm.fetchTasks();
    await flushPromises(); 

    // Check the tasks are rendered correctly
    expect(wrapper.vm.tasks).toEqual([
      { task_id: 1, task_name: 'Test Task 1', description: 'Description 1', status: 'pending' },
      { task_id: 2, task_name: 'Test Task 2', description: 'Description 2', status: 'done' },
    ]);


    const taskCards = wrapper.findAll('.task-card');
    expect(taskCards).toHaveLength(2);
    expect(taskCards.at(0).text()).toContain('Test Task 1');
    expect(taskCards.at(1).text()).toContain('Test Task 2');
  });
});


function flushPromises() {
  return new Promise(resolve => {
    setImmediate(resolve); 
  });
}
