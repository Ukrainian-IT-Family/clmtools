import * as mutations from './types/mutations';

export default {
  [mutations.SET_NOTIFICATIONS]: (state, notifications) => {
    state.notifications = notifications.notifications;
  },
  [mutations.SET_UNREAD_NOTIFICATIONS_COUNT]: (state, unreadCount) => {
    state.unreadCount = unreadCount.unreadCount;
  },
  [mutations.MARK_NOTIFICATION_READ]: (state, payload) => {
    const notification = state.notifications.find(
      item => item.id === payload.notification_id
    );
    if (!notification || notification.is_read) {
      return;
    }

    notification.is_read = true;
    notification.read_at = payload.read_at || new Date().toISOString();
    state.unreadCount = Math.max(0, state.unreadCount - 1);
  },
  [mutations.MARK_NOTIFICATIONS_READ]: state => {
    state.notifications = state.notifications.map(notification => ({
      ...notification,
      is_read: true,
      read_at: notification.read_at || new Date().toISOString()
    }));
    state.unreadCount = 0;
  },
  [mutations.REMOVE_NOTIFICATION]: (state, payload) => {
    const notification = state.notifications.find(
      item => item.id === payload.notification_id
    );
    if (notification && !notification.is_read) {
      state.unreadCount = Math.max(0, state.unreadCount - 1);
    }

    state.notifications = state.notifications.filter(
      item => item.id !== payload.notification_id
    );
  },
  [mutations.CLEAR_NOTIFICATIONS]: state => {
    state.notifications = [];
    state.unreadCount = 0;
  },
  [mutations.SET_FILTER]: (state, payload) => {
    state.filter = payload.filter;
  },
  [mutations.ADD_NOTIFICATION]: (state, payload) => {
    state.notifications.unshift(payload.notification);
    if (!payload.notification.is_read) {
      state.unreadCount += 1;
    }
  }
};
