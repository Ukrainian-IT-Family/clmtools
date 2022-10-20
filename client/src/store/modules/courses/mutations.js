import * as mutations from './types/mutations';

export default {
  [mutations.SET_COURSES]: (state, courses) => {
    state.courses = courses.courses;
  },

  [mutations.SET_COURSE]: (state, data) => {
    if (state.courses) {
      let key = Object.keys(state.courses).find(key => state.courses[key].id === parseInt(data.course_id));
      state.course = state.courses[key];
    }
  },

  [mutations.EDIT_COURSE]: (state, data) => {
    if (state.courses) {
      let key = Object.keys(state.courses).find(key => state.courses[key].id === data.data.id);
      state.courses[key] = data.data;
    }
  },

  [mutations.DELETE_COURSE]: (state, course_id) => {
    if (state.courses) {
      let key = Object.keys(state.courses).find(key => state.courses[key].id === course_id);
      state.courses.splice(key, 1);
    }
  },

    [mutations.CLEAR_COURSES]: (state) => {
        state.courses = null;
    },

    [mutations.ADD_COURSE]: (state, course) => {
      if (state.courses) {
        state.courses = [course.course, ...state.courses];
      }
    },
};
