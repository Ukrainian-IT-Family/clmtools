<template>
    <div class="message-area" v-if="messagesExist">
        <MessageComponent
            v-for="message in GET_MESSAGES_ELEMENTS"
            :key="message.id"
            :message="message"
            :currentUserId="currentUserId"
        ></MessageComponent>
    </div>
    <p v-else>{{ $t("message.empty_notification") }}</p>
</template>

<script>
import MessageComponent from '@/components/lecturer-chat/MessageComponent.vue';
import { mapActions, mapGetters } from "vuex";
import Event from "../../store/modules/chat/event";

export default {
    name: 'LecturerChatMessagesComponent',
    components:{
        MessageComponent
    },
    data: () => ({
        messagesExist: false,
        currentUserId: null,
    }),
    props: {
        student_id: {
            default: null
        },
        lecture_id: {
            default: null
        }
    },
    computed: {
        ...mapGetters('auth', {
            user: 'getAuthenticatedUser'
        }),
        ...mapGetters('lecturerChat', [
            'GET_MESSAGES_ELEMENTS',
        ]),
    },
    methods: {
        ...mapActions('lecturerChat', [
            'GET_MESSAGES',
        ]),
    },
    mounted() {
        this.currentUserId = this.user.id;
        this.GET_MESSAGES({
            user_id: this.student_id,
            lecture_id: this.lecture_id
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
