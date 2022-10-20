<template>
    <main role="main" class="container">
      <div class="d-flex">
        <StudentLectionMenu />
        <Deadline v-if="task_id" :taskId='task_id'></Deadline>
      </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $t("chat.lecturer_chat") }}</div>
                <div class="card-body" v-if="chatExist">
                    <ChatMessagesComponent></ChatMessagesComponent>
                    <ChatFormComponent></ChatFormComponent>
                </div>
                <div class="card-body" v-else>
                    <button type="button" class="btn btn-info" @click="createChat">{{ $t("chat.start_send") }}</button>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import ChatMessagesComponent from '@/components/chat/ChatMessagesComponent.vue';
import ChatFormComponent from '@/components/chat/ChatFormComponent.vue';
import StudentLectionMenu from '@/components/common/StudentLectionMenu.vue';
import { mapActions, mapGetters } from "vuex";
import Event from "../../store/modules/chat/event";
import Deadline from '@/components/student-task/Deadline.vue';
import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.VUE_APP_PUSHER_APP_KEY,
    cluster: 'eu',
    encrypted: true
});

export default {
    name: 'ChatComponent',
    components:{
        ChatMessagesComponent,
        ChatFormComponent,
        StudentLectionMenu,
        Deadline
    },
    data: () => ({
        chatExist: false,
        task_id: null
    }),
    computed: {
        ...mapGetters('auth', {
            user: 'getAuthenticatedUser'
        }),
        ...mapGetters('chat', [
            'GET_CHAT_ELEMENT',
        ]),
        ...mapGetters('lections', ['getLection'])
    },
    methods: {
        ...mapActions('chat', [
            'GET_CHAT',
            'POST_CHAT'
        ]),
        ...mapActions('lections', ['GET_LECTION']),
        createChat() {
            this.POST_CHAT({
                lecture_id: this.$route.params.lection_id
            })
                .then(() => {
                    this.chatExist = true;
                    window.Echo.channel('chat.' + this.GET_CHAT_ELEMENT.id)
                        .listen('.MessageCreated', (data) => {
                            Event.$emit('added_message', data.message);
                        });
                })
                .catch((error) => {
                    if (error.response.data.errors) {
                        console.log(Object.values(error.response.data.errors).join('\r\n'));
                    }
                } );
        },
        addDeadline() {
          this.GET_LECTION({
            lection_id: this.$route.params.lection_id
          })
              .then(() => {
                this.task_id = this.getLection.lection.task_id;
              })
              .catch(error => {
                  console.log(error);
              });
        }
    },
    mounted() {
        window.Echo.channel('chat.' + this.user.id + '.' + this.$route.params.lection_id)
            .listen('.ChatCreated', () => {
                Event.$emit('added_chat');
            });
        this.GET_CHAT({
            user_id: this.user.id,
            lecture_id: this.$route.params.lection_id
        })
            .then(() => {
                if(this.GET_CHAT_ELEMENT.id){
                    this.chatExist = true;
                    window.Echo.leave('chat.' + this.GET_CHAT_ELEMENT.id);
                    window.Echo.channel('chat.' + this.GET_CHAT_ELEMENT.id)
                        .listen('.MessageCreated', (data) => {
                            Event.$emit('added_message', data.message);
                        });
                }
            })
            .catch((error) => {
                if (error.response.data.errors) {
                    console.log(Object.values(error.response.data.errors).join('\r\n'));
                }
            } );
        Event.$on('added_chat', () => {
            this.GET_CHAT({
                user_id: this.user.id,
                lecture_id: this.$route.params.lection_id
            })
                .then(() => {
                    if(this.GET_CHAT_ELEMENT.id){
                        this.chatExist = true;
                        window.Echo.leave('chat.' + this.GET_CHAT_ELEMENT.id);
                        window.Echo.channel('chat.' + this.GET_CHAT_ELEMENT.id)
                            .listen('.MessageCreated', (data) => {
                                Event.$emit('added_message', data.message);
                            });
                    }
                })
                .catch((error) => {
                    if (error.response.data.errors) {
                        console.log(Object.values(error.response.data.errors).join('\r\n'));
                    }
                } );
        });
        this.addDeadline();
    },
};
</script>
