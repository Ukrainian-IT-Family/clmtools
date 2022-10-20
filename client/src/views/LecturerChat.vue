<template>
  <ChatComponent></ChatComponent>
</template>

<script>
import { mapGetters } from 'vuex';
import ChatComponent from '@/components/lecturer-chat/ChatComponent.vue';

export default {
  name: 'LecturerChatPage',
  components: {
      ChatComponent
  },
  computed: {
    ...mapGetters('auth', {
      user: 'getAuthenticatedUser',
    })
  }
};
</script>
