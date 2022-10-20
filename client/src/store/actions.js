import { MAKE_ALERT } from '@/store/actionTypes';
import { SET_ALERT, SET_ALERT_TEXT } from '@/store/mutationTypes';

export default {
    [MAKE_ALERT]: async ({ commit }, text) => {
        commit(SET_ALERT_TEXT, text, { root: true });
        commit(SET_ALERT, true, { root: true });
    }
};
