<template>
    <div class="message-area" v-if="messagesExist">
        <MessageComponent
            v-for="message in GET_MESSAGES_ELEMENTS"
            :key="message.id"
            :message="message"
            :currentUserId="currentUserId"
        ></MessageComponent>
    </div>
    <p v-else>{{ $t("message.empty_chat") }}</p>
</template>

<script>
import MessageComponent from '@/components/chat/MessageComponent.vue';
import { mapActions, mapGetters } from 'vuex';
import Event from '../../store/modules/chat/event.js';

export default {
    name: 'ChatMessagesComponent',
    components:{
        MessageComponent
    },
    data: () => ({
        messagesExist: false,
        currentUserId: null,
    }),
    computed: {
        ...mapGetters('auth', {
            user: 'getAuthenticatedUser'
        }),
        ...mapGetters('chat', [
            'GET_MESSAGES_ELEMENTS',
        ]),
    },
    methods: {
        ...mapActions('chat', [
            'GET_MESSAGES',
        ]),
    },
    mounted() {
        this.currentUserId = this.user.id;
        this.GET_MESSAGES({
            user_id: this.user.id,
            lecture_id: this.$route.params.lection_id
        })
            .then(() => {
                if(this.GET_MESSAGES_ELEMENTS.length){
                    this.messagesExist = true;
                }
            })
            .catch((error) => {
                if (error.response.data.errors) {
                    console.log(Object.values(error.response.data.errors).join('\r\n'));
                }
            } );

        Event.$on('added_message', (message) => {
            this.messagesExist = true;
            this.GET_MESSAGES_ELEMENTS.push(message);
        });
    },
};
</script>
