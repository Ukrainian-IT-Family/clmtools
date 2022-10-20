import * as actions from './types/actions';
import * as mutations from './types/mutations';
import ApiRequestService from '@/services/request-service/ApiRequestService';
import { SET_LOADING } from '@/store/mutationTypes';

export default {
    [actions.GET_NOTIFICATIONS]: async (
        { commit },
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const data = await ApiRequestService.get('/notifications');

            commit(mutations.SET_NOTIFICATIONS, {
                notifications: data.data
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },
    [actions.DELETE_NOTIFICATIONS]: async (
        { commit },
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            await ApiRequestService.delete('/notifications');

            commit(mutations.SET_NOTIFICATIONS, {
                notifications: []
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },
    [actions.DELETE_NOTIFICATION]: async (
        { commit },
        { notification_id }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            await ApiRequestService.delete('/notification?notification_id=' + notification_id);

            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },
};
