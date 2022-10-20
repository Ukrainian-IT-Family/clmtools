import * as actions from './types/actions';
import * as mutations from './types/mutations';
import ApiRequestService from '@/services/request-service/ApiRequestService';
import { SET_LOADING } from '@/store/mutationTypes';

export default {
  [actions.GET_STUDENTS]: async (
    { commit }
  ) => {
      commit(SET_LOADING, true, { root: true });
      try {
          const data = await ApiRequestService.get('/students');

          commit(mutations.SET_STUDENTS, {
              students: data.data
          });
          commit(SET_LOADING, false, { root: true });

          return Promise.resolve();
      } catch (error) {
          commit(SET_LOADING, false, { root: true });

          return Promise.reject(error);
      }
  },

    [actions.GET_USERS]: async (
        { commit }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const data = await ApiRequestService.get('/users');

            commit(mutations.SET_USERS, {
                users: data.data
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

    [actions.EDIT_USER]: async (
        { commit },
        data
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const response = await ApiRequestService.put('/users/' + data.user_id, {
                role: data.role,
            });

            commit(mutations.EDIT_USER, {
                data: response.data
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

    [actions.DELETE_USER]: async (
        { commit },
        { user_id }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            await ApiRequestService.delete('/users/' + user_id);

            commit(mutations.DELETE_USER, user_id);
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

    [actions.GET_ROLES]: async (
        { commit }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const data = await ApiRequestService.get('/roles');

            commit(mutations.SET_ROLES, {
                roles: data.data
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    }
};
