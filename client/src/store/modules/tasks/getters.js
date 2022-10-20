import * as types from './types/getters';

export default {
  [types.GET_ALL_TASKS]: state => state.tasks,
  [types.GET_TASK]: state => state.task
};
