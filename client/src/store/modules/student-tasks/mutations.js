import * as mutations from './types/mutations';

export default {
    [mutations.SET_TASK]: (state, task) => {
        state.task = task.task;
    },
    [mutations.SET_ANSWER_INFO]: (state, answer) => {
        state.answer = answer.answer;
    },
    [mutations.SET_TASKS]: (state, tasks) => {
        state.tasks = tasks.tasks;
    },
};
