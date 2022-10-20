import * as mutations from './types/mutations';

export default {
    [mutations.SET_NOTIFICATIONS]: (state, notifications) => {
        state.notifications = notifications.notifications;
    },
};
