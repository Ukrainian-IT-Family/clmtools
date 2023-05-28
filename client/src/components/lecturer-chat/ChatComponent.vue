<template>
    <main role="main" class="container">
        <div class="col-md-16">
            <div class="row lecturer-chat" v-if="lecturesExist">
                <div class="col-xs-6 col-sm-3 pb-1">
                    <div class="lectures-area">
                        <div
                             v-for="lecture in this.GET_LECTURES_ELEMENTS"
                             class="lecture-chat pb-1 mb-1"
                             :class="{ 'lecturer-chat-active' : activeLecture === lecture.id }"
                             :key="lecture.id"
                             @click="getLectureStudentsList(lecture.id)"
                        >
                            <span style="color:red;">{{ lecture.unread_by_lecturer ? lecture.unread_by_lecturer : ''  }}</span> <strong>{{ lecture.title }}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <div class="users-area" v-if="studentsExist">
                        <div
                            v-for="student in this.GET_STUDENTS_ELEMENTS"
                            class="user-chat"
                            :class="{ 'lecturer-chat-active' : activeStudent === student.id }"
                            :key="student.id"
                            @click="getChatByStudentAndLecture(student.id)"
                        >
                            <strong>{{ student.name }} {{ student.last_name }}</strong>
                        </div>
                    </div>
                    <div class="users-area" v-else>
                        <p>{{ $t("chat.empty_list") }}</p>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-7 card">
                    <div class="card-body" v-if="chatExist">
                        <ChatMessagesComponent :student_id="this.activeStudent" :lecture_id="this.activeLecture"></ChatMessagesComponent>
                        <ChatFormComponent :student_id="this.activeStudent" :lecture_id="this.activeLecture"></ChatFormComponent>
                    </div>
                    <div class="card-body" v-else-if="chatAvailable">
                        <button type="button" @click="createChat">{{ $t("chat.start_send") }}</button>
                    </div>
                    <div class="card-body" v-else>
                        <p>{{ $t("chat.choose_lecture") }}</p>
                    </div>
                </div>
            </div>
            <div class="row lecturer-chat" v-else>
                <p>{{ $t("chat.lecture_need") }}</p>
            </div>
        </div>
    </main>
</template>

<script>
import ChatMessagesComponent from '@/components/lecturer-chat/ChatMessagesComponent.vue';
import ChatFormComponent from '@/components/lecturer-chat/ChatFormComponent.vue';
import { mapActions, mapGetters } from "vuex";
import Event from "../../store/modules/chat/event";

export default {
    name: 'LecturerChatComponent',
    components: {
        ChatMessagesComponent,
        ChatFormComponent
    },
    data: () => ({
        lecturesExist: false,
        studentsExist: false,
        chatExist: false,
        chatAvailable: false,
        activeLecture: 0,
        activeStudent: 0,
    }),
    computed: {
        ...mapGetters('lecturerChat', [
            'GET_LECTURES_ELEMENTS',
            'GET_STUDENTS_ELEMENTS',
            'GET_CHAT_ELEMENT',
        ]),
    },
    methods: {
        ...mapActions('lecturerChat', [
            'GET_LECTURES',
            'GET_STUDENTS',
            'GET_CHAT',
            'POST_CHAT',
        ]),
        createChat() {
            this.POST_CHAT({
                user_id: this.activeStudent,
                lecture_id: this.activeLecture
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
        getLectureStudentsList(lectureId) {
            this.GET_STUDENTS({
                lecture_id: lectureId
            })
                .then(() => {
                    this.studentsExist = !!this.GET_STUDENTS_ELEMENTS.length;
                    this.chatExist = false;
                    this.chatAvailable = false;
                    this.activeStudent = 0;
                    this.activeLecture = lectureId;
                })
                .catch((error) => {
                    if (error.response.data.errors) {
                        console.log(Object.values(error.response.data.errors).join('\r\n'));
                    }
                } );
        },
        getChatByStudentAndLecture(studentId) {
            this.chatExist = false;
            window.Echo.channel('chat.' + studentId + '.' + this.activeLecture)
                .listen('.ChatCreated', () => {
                    Event.$emit('added_chat');
                });
            this.GET_CHAT({
                user_id: studentId,
                lecture_id: this.activeLecture
            })
                .then(() => {
                    this.activeStudent = studentId;
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
                    this.activeStudent = studentId;
                    this.chatExist = false;
                    this.chatAvailable = true;
                    if (error.response.data.errors) {
                        console.log(Object.values(error.response.data.errors).join('\r\n'));
                    }
                } );
            Event.$on('added_chat', () => {
                this.GET_CHAT({
                    user_id: studentId,
                    lecture_id: this.activeLecture
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
        }
    },
    mounted() {
        this.GET_LECTURES()
            .then(() => {
                if(this.GET_LECTURES_ELEMENTS.length){
                    this.lecturesExist = true;
                }
            })
            .catch((error) => {
                if (error.response.data.errors) {
                    console.log(Object.values(error.response.data.errors).join('\r\n'));
                }
            } );
    },
};
</script>
