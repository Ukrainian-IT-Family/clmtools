import * as mutations from './types/mutations';

export default {
    [mutations.SET_LECTURES]: (state, lecturerChat) => {
        state.lectures = lecturerChat.lectures;
    },
    [mutations.SET_STUDENTS]: (state, lecturerChat) => {
        state.students = lecturerChat.students;
    },
    [mutations.SET_CHAT]: (state, lecturerChat) => {
        state.chat = lecturerChat.chat;
    },
    [mutations.SET_MESSAGES]: (state, lecturerChat) => {
        state.messages = lecturerChat.messages;
    },
};
