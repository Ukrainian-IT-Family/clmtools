<template>
  <SingleTaskComponent></SingleTaskComponent>
</template>

<script>
import { mapGetters } from 'vuex';
import SingleTaskComponent from '@/components/student-task/SingleTaskComponent.vue';

export default {
  name: 'SingleTaskPage',
  components: {
      SingleTaskComponent
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
