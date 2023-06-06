<template>
    <div class="row-fluid card example-1 square scrollbar-grey bordered-grey">
        <div class="d-flex">
            <RouterLink class="nav-link text-dark" :to="{ name: 'Tasks' }">
                <i class="fa-solid fa-arrow-left-long">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                        <path
                            d="M9.375 233.4l128-128c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H480c17.69 0 32 14.31 32 32s-14.31 32-32 32H109.3l73.38 73.38c12.5 12.5 12.5 32.75 0 45.25c-12.49 12.49-32.74 12.51-45.25 0l-128-128C-3.125 266.1-3.125 245.9 9.375 233.4z"
                        />
                    </svg>
                </i>
            </RouterLink>
            <h3>{{ $t("buttons.detail") }}</h3>
            <RouterLink :to="{ name: 'edit.task', params: { task_id: $router.history.current.params.task_id } }">
                <button
                    class="position-absolute end-0 btn btn-info"
                    style="margin-right: 100px"
                >{{ $t("buttons.edit") }}</button>
            </RouterLink>
            <button
                @click="showDeleteModal()"
                class="position-absolute end-0 btn btn-danger"
            >{{ $t("buttons.clear") }}</button>
        </div>
        <h4 v-text="title"></h4>
        <p v-text="description"></p>
        <p v-if="course">{{ $t("courses.course") }}: <span v-text="course"></span></p>
        <p v-if="lection">{{ $t("lectures.lecture") }}: <span v-text="lection"></span></p>
        <p>{{ $t("buttons.published") }}: <span v-text="date"></span></p>
        <p>{{ $t("tasks.deadline") }}: <span v-text="new Date(deadline).toLocaleString('uk-UA')"></span></p>
        <hr>
        <div class="d-sm-flex">
            <div style="min-width: 250px;">
                <button class="btn btn-secondary centered" type="button" @click="onSubmitForm()" :disabled="almostRated.length < 1">
                    {{ $t("tasks.send_ratings") }}
                </button>
                <div class="form-check dropdown-item centered" v-show="showAllStudentsButton.length > 0">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" @click="selectAllStudents()" >
                        {{ $t("buttons.to_all_students") }}
                    </label>
                </div>
                <div v-for="student in passed" v-bind:key="student.id" v-show="!alreadyRated(student.id)">
                    <div class="form-check dropdown-item bordered" v-show="student.pivot.rating">
                        <label class="form-check-label">
                            <input
                                class="form-check-input"
                                v-model="almostRated"
                                type="checkbox"
                                :value="student.id"
                                :checked="allStudents"
                                :disabled="alreadyRated(student.id)"
                            >
                            {{ student.name }} {{ student.last_name }}
                            <span class="border right ml-3">
                            <input type="text" maxlength="3" class="small-input" :value="student.pivot.rating" readonly>/{{ points }}
                        </span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="ml-4 mr-4 pl-4" style="border-left: 2px solid grey;">
                <div class="d-inline-block">
                    <div class="float-right counts ml-auto">
                        <h2>{{ rated.length }}</h2>{{ $t("tasks.rated") }}
                    </div>
                    <div class="float-right counts ml-auto">
                        <h2>{{ students.length }}</h2>{{ $t("tasks.assigned") }}
                    </div>
                    <div class="float-right counts ml-auto">
                        <h2>{{ passed.length }}</h2>{{ $t("tasks.passed") }}
                    </div>
                </div>

                <div class="form-check dropdown-item bordered d-flex" v-for="(student, key) in passed" v-bind:key="student.id">
                    <label class="form-check-label pr-5 mr-5">
                        <span>{{ student.name }} {{ student.last_name }}</span>
                        <a :href="student.pivot.answer" target="_blank">
                            <p class="bordered" v-text="student.pivot.answer"></p>
                        </a>
                    </label>
                    <label class="d-grid right">
                        {{ $t("tasks.rate") }}
                        <span class="border">
                            <input
                                type="number"
                                maxlength="3"
                                class="small-input"
                                v-model="student.pivot.rating"
                                @change="pointsMaximum(key)"
                                :readonly="alreadyRated(student.id)"
                            >
                            /{{ points }}
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <div
            class="modal preview_modal"
            tabindex="-1"
            role="dialog"
            v-show="alertDeleteModal"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <i
                            class="fa-solid fa-arrow-left-long modal_i"
                            @click="hideDeleteModal()"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M9.375 233.4l128-128c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H480c17.69 0 32 14.31 32 32s-14.31 32-32 32H109.3l73.38 73.38c12.5 12.5 12.5 32.75 0 45.25c-12.49 12.49-32.74 12.51-45.25 0l-128-128C-3.125 266.1-3.125 245.9 9.375 233.4z"
                                />
                            </svg>
                        </i>
                        <h5 class="modal-title">{{ $t("buttons.warning") }}</h5>
                    </div>
                    <div class="modal-body">
                        <p>{{ $t("tasks.sure_delete") }}</p>
                    </div>
                    <div class="modal-footer d-flex">
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="confirmDeleteTask()"
                        >
                          {{ $t("buttons.yes") }}
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="hideDeleteModal()"
                        >
                          {{ $t("buttons.no") }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import methods from '@/components/methods/methods';

export default {
    name: 'AddTask',

    mixins: [methods],

    data() {
        return {
            title: '',
            description: '',
            date: '',
            deadline: '',
            course: '',
            lection: '',
            students: [],
            allStudents: false,
            rated: [],
            almostRated: [],
            ratedStudents: {},
            passed: [],
            points: '',
            alertDeleteModal: false,
            errors: ''
        };
    },

    computed: {
      ...mapGetters('tasks', {
        getTask: 'GET_TASK'
      }),

      showAllStudentsButton() {
        return this.passed.filter(item => {
          return !this.alreadyRated(item.id) && item.pivot.rating > 0;
        });
      },
    },

    methods: {
        ...mapActions('tasks', [
            'GET_TASK',
            'SET_RATE_TASK',
            'DELETE_TASK'
        ]),
        ...mapActions([
            'makeAlert'
        ]),

        getRatingByStudentId(id) {
            let key = Object.keys(this.passed).find(key => this.passed[key].id === parseInt(id));
            return this.passed[key].pivot.rating;
        },

        alreadyRated(student_id) {
            return !!Object.keys(this.rated).find(key => this.rated[key].id === parseInt(student_id));
        },

        sendEditTask() {
            this.SET_RATE_TASK({
                task_id: this.$router.history.current.params.task_id,
                students: this.ratedStudents
            })
                .then(() => {
                    this.makeAlert(this.$t("tasks.rated_success"));
                    this.setTaskData();
                })
                .catch(error => {
                    console.log(error);
                });
        },

        sendDeleteTask() {
            this.DELETE_TASK({
                task_id: this.$router.history.current.params.task_id,
            })
                .then(() => {
                    this.makeAlert(this.$t("tasks.tasks") + ' ' + this.title + ' ' + this.$t("tasks.deleted"));
                    this.$router.push({ name: 'Tasks' }).catch(() => {});
                })
                .catch(error => {
                    console.log(error);
                });
        },

        confirmDeleteTask() {
            this.sendDeleteTask();
            this.hideDeleteModal();
        },

        onSubmitForm() {
            if (this.validation()) {
                this.sendEditTask();
            }
        },

        validation() {
            this.setRated();
            if (this.almostRated.length === 0) {
                this.makeAlert(this.$t("errors.empty_students") + '\n');
                return false;
            }
            return true;
        },

        showDeleteModal() {
            this.alertDeleteModal = true;
        },

        hideDeleteModal() {
            this.alertDeleteModal = false;
        },

        getTaskData() {
            this.GET_TASK({
                task_id: this.$router.history.current.params.task_id
            })
                .then(() => {
                    this.setTaskData();
                })
                .catch(error => {
                    console.log(error);
                });
        },

        setTaskData() {
            this.title = this.getTask.task.title;
            this.points = this.getTask.task.points;
            this.description = this.getTask.task.description;
            this.date = this.getTask.task.date;
            if (this.getTask.task.course.id) {
                this.course = this.getTask.task.course.title;
            }
            if (this.getTask.task.lecture.id) {
                this.lection = this.getTask.task.lecture.title;
            }
            this.students = this.getTask.task.students;
            if (this.passed.length < 1) {
              this.passed = this.getTask.task.passed;
            }
            this.rated = this.getTask.task.rated;
            this.deadline = this.toInputDateFormat(this.getTask.task.deadline, 'date') + ' ' + this.toInputDateFormat(this.getTask.task.deadline, 'time');
        },

        pointsMaximum(points) {
            this.passed[points].pivot.rating = parseInt(this.passed[points].pivot.rating, 10);
            let SetPoint = this.passed[points].pivot.rating;
            if (SetPoint > this.points) {
                this.passed[points].pivot.rating = this.points;
            } else if (SetPoint < 0) {
                this.passed[points].pivot.rating = 0;
            }
        },

        selectAllStudents() {
            this.allStudents = !this.allStudents === true;
            if (this.allStudents) {
                const selected = this.passed.map((u) => u.id);
                this.almostRated = selected;
            } else {
                this.almostRated = [];
            }
        },

        setRated() {
            this.ratedStudents = {};
            this.almostRated.forEach((id, key) => {
                let rating = this.getRatingByStudentId(id);
                if(rating) {
                    this.ratedStudents[id] = rating;
                } else {
                    delete this.almostRated[key];
                }
            });
        }
    },

    mounted() {
        this.getTaskData();
    }
};
</script>
