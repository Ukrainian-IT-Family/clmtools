import * as actions from './types/actions';
import * as mutations from './types/mutations';
import { SET_LOADING } from '../../mutationTypes';
import requestService from '@/services/request-service/ApiRequestService';
import { UPDATE_PROFILE_IMAGE } from './types/actions';

export default {
  [actions.USER_REGISTER]: async (
    { commit },
    { name, lastName, email, phone, password, passwordConfirmation }
  ) => {
    commit(SET_LOADING, true, { root: true });
    try {
      const data = await requestService.post('/auth/register', {
        name: name,
        last_name: lastName,
        email: email,
        phone: phone,
        password: password,
        password_confirmation: passwordConfirmation
      });

      commit(mutations.ADD_REGISTER_USER, {
        id: data.data.user.id
      });
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },

    [actions.USER_LOGIN]: async ({ commit }, { email, password }) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const data = await requestService.post('/login', {
                email,
                password
            });

            if (data.data.user.email_verified_at === null) {
                commit(mutations.ADD_REGISTER_USER, {
                    id: data.data.user.id
                });
            } else {
                commit(mutations.USER_LOGIN, {
                    accessToken: data.data.access_token,
                    tokenType: data.data.token_type
                });

                commit(mutations.SET_AUTHENTICATED_USER, data.data.user);
            }
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

  [actions.VERIFY_EMAIL]: async ({ commit }, { url }) => {
    commit(SET_LOADING, true, { root: true });
    try {
      await requestService.post('/email/verify/' + url);
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },

  [actions.RESEND_VERIFY_EMAIL]: async ({ commit }, { id }) => {
    commit(SET_LOADING, true, { root: true });
    try {
      await requestService.post('/email/resend/' + id);
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },

  [actions.FORGOT_PASSWORD]: async ({ commit }, { email }) => {
    commit(SET_LOADING, true, { root: true });
    try {
      await requestService.post('/auth/forgot-password', {
        email
      });
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (errorMsg) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(errorMsg);
    }
  },

  [actions.RESET_PASSWORD]: async (
    { commit },
    { token, email, password, passwordConfirmation }
  ) => {
    commit(SET_LOADING, true, { root: true });
    try {
      await requestService.post('/auth/reset', {
        token: token,
        email: email,
        password: password,
        password_confirmation: passwordConfirmation
      });
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (errorMsg) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(errorMsg);
    }
  },

  [actions.CHANGE_PASSWORD]: async (
    { commit },
    { oldPassword, newPassword, newPasswordConfirmation }
  ) => {
    commit(SET_LOADING, true, { root: true });
    try {
      await requestService.post('/auth/change-password', {
        old_password: oldPassword,
        new_password: newPassword,
        new_password_confirmation: newPasswordConfirmation
      });
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (errorMsg) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(errorMsg);
    }
  },

  [actions.USER_LOGOUT]: async ({ commit }) => {
    commit(SET_LOADING, true, { root: true });
    try {
      await requestService.post('/logout');
      commit(mutations.USER_LOGOUT);
      commit('lections/CLEAR_LECTIONS', null, { root: true });
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },

  [actions.GET_AUTHENTICATED_USER]: async ({ commit }) => {
    commit(SET_LOADING, true, { root: true });
    try {
      const user = await requestService.get('/auth/me');
      commit(mutations.SET_AUTHENTICATED_USER, user.data);
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },

  [actions.UPDATE_PROFILE]: async (
    { commit },
    { name, lastName, dateBirth, city, university, graduationYear }
  ) => {
    commit(SET_LOADING, true, { root: true });
    try {
      const data = await requestService.put('/auth/me', {
        name: name,
        last_name: lastName,
        date_birth: dateBirth,
        city: city,
        university: university,
        graduation_year: graduationYear
      });

      commit(mutations.SET_AUTHENTICATED_USER, data.data);
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },

  [actions.UPDATE_PROFILE_IMAGE]: async ({ commit }, image) => {
    commit(SET_LOADING, true, { root: true });
    try {
      const formData = new FormData();
      formData.append('image', image, image.name);
      const data = await requestService.post('/auth/me/image', formData);
      commit(mutations.SET_AUTHENTICATED_USER, data.data);
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  }
};
