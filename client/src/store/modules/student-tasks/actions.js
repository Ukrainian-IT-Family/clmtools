import * as actions from './types/actions';
import * as mutations from './types/mutations';
import ApiRequestService from '@/services/request-service/ApiRequestService';
import { SET_LOADING } from '@/store/mutationTypes';

export default {
    [actions.GET_TASK]: async (
        { commit },
        { lecture_id }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const data = await ApiRequestService.get('/task', {
                lecture_id: lecture_id
            });

            commit(mutations.SET_TASK, {
                task: data.data
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },
    [actions.POST_ANSWER]: async (
        { commit },
        { task_id, answer }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            await ApiRequestService.post('/answer', {
                task_id: task_id,
                answer: answer
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (errorMsg) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(errorMsg);
        }
    },
    [actions.GET_ANSWER_INFO]: async (
        { commit },
        { task_id }
    ) => {
        commit(SET_LOADING, true, { root: true });
        try {
            const data = await ApiRequestService.get('/answer-info', {
                task_id: task_id
            });

            commit(mutations.SET_ANSWER_INFO, {
                answer: data.data
            });
            commit(SET_LOADING, false, { root: true });

            return Promise.resolve();
        } catch (error) {
            commit(SET_LOADING, false, { root: true });

            return Promise.reject(error);
        }
    },
    [actions.GET_TASKS]: async (
        { commit },
        { user_id }
    ) => {
        try {
            const data = await ApiRequestService.get('/task-list', {
                user_id: user_id
            });

            commit(mutations.SET_TASKS, {
                tasks: data.data
            });

            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    },
    [actions.GET_SINGLE_TASK]: async (
        { commit },
        { task_id }
    ) => {
        try {
            const data = await ApiRequestService.get('/task-wo-lecture', {
                task_id: task_id
            });

            commit(mutations.SET_TASK, {
                task: data.data
            });

            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    },
};
