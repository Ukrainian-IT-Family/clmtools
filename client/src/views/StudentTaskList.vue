<template>
  <TaskListComponent></TaskListComponent>
</template>

<script>
import { mapGetters } from 'vuex';
import TaskListComponent from '@/components/student-task/TaskListComponent.vue';

export default {
  name: 'LecturerChatPage',
  components: {
      TaskListComponent
  },
  computed: {
    ...mapGetters('auth', {
      user: 'getAuthenticatedUser',
    })
  }
};
</script>
