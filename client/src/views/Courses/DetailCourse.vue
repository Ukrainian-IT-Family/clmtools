<template>
  <div class="container">
    <div v-if="errors" class="alert-danger alert" v-text="errors"></div>
    <hr />
    <RouterLink class="nav-link text-dark" :to="{ name: 'Index' }">
      <i class="fa-solid fa-arrow-left-long">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
          <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
          <path
            d="M9.375 233.4l128-128c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H480c17.69 0 32 14.31 32 32s-14.31 32-32 32H109.3l73.38 73.38c12.5 12.5 12.5 32.75 0 45.25c-12.49 12.49-32.74 12.51-45.25 0l-128-128C-3.125 266.1-3.125 245.9 9.375 233.4z"
          />
        </svg>
      </i>
    </RouterLink>
    <button
      class="btn btn-secondary float-right"
      type="button"
      @click="showDeleteModal()"
    >
      {{ $t("courses.delete_course") }}
    </button>
    <h1>{{ title }}</h1>
    <hr />
    <h3>{{ $t("courses.lecturer") }}</h3>
    <hr />
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
      <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
      <path
        d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"
      />
    </svg>
    {{ getFullName }}
    <div class="flex-column">
      <h3 class="detail">
        {{ $t("buttons.students") }}
        <svg
          class="float-right mb-3"
          @click="showCourseModal()"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 640 512"
        >
          <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
          <path
            d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"
          />
        </svg>
        <span class="float-right mr-5 mb-3 smaller-text"
          >{{ students.length }} {{ coutsStudents }}</span
        >
      </h3>
    </div>
    <hr />
    <div v-if="GetCourse">
      <div
        class="students"
        v-for="(student, index) in GetCourse.students"
        v-bind:key="student.id"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
          <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
          <path
            d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"
          />
        </svg>
        {{ student.name }} {{ student.last_name }}
        <div class="float-right" @click="showUserDeleteModal(index)">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
            <path
              d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128H416L394.8 466.1z"
            />
          </svg>
        </div>
      </div>
    </div>
    <div
      class="modal preview_modal"
      tabindex="-1"
      role="dialog"
      v-show="addCourseModal"
    >
      <div class="modal-dialog one-column" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <i class="fa-solid fa-arrow-left-long" @click="hideCourseModal()">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                <path
                  d="M9.375 233.4l128-128c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H480c17.69 0 32 14.31 32 32s-14.31 32-32 32H109.3l73.38 73.38c12.5 12.5 12.5 32.75 0 45.25c-12.49 12.49-32.74 12.51-45.25 0l-128-128C-3.125 266.1-3.125 245.9 9.375 233.4z"
                />
              </svg>
            </i>
            <h5 class="modal-title">{{ $t("courses.add_students") }}</h5>
          </div>
          <div class="modal-body mx-auto" v-if="allStudents">
            <div class="form-check dropdown-item">
              <label class="form-check-label">
                <input
                  type="text"
                  v-model="search"
                  :placeholder="$t('courses.student_name')"
                />
              </label>
            </div>
            <hr />
            <div
              class="form-check dropdown-item"
              v-for="student in filteredStudents"
              v-bind:key="student.id"
            >
              <label class="form-check-label">
                <input
                  class="form-check-input"
                  v-model="students"
                  type="checkbox"
                  :value="student.id"
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
          </div>
          <div class="modal-footer d-flex">
            <button
              type="button"
              class="btn btn-primary"
              @click="hideCourseModal()"
            >
              {{ $t("buttons.cancel") }}
            </button>
            <button
              type="button"
              class="btn btn-primary"
              @click="onUpdateCourse()"
            >
              {{ $t("buttons.create") }}
            </button>
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal preview_modal"
      tabindex="-1"
      role="dialog"
      v-show="showDelete"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ $t("buttons.warning") }}</h5>
            <i class="fa-solid fa-arrow-left-long" @click="hideDeleteModal()">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                <path
                  d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"
                />
              </svg>
            </i>
          </div>
          <div class="modal-body mx-auto">
            <p>{{ $t("courses.sure_delete_course") }}</p>
          </div>
          <div class="modal-footer d-flex mx-auto">
            <button
              type="button"
              class="btn btn-primary"
              @click="hideDeleteModal()"
            >
              {{ $t("buttons.cancel") }}
            </button>
            <button
              type="button"
              class="btn btn-primary"
              @click="onDeleteCourse()"
            >
              {{ $t("buttons.yes_delete") }}
            </button>
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal preview_modal"
      tabindex="-1"
      role="dialog"
      v-show="userDelete"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ $t("buttons.warning") }}</h5>
            <i
              class="fa-solid fa-arrow-left-long"
              @click="hideUserDeleteModal()"
            >
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                <path
                  d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"
                />
              </svg>
            </i>
          </div>
          <div class="modal-body mx-auto">
            <p>{{ $t("courses.delete_student") }}</p>
          </div>
          <div class="modal-footer d-flex mx-auto">
            <button
              type="button"
              class="btn btn-primary"
              @click="hideUserDeleteModal()"
            >
              {{ $t("buttons.cancel") }}
            </button>
            <button
              type="button"
              class="btn btn-primary"
              @click="onDeleteUserFromCourse()"
            >
              {{ $t("buttons.delete") }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import methods from '@/components/methods/methods';

export default {
  name: 'DetailCourse',

  mixins: [methods],

  data: function() {
    return {
      title: '',
      errors: '',
      students: [],
      allStudents: [],
      addCourseModal: false,
      showDelete: false,
      userDelete: false,
      userDeleteIndex: '',
      search: ''
    };
  },

  computed: {
    ...mapGetters('users', ['GetStudents']),
    ...mapGetters('courses', ['GetCourse']),
    ...mapGetters('auth', ['getFullName']),

    filteredStudents() {
      return this.allStudents.filter(item => {
        let full_name = (item.name + ' ' + item.last_name).toLowerCase();
        return full_name.indexOf(this.search.toLowerCase()) > -1;
      });
    },

    coutsStudents() {
      return this.getCountStudentsText(this.students.length);
    }
  },

  methods: {
    ...mapActions('courses', ['GET_COURSE', 'EDIT_COURSE', 'DELETE_COURSE']),
    ...mapActions([
      'makeAlert'
    ]),
    showCourseModal() {
      this.addCourseModal = true;
    },

    hideCourseModal() {
      this.addCourseModal = false;
      this.checkStudents();
    },

    showUserDeleteModal(index) {
      this.userDelete = true;
      this.userDeleteIndex = index;
    },

    hideUserDeleteModal() {
      this.userDelete = false;
    },

    filterStudents() {
      const selected = this.allStudents.map(u => u.id);
      this.students = selected;
    },

    checkStudents() {
      const selected = this.GetCourse.students.map(u => u.id);
      if (selected) {
        this.students = selected;
      }
    },

    getUserCourses() {
      this.GET_COURSE({
        course_id: this.$router.history.current.params.course_id
      })
        .then(() => {
          this.setCourse();
        })
        .catch(error => {
          if (error.response.data.errors) {
            console.log(Object.values(error.response.data.errors).join('\r\n'));
          }
        });
    },

    setCourse() {
      this.title = this.GetCourse.title;
      this.students = this.GetCourse.students;
      this.allStudents = this.GetStudents;
      this.checkStudents();
    },

    showDeleteModal() {
      this.showDelete = true;
    },

    hideDeleteModal() {
      this.showDelete = false;
    },

    onDeleteCourse() {
      this.DELETE_COURSE({
        course_id: this.$router.history.current.params.course_id
      })
        .then(() => {
          this.hideDeleteModal();
          this.makeAlert(this.$t("courses.course") + ' ' + this.title + ' ' + this.$t("message.successfully_deleted"));
          this.$router.push({ name: 'Index' }).catch(() => {});
        })
        .catch(error => {
          if (error.response.data.errors) {
            console.log(Object.values(error.response.data.errors).join('\r\n'));
          }
        });
    },

    onUpdateCourse() {
      this.EDIT_COURSE({
        course_id: this.$router.history.current.params.course_id,
        title: this.title,
        students: this.students
      })
        .then(() => {
          this.hideCourseModal();
          this.makeAlert(this.$t("courses.course") + ' ' + this.title + ' ' + this.$t("message.successfully_updated"));
        })
        .catch(error => {
          if (error.response.data.errors) {
            this.errors = Object.values(error.response.data.errors).join(
              '\r\n'
            );
          }
        });
    },

    onDeleteUserFromCourse() {
      this.students.splice(this.userDeleteIndex, 1);
      this.hideUserDeleteModal();
      this.onUpdateCourse();
    },

    validation() {
      if (this.students.length < 1) {
        this.makeAlert(this.$t("courses.empty_students"));
        this.checkStudents();
        return false;
      }
      return true;
    }
  },
  created() {
    this.getUserCourses();
  }
};
</script>

<style>
h3.detail {
  margin-top: 25px;
}
.students {
  margin-top: 15px;
}
.smaller-text {
  font-size: 20px !important;
}
.one-column {
  max-width: 300px;
}
</style>
