import * as actions from './types/actions';
import * as mutations from './types/mutations';
import ApiRequestService from '@/services/request-service/ApiRequestService';
import { SET_LOADING } from '../../mutationTypes';

export default {
    [actions.GET_MESSAGES]: async (
        { commit },
        { user_id, lecture_id }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const data = await ApiRequestService.get('/messages', {
                user_id: user_id,
                lecture_id: lecture_id
            });

            commit(mutations.SET_MESSAGES, {
                messages: data.data
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

    [actions.POST_MESSAGE]: async (
        { commit },
        { form_data }
    ) => {
        try {
            await ApiRequestService.post('/message', form_data);

            return Promise.resolve();
        } catch (errorMsg) {
            return Promise.reject(errorMsg);
        }
    },

    [actions.GET_CHAT]: async (
        { commit },
        { user_id, lecture_id }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const data = await ApiRequestService.get('/chat', {
                user_id: user_id,
                lecture_id: lecture_id
            });

            commit(mutations.SET_CHAT, {
                chat: data.data
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

    [actions.POST_CHAT]: async (
        { commit },
        { lecture_id }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const data = await ApiRequestService.post('/chat', {
                lecture_id: lecture_id
            });

            commit(mutations.SET_CHAT, {
                chat: data.data
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (errorMsg) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(errorMsg);
        }
    },
};
