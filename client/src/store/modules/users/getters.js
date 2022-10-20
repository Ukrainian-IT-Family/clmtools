import * as types from './types/getters';

export default {
  [types.GET_STUDENTS]: state => state.students,
    [types.GET_ALL_USERS]: state => state.users,
    [types.GET_ALL_ROLES]: state => state.roles,
};
