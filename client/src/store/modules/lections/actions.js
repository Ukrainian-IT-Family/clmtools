import * as actions from './types/actions';
import * as mutations from './types/mutations';
import ApiRequestService from '@/services/request-service/ApiRequestService';
import { SET_LOADING } from '@/store/mutationTypes';

export default {
  [actions.GET_LECTIONS]: async ({ commit }, { user_id }) => {
    commit(SET_LOADING, true, { root: true });
    try {
      const data = await ApiRequestService.post('/user-lectures/' + user_id);

      commit(mutations.SET_LECTIONS, {
        lections: data.data
      });
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },

  [actions.GET_LECTION]: async ({ commit }, { lection_id }) => {
    commit(SET_LOADING, true, { root: true });
    try {
      const data = await ApiRequestService.post('/lecture/' + lection_id);

      commit(mutations.SET_LECTION, {
        lection: data.data
      });
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },

    [actions.GET_CREATED_LECTION]: async (
        { commit }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const data = await ApiRequestService.get('/lectures');

            commit(mutations.SET_LECTIONS, {
                lections: data.data
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

    [actions.ADD_LECTION]: async (
        { commit },
        data
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            await ApiRequestService.post('/lectures', {
                title: data.title,
                description: data.description,
                link: data.link,
                course_id: data.courses,
                user_id: data.students,
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

    [actions.EDIT_LECTION]: async (
        { commit },
        data
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const response = await ApiRequestService.put('/lectures/' + data.lection_id, {
                title: data.title,
                description: data.description,
                link: data.link,
                course_id: data.courses,
                user_id: data.students,
            });

            commit(mutations.EDIT_LECTION, {
                data: response.data
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

    [actions.DELETE_LECTION]: async (
        { commit },
        { lection_id }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            await ApiRequestService.delete('/lectures/' + lection_id);
            commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },

};
