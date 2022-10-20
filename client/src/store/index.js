import Vue from 'vue';
import Vuex from 'vuex';
import state from './state';
import mutations from './mutations';
import getters from './getters';
import actions from './actions';
import StatusService from './modules/status-service';
import auth from './modules/auth';
import lections from './modules/lections';
import courses from './modules/courses';
import chat from './modules/chat';
import lecturerChat from './modules/lecturer-chat';
import handbook from './modules/handbook';
import users from './modules/users';
import tasks from './modules/tasks';
import studentTasks from './modules/student-tasks';
import notifications from './modules/notifications';

Vue.use(Vuex);

export default new Vuex.Store({
  state,
  mutations,
  actions,
  getters,
  modules: {
    StatusService,
      auth,
      lections,
      courses,
      chat,
      lecturerChat,
      handbook,
      users,
      tasks,
      studentTasks,
      notifications
  }
});
