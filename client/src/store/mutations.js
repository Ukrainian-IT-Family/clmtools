import { SET_LOADING, SET_ALERT, SET_ALERT_TEXT } from './mutationTypes';

export default {
    [SET_LOADING]: (state, isLoading = true) => {
        state.isLoading = isLoading;
    },
    [SET_ALERT]: (state, isAlert = true) => {
        state.isAlert = isAlert;
    },
    [SET_ALERT_TEXT]: (state, isAlertText) => {
        state.isAlertText = isAlertText;
    }
};
