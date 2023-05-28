<template>
  <div class="message" v-bind:class="{ self: message.user.id === this.currentUserId }">
    <strong class="user">{{ message.user.name }} <span v-if="message.user.id === this.currentUserId">({{ $t("chat.you") }})</span></strong>
    <p class="body">{{ message.body }}</p>
    <a v-if="message.file_url" :href="this.backend_url+message.file_url">{{ $t("buttons.file") }}</a>
    <p class="body time">{{ new Date(message.created_at).toLocaleString('uk-UA') }}</p>
  </div>
</template>

<script>
export default {
  name: 'MessageComponent',
  props: {
      message: {
          default: 'NULL'
      },
      currentUserId: {
          default: 'NULL'
      },
  },
  data() {
    return {
        backend_url: process.env.VUE_APP_BACKEND_URL
    };
  },
};
</script>
