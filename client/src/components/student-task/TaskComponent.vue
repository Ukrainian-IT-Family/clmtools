<template>
    <main role="main" class="container">
        <div class="d-flex">
            <StudentLectionMenu />
            <Deadline v-if="task_id" :taskId='task_id'></Deadline>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" v-if="taskExist">{{ this.GET_TASK_ELEMENT.title }}</div>
                <div class="card-body student-task" v-if="taskExist">
                    <form class="block-1">
                        <p class="answer-title">{{ $t("tasks.answer") }}</p>
                        <div v-if="!isAnswered && !deadlinePassed">
                            <input
                                class="answer-input"
                                type="text"
                                :placeholder="$t('tasks.link_to_answer')"
                                v-model="answer"
                            >
                            <p class="deadline-text">{{ $t("tasks.answer_before") }} {{ this.GET_TASK_ELEMENT.deadline }}</p>
                            <button type="button" class="answer-button" @click="sendAnswer">{{ $t("buttons.send") }}</button>
                        </div>
                        <div v-if="isAnswered">
                            <p>
                              {{ $t("tasks.answer") }}: {{ this.GET_ANSWER_INFO_ELEMENT.answer }} <br>
                              {{ $t("tasks.go_to") }}
                                <RouterLink
                                    :to="{
                                      name: 'Chat',
                                      params: { lection_id: this.$route.params.lection_id }
                                    }"
                                >{{ $t("chat.lecturer_chat") }}</RouterLink>
                            </p>
                            <p class="alert alert-success">
                              {{ $t("message.answer_send") }}
                            </p>
                        </div>
                        <p class="deadline-text" v-if="deadlinePassed">
                          {{ $t("tasks.task_expired") }} {{ this.GET_TASK_ELEMENT.deadline }}
                        </p>
                    </form>
                    <div class="block-1" v-if="isRated">
                      {{ $t("tasks.answer_rate") }}<br>
                      {{ $t("tasks.point") }} {{ this.GET_ANSWER_INFO_ELEMENT.rating }} / {{ this.GET_ANSWER_INFO_ELEMENT.max_rating }}
                    </div>
                    <div class="block-1">
                        {{ this.GET_TASK_ELEMENT.description }}
                    </div>
                </div>
                <div class="card-body student-task" v-else>
                  {{ $t("tasks.no_task") }}
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import StudentLectionMenu from '@/components/common/StudentLectionMenu.vue';
import Deadline from '@/components/student-task/Deadline.vue';
import methods from '@/components/methods/methods';

export default {
    name: 'TaskComponent',
    components:{
        StudentLectionMenu,
        Deadline
    },
    data: () => ({
        answer: null,
        taskExist: false,
        isAnswered: false,
        isRated: false,
        deadlinePassed: false,
        task_id: null
    }),
    mixins: [methods],
    computed: {
        ...mapGetters('auth', {
            user: 'getAuthenticatedUser'
        }),
        ...mapGetters('studentTasks', [
            'GET_TASK_ELEMENT',
            'GET_ANSWER_INFO_ELEMENT',
        ]),
    },
    methods: {
        ...mapActions('studentTasks', [
            'GET_TASK',
            'POST_ANSWER',
            'GET_ANSWER_INFO'
        ]),
        sendAnswer() {
            this.POST_ANSWER({
                task_id: this.GET_TASK_ELEMENT.id,
                answer: this.answer.trim()
            })
                .then(() => {
                    this.GET_ANSWER_INFO_ELEMENT.answer = this.answer.trim();
                    this.isAnswered = true;
                })
                .catch((error) => {
                    if (error.response.data.errors) {
                        console.log(Object.values(error.response.data.errors).join('\r\n'));
                    }
                } );
        },
    },
    mounted() {
        this.GET_TASK({
            lecture_id: this.$route.params.lection_id
        })
            .then(() => {
                if(this.GET_TASK_ELEMENT.id){
                    const now = new Date();
                    const deadline = new Date(this.convertStringToDateFormat(this.GET_TASK_ELEMENT.deadline));
                    if(Date.parse(now)/1000 - Date.parse(deadline)/1000 > 0){
                        this.deadlinePassed = true;
                    }
                    this.taskExist = true;
                    this.task_id = this.GET_TASK_ELEMENT.id;
                    this.GET_ANSWER_INFO({
                        task_id: this.GET_TASK_ELEMENT.id
                    })
                        .then(() => {
                            if(this.GET_ANSWER_INFO_ELEMENT.answer){
                                this.isAnswered = true;
                            }
                            if(this.GET_ANSWER_INFO_ELEMENT.rating > 0){
                                this.isRated = true;
                            }
                        })
                        .catch((error) => {
                            if (error.response.data.errors) {
                                console.log(Object.values(error.response.data.errors).join('\r\n'));
                            }
                        } );
                }
            })
            .catch((error) => {
                if (error.response.data.errors) {
                    console.log(Object.values(error.response.data.errors).join('\r\n'));
                }
            } );
    }
};
</script>
