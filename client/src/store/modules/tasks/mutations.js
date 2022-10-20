import * as mutations from './types/mutations';

export default {
  [mutations.SET_TASKS]: (state, tasks) => {
    state.tasks = tasks.tasks;
  },

  [mutations.SET_TASK]: (state, task) => {
    state.task = task;
  },

  [mutations.ADD_TASK]: (state, task) => {
    if (state.tasks) {
      state.tasks = [task.task, ...state.tasks];
    }
  },

  [mutations.EDIT_TASK]: (state, data) => {
    if (state.tasks) {
      let key = Object.keys(state.tasks).find(
          key => state.tasks[key].id === data.data.id
      );
      state.tasks[key] = data.data;
    }
  },

  [mutations.DELETE_TASK]: (state, task_id) => {
    if (state.tasks) {
      let key = Object.keys(state.tasks).find(
          key => state.tasks[key].id === task_id
      );
      state.tasks.splice(key, 1);
    }
  },

  [mutations.CLEAR_TASKS]: state => {
    state.tasks = null;
  }
};
