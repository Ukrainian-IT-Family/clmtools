import * as actions from './types/actions';
import * as mutations from './types/mutations';
import ApiRequestService from '@/services/request-service/ApiRequestService';
import { SET_LOADING } from '@/store/mutationTypes';

export default {
  [actions.GET_COURSES]: async (
    { commit, dispatch }
  ) => {
      commit(SET_LOADING, true, { root: true });
      try {
          const data = await ApiRequestService.get('/courses');

          commit(mutations.SET_COURSES, {
              courses: data.data
          });
          commit(SET_LOADING, false, { root: true });

          return Promise.resolve();
      } catch (error) {
          commit(SET_LOADING, false, { root: true });

          return Promise.reject(error);
      }
  },

    [actions.GET_COURSE]: async (
        { commit },
        { course_id }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const data = await ApiRequestService.get('/courses');

            commit(mutations.SET_COURSES, {
                courses: data.data
            });

            commit(mutations.SET_COURSE, {
                course_id: course_id
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

    [actions.ADD_COURSE]: async (
        { commit },
        data
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            data = await ApiRequestService.post('/courses', {
                title: data.title,
                user_id: data.students,
            });

            commit(mutations.ADD_COURSE, {
                course: data.data
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

    [actions.EDIT_COURSE]: async (
        { commit },
        data
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const response = await ApiRequestService.put('/courses/' + data.course_id, {
                title: data.title,
                user_id: data.students,
            });

            commit(mutations.EDIT_COURSE, {
                data: response.data
            });

            commit(mutations.SET_COURSE, {
                course_id: data.course_id
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

    [actions.DELETE_COURSE]: async (
        { commit },
        { course_id }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            await ApiRequestService.delete('/courses/' + course_id);

            commit(mutations.DELETE_COURSE, course_id);
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

};
