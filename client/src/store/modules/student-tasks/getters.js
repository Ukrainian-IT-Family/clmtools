import * as types from './types/getters';

export default {
    [types.GET_TASK]: state => state.task,
    [types.GET_ANSWER_INFO]: state => state.answer,
    [types.GET_TASKS]: state => state.tasks,
    [types.GET_SINGLE_TASK]: state => state.task,
};
