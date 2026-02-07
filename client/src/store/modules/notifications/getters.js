import * as types from './types/getters';

export default {
  [types.GET_NOTIFICATIONS]: state => state.notifications,
  [types.GET_UNREAD_NOTIFICATIONS_COUNT]: state => state.unreadCount,
  [types.GET_NOTIFICATIONS_FILTER]: state => state.filter,
  [types.GET_FILTERED_NOTIFICATIONS]: state => {
    if (state.filter === 'unread') {
      return state.notifications.filter(notification => !notification.is_read);
    }

    return state.notifications;
  }
};
