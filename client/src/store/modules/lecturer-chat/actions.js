import * as actions from './types/actions';
import * as mutations from './types/mutations';
import ApiRequestService from '@/services/request-service/ApiRequestService';
import { SET_LOADING } from '@/store/mutationTypes';

export default {
    [actions.GET_LECTURES]: async (
        { commit },
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const data = await ApiRequestService.get('/lectures');

            commit(mutations.SET_LECTURES, {
                lectures: data.data
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },

    [actions.GET_STUDENTS]: async (
        { commit },
        { lecture_id }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const data = await ApiRequestService.get('/students-by-lecture', {
                lecture_id: lecture_id
            });

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
        { user_id, lecture_id }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const data = await ApiRequestService.post('/lecturer-chat', {
                user_id: user_id,
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
        commit(SET_LOADING, true, { root: true });
        try {
            await ApiRequestService.post('/lecturer-message', form_data);
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (errorMsg) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(errorMsg);
        }
    },
};
