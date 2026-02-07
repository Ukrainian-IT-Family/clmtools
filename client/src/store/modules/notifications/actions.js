import * as actions from './types/actions';
import * as mutations from './types/mutations';
import ApiRequestService from '@/services/request-service/ApiRequestService';
import { SET_LOADING } from '@/store/mutationTypes';

export default {
  [actions.GET_NOTIFICATIONS]: async ({ commit }) => {
    commit(SET_LOADING, true, { root: true });
    try {
      const data = await ApiRequestService.get('/notifications');

      commit(mutations.SET_NOTIFICATIONS, {
        notifications: data.data
      });
      commit(mutations.SET_UNREAD_NOTIFICATIONS_COUNT, {
        unreadCount: data.data.filter(item => !item.is_read).length
      });
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },
  [actions.DELETE_NOTIFICATIONS]: async ({ commit }) => {
    commit(SET_LOADING, true, { root: true });
    try {
      await ApiRequestService.delete('/notifications');

      commit(mutations.CLEAR_NOTIFICATIONS);
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },
  [actions.DELETE_NOTIFICATION]: async ({ commit }, { notification_id }) => {
    commit(SET_LOADING, true, { root: true });
    try {
      await ApiRequestService.delete(
        '/notification?notification_id=' + notification_id
      );

      commit(mutations.REMOVE_NOTIFICATION, { notification_id });
      commit(SET_LOADING, false, { root: true });

      return Promise.resolve();
    } catch (error) {
      commit(SET_LOADING, false, { root: true });

      return Promise.reject(error);
    }
  },
  [actions.MARK_NOTIFICATION_AS_READ]: async (
    { commit },
    { notification_id }
  ) => {
    try {
      const data = await ApiRequestService.post('/notification/read', {
        notification_id: notification_id
      });

      if (data?.data?.affected > 0) {
        commit(mutations.MARK_NOTIFICATION_READ, {
          notification_id: notification_id
        });
      }

      return Promise.resolve();
    } catch (error) {
      return Promise.reject(error);
    }
  },
  [actions.MARK_NOTIFICATIONS_AS_READ]: async ({ commit }) => {
    try {
      await ApiRequestService.post('/notifications/read-all');
      commit(mutations.MARK_NOTIFICATIONS_READ);

      return Promise.resolve();
    } catch (error) {
      return Promise.reject(error);
    }
  },
  [actions.GET_UNREAD_NOTIFICATIONS_COUNT]: async ({ commit }) => {
    try {
      const data = await ApiRequestService.get('/notifications/unread-count');
      commit(mutations.SET_UNREAD_NOTIFICATIONS_COUNT, {
        unreadCount: data.data.count || 0
      });

      return Promise.resolve();
    } catch (error) {
      return Promise.reject(error);
    }
  },
  [actions.SET_NOTIFICATIONS_FILTER]: ({ commit }, { filter }) => {
    commit(mutations.SET_FILTER, { filter });
  }
};
