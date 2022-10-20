import * as types from './types/getters';

export default {
  [types.GET_COURSE]: state => state.course,
  [types.GET_COURSES]: state => state.courses
};
