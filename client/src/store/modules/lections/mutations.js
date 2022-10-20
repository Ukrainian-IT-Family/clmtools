import * as mutations from './types/mutations';

export default {
  [mutations.SET_LECTIONS]: (state, lections) => {
    state.lections = lections.lections;
  },

  [mutations.SET_LECTION]: (state, lection) => {
    state.lection = lection;
  },

  [mutations.EDIT_LECTION]: (state, data) => {
    if (state.lections) {
      let key = Object.keys(state.lections).find(
          key => state.lections[key].id === data.data.id
      );
      state.lections[key] = data.data;
    }
  },

  [mutations.DELETE_LECTION]: (state, lection_id) => {
    if (state.lections) {
      let key = Object.keys(state.lections).find(
          key => state.lections[key].id === lection_id
      );
      state.lections.splice(key, 1);
    }
  },

  [mutations.CLEAR_LECTIONS]: state => {
    state.lections = null;
  }
};
