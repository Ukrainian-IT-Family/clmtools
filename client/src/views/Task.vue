<template>
  <TaskComponent></TaskComponent>
</template>

<script>
import { mapGetters } from 'vuex';
import TaskComponent from '@/components/student-task/TaskComponent.vue';

export default {
  name: 'TaskPage',
  components: {
      TaskComponent
  },
  computed: {
    ...mapGetters('auth', {
      user: 'getAuthenticatedUser',
      fullName: 'getFullName',
      isLoggedIn: 'isLoggedIn'
    })
  }
};
</script>
