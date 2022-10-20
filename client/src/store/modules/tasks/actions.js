import * as actions from './types/actions';
import * as mutations from './types/mutations';
import ApiRequestService from '@/services/request-service/ApiRequestService';
import { SET_LOADING } from '@/store/mutationTypes';

export default {
  [actions.GET_TASKS]: async ({ commit }) => {
    commit(SET_LOADING, true, { root: true });
    try {
      const data = await ApiRequestService.get('/tasks');

      commit(mutations.SET_TASKS, {
        tasks: data.data
      });
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },

  [actions.GET_TASK]: async ({ commit }, { task_id }) => {
    commit(SET_LOADING, true, { root: true });
    try {
      const data = await ApiRequestService.get('/tasks/' + task_id);

      commit(mutations.SET_TASK, {
        task: data.data
      });
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },

  [actions.ADD_TASK]: async ({ commit }, task) => {
    commit(SET_LOADING, true, { root: true });
    try {
      const data = await ApiRequestService.post('/tasks', {
        title: task.title,
        description: task.description,
        points: task.points,
        deadline: task.deadline,
        course_id: task.courses,
        lecture_id: task.lecture,
        user_id: task.students
      });

      commit(mutations.ADD_TASK, {
        task: data.data
      });
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },

  [actions.EDIT_TASK]: async ({ commit }, data) => {
    commit(SET_LOADING, true, { root: true });
    try {
      const response = await ApiRequestService.put('/tasks/' + data.task_id, {
        title: data.title,
        description: data.description,
        points: data.points,
        deadline: data.deadline,
        course_id: data.courses,
        lecture_id: data.lecture,
        user_id: data.students
      });

      commit(mutations.EDIT_TASK, {
        data: response.data
      });
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },

  [actions.DELETE_TASK]: async ({ commit }, { task_id }) => {
    commit(SET_LOADING, true, { root: true });
    try {
      await ApiRequestService.delete('/tasks/' + task_id);
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },

    [actions.SET_RATE_TASK]: async ({ commit }, data) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const response = await ApiRequestService.put('/tasks/' + data.task_id + '/rating', {
                user_ids: data.students
            });
            commit(mutations.SET_TASK, {
                task: response.data
            });
            commit(mutations.EDIT_TASK, {
                data: response.data
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

};
