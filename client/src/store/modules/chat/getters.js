import * as types from './types/getters';

export default {
    [types.GET_MESSAGES]: state => state.messages,
    [types.GET_CHAT]: state => state.chat,
};
