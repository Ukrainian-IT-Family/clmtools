import * as mutations from './types/mutations';

export default {
  [mutations.SET_STUDENTS]: (state, data) => {
    state.students = data.students;
  },

    [mutations.SET_USERS]: (state, data) => {
        state.users = data.users;
    },

    [mutations.EDIT_USER]: (state, data) => {
      if (state.users) {
        let key = Object.keys(state.users).find(key => state.users[key].id === data.data.id);
        state.users[key] = data.data;
      }
    },

    [mutations.DELETE_USER]: (state, user_id) => {
        if (state.users) {
          let key = Object.keys(state.users).find(key => state.users[key].id === user_id);
          state.users.splice(key, 1);
        }
    },

    [mutations.SET_ROLES]: (state, data) => {
        state.roles = data.roles;
    },
};
