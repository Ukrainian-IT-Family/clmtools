<template>
    <main role="main" class="container">
        <div class="col-md-12">
            <h2>{{ $t("tasks.all_tasks") }}</h2>
            <ul class="student-task-list" v-if="tasksExist">
                <li
                    v-for="task in this.GET_TASK_ELEMENTS"
                    v-bind:key="task.id"
                    class="li4"
                >
                    <div class="row">
                        <div class="col-6 p-3">
                            <p class="title">{{ task.title }}</p>
                            <p>{{ $t("buttons.published") }}: {{ task.date }}</p>
                            <p>{{ $t("lectures.lecture") }}: {{ task.lecture.id ? task.lecture.title : $t("lectures.no_lecture") }}</p>
                        </div>
                        <div class="col-3">
                             <p>{{ $t("tasks.deadline") }}:<br>{{ task.deadline }}</p>
                        </div>
                        <div class="col-3">
                            <RouterLink
                                v-if="task.lecture.id > 0"
                                :to="{
                                    name: 'Task',
                                    params: { lection_id: task.lecture.id }
                                }">
                                <button class="btn btn-info">
                                  {{ $t("buttons.detail") }}
                                </button>
                            </RouterLink>
                            <RouterLink
                                v-else
                                :to="{
                                    name: 'StudentTask',
                                    params: { task_id: task.id }
                                }">
                                <button class="btn btn-info">
                                  {{ $t("buttons.detail") }}
                                </button>
                            </RouterLink>
                        </div>
                    </div>
                </li>
            </ul>
            <div v-else>
              {{ $t("tasks.empty_tasks") }}
            </div>
        </div>
    </main>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'TaskListComponent',
    computed: {
        ...mapGetters('auth', {
            user: 'getAuthenticatedUser'
        }),
        ...mapGetters('studentTasks', [
            'GET_TASK_ELEMENTS',
        ]),
    },
    data: () => ({
        tasksExist: false,
    }),
    methods: {
        ...mapActions('studentTasks', [
            'GET_TASKS',
        ]),
    },
    mounted() {
        this.GET_TASKS({
            user_id: this.user.id
        })
            .then(() => {
                if(this.GET_TASK_ELEMENTS.length){
                    this.tasksExist = true;
                }
            })
            .catch((error) => {
                if (error.response.data.errors) {
                    alert(Object.values(error.response.data.errors).join('\r\n'));
                }
            } );
    }
};
</script>
