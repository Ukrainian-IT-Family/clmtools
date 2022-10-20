<template>
  <div class="row-fluid card example-1 square scrollbar-grey bordered-grey">
    <div class="d-flex">
      <RouterLink
        class="nav-link text-dark"
        :to="
          editTask
            ? {
                name: 'detail.task',
                params: { task_id: $router.history.current.params.task_id }
              }
            : { name: 'Tasks' }
        "
      >
        <i class="fa-solid fa-arrow-left-long">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
            <path
              d="M9.375 233.4l128-128c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H480c17.69 0 32 14.31 32 32s-14.31 32-32 32H109.3l73.38 73.38c12.5 12.5 12.5 32.75 0 45.25c-12.49 12.49-32.74 12.51-45.25 0l-128-128C-3.125 266.1-3.125 245.9 9.375 233.4z"
            />
          </svg>
        </i>
      </RouterLink>
      <h3 v-text="h3"></h3>
      <button
        @click="onSubmitForm()"
        v-text="button"
        class="position-absolute end-0 btn btn-success"
      ></button>
    </div>
    <div v-if="errors" class="alert-danger alert" v-text="errors"></div>
    <form onsubmit="onSubmitForm" class="d-sm-flex">
      <div style="width: -webkit-fill-available;">
        <div class="form-group">
          <input
            type="text"
            v-model="title"
            class="form-control add-form-control"
            :placeholder="$t('tasks.task_name')"
            :readonly="editTask"
          />
          <textarea
            v-model="description"
            class="form-control add-form-control"
            rows="8"
            :placeholder="$t('tasks.task_desc')"
            style="width: -webkit-fill-available;"
            :readonly="editTask"
          ></textarea>
        </div>
      </div>

      <div class="ml-4 mr-4" style="border-left: 2px solid grey; padding-left: 15px;">
        <h5>{{ $t('tasks.for_whom') }}</h5>
        <div class="form-group">
          <div class="dropdown">
            <button
              class="btn btn-secondary dropdown-toggle max-width cut-text"
              type="button"
              @click="showDropdown('dropdownCourses')"
              v-text="choose_course_text"
            ></button>
            <div class="dropdown-menu" v-show="dropdownCourses">
              <div
                class="form-check dropdown-item"
                v-for="course in GetCourses"
                v-bind:key="course.id"
              >
                <label class="form-check-label">
                  <input
                    class="form-check-input"
                    v-model="courses"
                    type="radio"
                    :value="course.id"
                    @change="chooseCourse"
                    :disabled="editTask"
                  />
                  {{ course.title }}
                </label>
              </div>
              <button
                class="btn btn-secondary"
                type="button"
                @click="showDropdown('dropdownCourses')"
              >
                {{ $t('buttons.save') }}
              </button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="dropdown">
            <button
              class="btn btn-secondary dropdown-toggle max-width-long cut-text"
              type="button"
              @click="showDropdown('dropdownLections')"
              v-text="choose_lection_text"
            ></button>
            <div class="dropdown-menu" v-show="dropdownLections">
              <div
                class="form-check dropdown-item"
                v-for="lection in allLections"
                v-bind:key="lection.id"
              >
                <label class="form-check-label">
                  <input
                    class="form-check-input"
                    v-model="lections"
                    type="radio"
                    :value="lection.id"
                    @change="chooseLection"
                  />
                  {{ lection.title }}
                </label>
              </div>
              <button
                class="btn btn-secondary"
                type="button"
                @click="showDropdown('dropdownLections')"
              >
                {{ $t('buttons.save') }}
              </button>
            </div>
          </div>
        </div>
        <p style="width: max-content" class="mt-5">
          {{ $t('tasks.rate_points') }}
        </p>
        <h5 class="centered">
          <span>{{ $t('tasks.points') }}</span>
          <input
            type="number"
            v-model="points"
            class="ml-2"
            min="1"
            max="100"
            @change="pointsValidation()"
            :readonly="editTask"
          />
        </h5>
        <h5 class="mt-5 centered_text">
          {{ $t('tasks.deadline') }}:
        </h5>
        <p class="centered_text">{{ $t('buttons.date') }}</p>
        <input
          type="date"
          v-model="deadline_date"
          class="centered"
          :min="today()"
        />
      </div>
      <div class="mr-5 mt-4">
        <div class="form-group">
          <div class="dropdown">
            <button
              class="btn btn-secondary dropdown-toggle max-width"
              type="button"
              @click="showDropdown('dropdownStudents')"
              v-text="count_students_text"
            ></button>
            <div class="dropdown-menu" v-show="dropdownStudents">
              <div class="form-check dropdown-item" v-show="allStudents.length">
                <label class="form-check-label">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    @click="selectAllStudents()"
                  />
                  {{ $t('buttons.all_students') }}
                </label>
              </div>
              <div
                class="form-check dropdown-item"
                v-for="student in allStudents"
                v-bind:key="student.id"
              >
                <label class="form-check-label">
                  <input
                    class="form-check-input"
                    @change="setStudents(), countStudents()"
                    :onclick="checkSettedStudent(student.id) ? 'return false' : 'return true'"
                    v-model="students"
                    type="checkbox"
                    :value="student.id"
                    :checked="allLectureStudents"
                  />
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                    <path
                      d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"
                    />
                  </svg>
                  {{ student.name }} {{ student.last_name }}
                </label>
              </div>
              <button
                class="btn btn-secondary"
                type="button"
                @click="showDropdown('dropdownStudents')"
              >
                {{ $t('buttons.save') }}
              </button>
            </div>
          </div>
        </div>
        <div class="bottom">
          <p class="centered_text">{{ $t('buttons.time') }}</p>
          <input type="time" v-model="deadline_time" class="centered" />
        </div>
      </div>
    </form>
    <div
      class="modal preview_modal"
      tabindex="-1"
      role="dialog"
      v-show="alertEmptyLectionModal"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <i
              class="fa-solid fa-arrow-left-long modal_i"
              @click="hideEmptyLectionModal()"
            >
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                <path
                  d="M9.375 233.4l128-128c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H480c17.69 0 32 14.31 32 32s-14.31 32-32 32H109.3l73.38 73.38c12.5 12.5 12.5 32.75 0 45.25c-12.49 12.49-32.74 12.51-45.25 0l-128-128C-3.125 266.1-3.125 245.9 9.375 233.4z"
                />
              </svg>
            </i>
            <h5 class="modal-title">{{ $t('buttons.warning') }}</h5>
          </div>
          <div class="modal-body">
            <p v-text="modal_text"></p>
          </div>
          <div class="modal-footer d-flex">
            <button
              type="button"
              class="btn btn-primary"
              @click="confirmSendTask()"
            >
              {{ $t('buttons.yes') }}
            </button>
            <button
              type="button"
              class="btn btn-primary"
              @click="hideEmptyLectionModal()"
            >
              {{ $t('buttons.no') }}
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
      courses: '',
      lections: 0,
      students: [],
      set_students: [],
      allStudents: [],
      allLections: [],
      points: 10,
      alertEmptyLectionModal: false,
      dropdownCourses: false,
      dropdownLections: false,
      dropdownStudents: false,
      allLectureStudents: false,
      errors: '',
      editTask: false,
      h3: '',
      button: '',
      count_students_text: '',
      choose_course_text: '',
      choose_lection_text: '',
      modal_text: '',
      deadline_date: '',
      deadline_time: '',
    };
  },

  computed: {
    ...mapGetters('tasks', {
      getTask: 'GET_TASK'
    }),
    ...mapGetters('courses', ['GetCourses']),
    ...mapGetters('users', ['GetStudents']),
    ...mapGetters('lections', ['getLections']),

    filteredStudents() {
      return this.GetStudents.filter(item => {
        return item.course_id === this.courses;
      });
    },

    filteredLections() {
      return this.getLections.filter(item => {
        return item.course_id === this.courses;
      });
    },

    deadline() {
      return this.deadline_date + ' ' + this.deadline_time;
    }
  },

  methods: {
    ...mapActions('tasks', [
      'ADD_TASK',
      'GET_TASK',
      'EDIT_TASK',
      'DELETE_TASK'
    ]),
    ...mapActions('courses', ['GET_COURSES']),
    ...mapActions('lections', ['GET_CREATED_LECTION']),
    ...mapActions(['makeAlert']),

    getData() {
      this.GET_COURSES()
          .then(() => {
            if (this.editTask) {
              this.getTaskData();
            }
          })
          .catch(error => {
            console.log(error);
          });
      this.GET_CREATED_LECTION()
          .then(() => {})
          .catch(error => {
            console.log(error);
          });
    },

    sendEditTask() {
      this.EDIT_TASK({
        task_id: this.$router.history.current.params.task_id,
        title: this.title,
        description: this.description,
        points: this.points,
        deadline: this.deadline,
        courses: this.courses,
        lecture: this.lections,
        students: this.students
      })
        .then(() => {
          this.makeAlert(this.$t('tasks.tasks') + ' ' + this.title + ' ' + this.$t('tasks.successfully_deleted'));
          this.$router
            .push({
              name: 'detail.task',
              params: { task_id: this.$router.history.current.params.task_id }
            })
            .catch(() => {});
        })
        .catch(error => {
          console.log(error);
        });
    },

    sendAddTask() {
      this.ADD_TASK({
        title: this.title,
        description: this.description,
        points: this.points,
        deadline: this.deadline,
        courses: this.courses,
        lecture: this.lections,
        students: this.students
      })
        .then(() => {
          this.makeAlert(this.$t('tasks.tasks') + ' ' + this.title + ' ' + this.$t('tasks.successfully_added'));
          this.$router.push({ name: 'Tasks' }).catch(() => {});
        })
        .catch(error => {
          console.log(error);
        });
    },

    confirmSendTask() {
      if (this.editTask) {
        this.sendEditTask();
      } else {
        this.sendAddTask();
      }
      this.hideEmptyLectionModal();
    },

    onSubmitForm() {
      if (this.validationForm()) {
        if (!this.lections || this.editTask) {
          this.showEmptyLectionModal();
        } else {
          this.confirmSendTask();
        }
      }
    },

    validationForm() {
      let errors = '';
      if (!this.title) {
        errors += this.$t('errors.empty_name') + '\n';
      }
      if (!this.description) {
        errors += this.$t('errors.empty_desc') + '\n';
      }
      if (this.courses.length === 0) {
        errors += this.$t('errors.empty_course') + '\n';
      }
      if (this.students.length === 0) {
        errors += this.$t('errors.empty_students') + '\n';
      }
      if (errors !== '') {
        this.makeAlert(errors);
        return false;
      }
      return true;
    },

    showEmptyLectionModal() {
      this.alertEmptyLectionModal = true;
    },

    hideEmptyLectionModal() {
      this.alertEmptyLectionModal = false;
    },

    showDropdown(modal) {
      this[modal] = !this[modal] === true;
      switch(modal) {
        case 'dropdownCourses':
          this.dropdownStudents = false;
          this.dropdownLections = false;
          break;
        case 'dropdownStudents':
          this.dropdownCourses = false;
          this.dropdownLections = false;
          break;
        case 'dropdownLections':
          this.dropdownCourses = false;
          this.dropdownStudents = false;
          break;
      }
    },

    selectAllStudents() {
      this.allLectureStudents = !this.allLectureStudents === true;
      if (this.allLectureStudents) {
        const selected = this.allStudents.map(u => u.id);
        this.students = selected;
      } else {
        this.students = [];
        this.setStudents();
      }
      if (this.allLectureStudents) {
        this.count_students_text = this.$t('buttons.all_students');
      } else {
        this.countStudents();
      }
    },

    getTaskData() {
      this.GET_TASK({
        task_id: this.$router.history.current.params.task_id
      })
        .then(() => {
          this.title = this.getTask.task.title;
          this.points = this.getTask.task.points;
          this.description = this.getTask.task.description;
          if (this.getTask.task.course.id) {
            this.courses = this.getTask.task.course.id;
            this.chooseCourse();
          }
          if (this.getTask.task.lecture.id) {
            this.lections = this.getTask.task.lecture.id;
            this.chooseLection();
          }
          if (this.getTask.task.students) {
            this.set_students = this.students = this.getTask.task.students.map(
              function(student) {
                return student.id;
              }
            );
            this.countStudents();
          }
          this.deadline_date = this.toInputDateFormat(
            this.getTask.task.deadline,
            'date'
          );
          this.deadline_time = this.toInputDateFormat(
            this.getTask.task.deadline,
            'time'
          );
        })
        .catch(error => {
          console.log(error);
        });
    },

    countStudents() {
      let text = this.getCountStudentsText(this.students.length);
      this.count_students_text = this.students.length
        ? this.students.length + ' ' + text
        : this.$t('buttons.choose_students');
    },

    chooseCourse() {
      this.choose_course_text = this.courses
        ? this.GetCourses.find(course => course.id === this.courses).title
        : this.$t('lectures.choose_course');
      this.filterByCourse();
    },

    chooseLection() {
      this.choose_lection_text = this.lections
        ? this.getLections.find(lection => lection.id === this.lections).title
        : this.$t('tasks.add_lecture');
    },

    filterByCourse() {
      this.allStudents = this.filteredStudents;
      this.allLections = this.filteredLections;
      this.lections = 0;
      this.students = [];
      this.chooseLection();
      this.countStudents();
    },

    pointsValidation() {
      if (this.points > 100) {
        this.points = 100;
      } else if (this.points < 1) {
        this.points = 1;
      }
    },

    setStudents() {
      if (this.editTask) {
        let students = new Set();
        this.set_students.map(id => {
          students.add(id);
        });
        this.students.map(id => {
          students.add(id);
        });
        this.students = Array.from(new Set(students));
      }
    },

    checkSettedStudent(student_id) {
      return this.set_students.includes(student_id);
    }
  },

  mounted() {
    if (this.$router.history.current.params.task_id) {
      this.editTask = true;
    }
    this.getData();
    this.h3 = this.editTask ? this.$t('tasks.edit_task') : this.$t('tasks.add_task');
    this.button = this.editTask ? this.$t('buttons.post_changes') : this.$t('buttons.send');
    this.count_students_text = this.$t('buttons.choose_students');
    this.choose_course_text = this.$t('lectures.choose_course');
    this.choose_lection_text = this.$t('tasks.add_lecture');
    this.modal_text = this.editTask
      ? this.$t('tasks.sure_change')
      : this.$t('tasks.no_lecture');
  }
};
</script>
<style>
.centered {
  display: block;
  margin-left: auto;
  margin-right: auto;
}
.centered_text {
  text-align: center;
}
.bottom {
  position: absolute;
  bottom: 0;
}
</style>
