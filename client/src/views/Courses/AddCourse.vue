<template>
    <div>
        <BNavItem>
          <button @click="showCourseModal()" class="btn btn-light">
            {{ $t("courses.create_course") }}
          </button>
        </BNavItem>

        <div class="modal preview_modal" tabindex="-1" role="dialog" v-show="addCourseModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="fa-solid fa-arrow-left-long modal_i" @click="hideCourseModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M9.375 233.4l128-128c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H480c17.69 0 32 14.31 32 32s-14.31 32-32 32H109.3l73.38 73.38c12.5 12.5 12.5 32.75 0 45.25c-12.49 12.49-32.74 12.51-45.25 0l-128-128C-3.125 266.1-3.125 245.9 9.375 233.4z"/></svg>
                        </i>
                        <h5 class="modal-title">{{ $t("courses.create_course") }}</h5>
                    </div>
                    <div v-if="errors" class="alert-danger alert" v-text="errors"></div>
                    <div class="modal-body">
                        <form onsubmit="onSubmitForm">
                            <div>
                                <div class="form-group">
                                    <label class="form-check-label" for="allStudents">
                                      {{ $t("courses.course_name") }}
                                        <input type="text" v-model="title" class="form-control add-form-control" >
                                    </label>
                                </div>
                            </div>
                          {{ $t("courses.add_users") }}
                            <hr>
                            <div>
                                <div class="form-group">
                                    <div class="form-check dropdown-item">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" @click="selectAllStudents()">
                                          {{ $t("buttons.all_students") }}
                                        </label>
                                    </div>
                                    <div class="form-check dropdown-item" v-for="student in GetStudents" v-bind:key="student.id">
                                        <label class="form-check-label">
                                            <input class="form-check-input" @change="countStudents" v-model="students" type="checkbox" :value="student.id" :checked="allStudents">
                                            {{ student.name }} {{ student.last_name }}
                                        </label>
                                    </div>
                                    <button class="btn btn-secondary" type="button" @click="hideCourseModal()">
                                      {{ $t("buttons.cancel") }}
                                    </button>
                                    <button class="btn btn-success" type="button" @click="onSubmitForm()">
                                      {{ $t("buttons.add") }}
                                    </button>
                                </div>
                            </div>
                        </form>
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
    name: "AddCourse",

    mixins: [methods],

    data () {
        return {
            title: '',
            errors: '',
            students: [],
            addCourseModal: false,
            allStudents: false,
        };
    },

    computed: {
        ...mapGetters('users', [
            'GetStudents',
        ]),
    },

    methods: {
        ...mapActions('courses', [
            'ADD_COURSE'
        ]),
        ...mapActions('users', [
            'GET_STUDENTS'
        ]),
        ...mapActions([
            'makeAlert'
        ]),

        getStudents(){
            this.GET_STUDENTS()
                .then(() => {})
                .catch((error) => {
                    if (error.response.data.errors) {
                        console.log(Object.values(error.response.data.errors).join('\r\n'));
                    }
                } );
        },

        onSubmitForm(){
            if (this.validationForm()) {
                this.ADD_COURSE({
                    title: this.title,
                    students: this.students,
                })
                .then(() => {
                    this.makeAlert(this.$t("courses.course") + ' ' + this.title + ' ' + this.$t("courses.added"));
                    this.hideCourseModal();
                })
                .catch((error) => {
                    if (error.response.data.errors) {
                        this.errors = Object.values(error.response.data.errors).join('\r\n');
                    }
                });
            }
        },

        validationForm(){
            let errors = '';
            if(!this.title){
                errors += this.$t("errors.empty_name") + '\n';
            }
            if(this.students.length === 0){
                errors += this.$t("errors.empty_students") + '\n';
            }
            if(errors !== ''){
                this.makeAlert(errors);
                return false;
            }
            return true;
        },

        showCourseModal(){
            this.addCourseModal = true;
        },

        hideCourseModal(){
            this.addCourseModal = false;
        },

        selectAllStudents(){
            this.allStudents = !this.allStudents === true;
            if (this.allStudents) {
                const selected = this.GetStudents.map((u) => u.id);
                this.students = selected;
            } else {
                this.students = [];
            }
        },

        countStudents() {
            let text = this.getCountStudentsText(this.students.length);
            this.count_students_text = this.students.length
                ? this.students.length + text
                : this.$t("buttons.choose_students");
        },
    },

    mounted() {
        this.getStudents();
    },
};
</script>
