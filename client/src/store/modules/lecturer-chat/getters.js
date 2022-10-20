import * as types from './types/getters';

export default {
    [types.GET_LECTURES]: state => state.lectures,
    [types.GET_STUDENTS]: state => state.students,
    [types.GET_CHAT]: state => state.chat,
    [types.GET_MESSAGES]: state => state.messages,
};
