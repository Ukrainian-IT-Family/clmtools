<template>
  <div class="row-fluid card example-1 square scrollbar-grey bordered-grey">
    <div class="d-flex">
      <RouterLink class="nav-link text-dark" :to="{ name: 'lections' }">
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
        style="margin-right: 100px"
      ></button>
      <button
        v-if="editLection"
        @click="showDeleteModal()"
        class="position-absolute end-0 btn btn-danger"
      >
        {{ $t("buttons.clear") }}
      </button>
    </div>
    <div v-if="errors" class="alert-danger alert" v-text="errors"></div>
    <form onsubmit="onSubmitForm" class="d-sm-flex">
      <div>
        <div class="form-group">
          <input
            type="text"
            v-model="title"
            class="form-control add-form-control"
            :placeholder="$t('lectures.lecture_name')"
          />
          <textarea
            v-model="description"
            class="form-control add-form-control"
            rows="3"
            :placeholder="$t('lectures.lecture_desc')"
          ></textarea>
        </div>
        <div class="form-group">
          <label for="FormControlInput2">{{ $t('lectures.url') }}</label>
          <div class="d-sm-flex">
            <input
              type="text"
              name="title"
              class="form-control add-form-control"
              id="FormControlInput2"
              placeholder="https://www.youtube.com/watch?v=yVX9dFJRbu8"
              v-model="youtubeURL"
            />
            <a @click="loadURL()">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                <path
                  d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7C401.8 87.79 326.8 13.32 235.2 1.723C99.01-15.51-15.51 99.01 1.724 235.2c11.6 91.64 86.08 166.7 177.6 178.9c53.8 7.189 104.3-6.236 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 0C515.9 484.7 515.9 459.3 500.3 443.7zM79.1 208c0-70.58 57.42-128 128-128s128 57.42 128 128c0 70.58-57.42 128-128 128S79.1 278.6 79.1 208z"
                />
              </svg>
            </a>
          </div>
        </div>
        <div v-if="youtubePreview" class="form-group d-flex">
          <img :src="youtubePreview" width="200" height="150" />
          <a @click="clearURL()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
              <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
              <path
                d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"
              />
            </svg>
          </a>
        </div>
      </div>

        <div class="ml-5 mr-5">
            <div class="form-group">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle max-width cut-text" type="button" @click="showDropdown('dropdownCourses')" v-text="choose_course_text">
                    </button>
                    <div class="dropdown-menu" v-show="dropdownCourses">
                        <div class="form-check dropdown-item" v-for="course in GetCourses" v-bind:key="course.id" >
                            <label class="form-check-label">
                                <input class="form-check-input" v-model="courses" type="radio" :value="course.id" @change="chooseCourse">
                                {{ course.title }}
                            </label>
                        </div>
                        <button class="btn btn-secondary" type="button" @click="showDropdown('dropdownCourses')">
                            {{ $t('buttons.save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="ml-5">
            <div class="form-group">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle max-width" type="button" @click="showDropdown('dropdownStudents')" v-text="count_students_text">
                    </button>
                    <div class="dropdown-menu" v-show="dropdownStudents">
                        <div class="form-check dropdown-item" v-show="allStudents.length">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" @click="selectAllStudents()" >
                              {{ $t('buttons.all_students') }}
                            </label>
                        </div>
                        <div class="form-check dropdown-item" v-for="student in allStudents" v-bind:key="student.id">
                            <label class="form-check-label" :checked="allLectureStudents">
                                <input class="form-check-input" @change="countStudents"  v-model="students" type="checkbox" :value="student.id" :checked="allLectureStudents">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"/></svg>
                                {{ student.name }} {{ student.last_name }}
                            </label>
                        </div>
                        <button class="btn btn-secondary" type="button" @click="showDropdown('dropdownStudents')">
                          {{ $t('buttons.save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
        <div
          class="modal preview_modal"
          tabindex="-1"
          role="dialog"
          v-show="showModal"
        >
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <i
                  class="fa-solid fa-arrow-left-long modal_i"
                  @click="hideVideoModal()"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                      d="M9.375 233.4l128-128c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H480c17.69 0 32 14.31 32 32s-14.31 32-32 32H109.3l73.38 73.38c12.5 12.5 12.5 32.75 0 45.25c-12.49 12.49-32.74 12.51-45.25 0l-128-128C-3.125 266.1-3.125 245.9 9.375 233.4z"
                    />
                  </svg>
                </i>
                <h5 class="modal-title">{{ $t('lectures.preview') }}</h5>
              </div>
              <div class="modal-body">
                <iframe
                  id="youtube_embed"
                  width="460"
                  height="255"
                  :src="result"
                  frameborder="0"
                  allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen
                ></iframe>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="setVideo()">
                  {{ $t('lectures.add_video') }}
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
                      <h5 class="modal-title">{{ $t('buttons.warning') }}</h5>
                      <i class="fa-solid fa-arrow-left-long" @click="hideDeleteModal()">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                              <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                              <path
                                  d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"
                              />
                          </svg>
                      </i>
                  </div>
                  <div class="modal-body">
                      <p>{{ $t('lectures.delete_lecture') }}</p>
                  </div>
                  <div class="modal-footer">
                      <button
                          type="button"
                          class="btn btn-primary"
                          @click="onDeleteLection()"
                      >
                        {{ $t('buttons.yes_delete') }}
                      </button>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import constants from '/src/services/Constants.js';
import methods from '@/components/methods/methods';

export default {
  name: 'AddLection',

    mixins: [methods],

    computed: {
        ...mapGetters('lections', [
            'getLection'
        ]),
        ...mapGetters('courses', [
            'GetCourses',
        ]),
        ...mapGetters('users', [
            'GetStudents',
        ]),
      filteredStudents() {
        return this.GetStudents.filter(item => {
          return item.course_id === this.courses;
        });
      }
    },

      data() {
        return {
          title: '',
          description: '',
          courses: '',
          students: [],
          allStudents: [],
          youtubeURL: '',
          youtubeId: '',
          result: '',
          youtubeLink: '',
          youtubePreview: null,
          showModal: false,
          dropdownCourses: false,
          dropdownStudents: false,
          allLectureStudents: false,
          errors: '',
          editLection: false,
          h3: '',
          button: '',
          count_students_text: '',
          choose_course_text: '',
          showDelete: false
        };
      },

    methods: {
        ...mapActions('lections', [
            'ADD_LECTION',
            'GET_LECTION',
            'EDIT_LECTION',
            'DELETE_LECTION'
        ]),
        ...mapActions('courses', [
            'GET_COURSES',
        ]),
        ...mapActions([
            'makeAlert'
        ]),

        getData(){
            this.GET_COURSES()
                .then(() => {})
                .catch((error) => {
                    if (error.response.data.errors) {
                        console.log(Object.values(error.response.data.errors).join('\r\n'));
                    }
                } );
        },

    onSubmitForm() {
      if (this.validationForm()) {
        if (this.editLection) {
          this.EDIT_LECTION({
            lection_id: this.$router.history.current.params.lection_id,
            title: this.title,
            description: this.description,
            link: this.youtubeLink,
            courses: this.courses,
            students: this.students
          })
            .then(() => {
              this.makeAlert(this.$t('lectures.lecture') + ' ' + this.title + ' ' + this.$t('lectures.updated'));
              this.$router.push({ name: 'lections' }).catch(() => {});
            })
            .catch(error => {
              if (error.response.data.errors) {
                this.errors = Object.values(error.response.data.errors).join(
                  '\r\n'
                );
              }
            });
        } else {
          this.ADD_LECTION({
            title: this.title,
            description: this.description,
            link: this.youtubeLink,
            courses: this.courses,
            students: this.students
          })
            .then(() => {
              this.makeAlert(this.$t('lectures.lecture') + ' ' + this.title + ' ' + this.$t('lectures.added'));
              this.$router.push({ name: 'lections' }).catch(() => {});
            })
            .catch(error => {
              if (error.response.data.errors) {
                this.errors = Object.values(error.response.data.errors).join(
                  '\r\n'
                );
              }
            });
        }
      }
    },

    validationForm() {
      let errors = '';
      if (!this.title) {
        errors += this.$t("errors.empty_name") + '\n';
      }
      if (!this.youtubePreview) {
        errors += this.$t("errors.empty_video") + '\n';
      }
      if (this.courses.length === 0) {
        errors += this.$t("errors.empty_course") + '\n';
      }
      if (this.students.length === 0) {
        errors += this.$t("errors.empty_students") + '\n';
      }
      if (errors !== '') {
        this.makeAlert(errors);
        return false;
      }
      return true;
    },

    showVideoModal() {
      this.showModal = true;
    },

    hideVideoModal() {
      this.showModal = false;
      this.stopVideo();
    },

    showDropdown(modal) {
      this[modal] = !this[modal] === true;
      if (modal === 'dropdownCourses') {
        this.dropdownStudents = false;
      } else {
        this.dropdownCourses = false;
      }
    },

    selectAllStudents() {
      this.allLectureStudents = !this.allLectureStudents === true;
      this.count_students_text = this.allLectureStudents ? this.$t("buttons.all_students") : this.$t("buttons.choose_students");
      if (this.allLectureStudents) {
        const selected = this.allStudents.map((u) => u.id);
        this.students = selected;
      } else {
        this.students = [];
      }
    },

    setVideo() {
      this.hideVideoModal();
      this.youtubePreview =
        constants.youtube.imgPathStart +
        this.youtubeId +
        constants.youtube.imgPathEnd;
    },

    loadURL() {
      const url = this.youtubeURL.split(
        /(vi\/|v%3D|v=|\/v\/|youtu\.be\/|\/embed\/)/
      );
      const YId =
        undefined !== url[2] ? url[2].split(/[^0-9a-z_/\\-]/i)[0] : url[0];
      if (YId === url[0]) {
        this.makeAlert(this.$t("errors.incorrect_video"));
      } else {
        this.youtubeId = YId;
        this.youtubeLink = this.youtubeURL;
        this.result = constants.youtube.embedTemplate.concat(YId);
        this.showVideoModal();
      }
    },

    getLectionData() {
      this.GET_LECTION({
        lection_id: this.$router.history.current.params.lection_id
      })
        .then(() => {
          this.title = this.getLection.lection.title;
          this.youtubeURL = this.getLection.lection.link;
          this.description = this.getLection.lection.description;
          if (this.getLection.lection.course_id) {
            this.courses = this.getLection.lection.course_id;
          }
          this.chooseCourse();
          if (this.getLection.lection.students) {
            this.students = this.getLection.lection.students;
          }
          this.countStudents();
          this.loadURL();
          this.setVideo();
        })
        .catch(error => {
          if (error.response.data.errors) {
            console.log(Object.values(error.response.data.errors));
          }
        });
    },

    countStudents() {
      let text = this.getCountStudentsText(this.students.length);
      this.count_students_text = this.students.length
        ? this.students.length + ' ' + text
        : this.$t("buttons.choose_students");
    },

    chooseCourse() {
      this.choose_course_text = this.courses
        ? this.GetCourses.find(course => course.id === this.courses).title
        : this.$t("lectures.choose_course");
      this.filterByCourse();
    },

    filterByCourse() {
      this.allStudents = this.filteredStudents;
      this.students = [];
      this.countStudents();
    },

    onDeleteLection() {
      this.hideDeleteModal();
      this.DELETE_LECTION({
        lection_id: this.$router.history.current.params.lection_id
      })
        .then(() => {
          this.makeAlert(this.$t("lectures.lecture") + ' ' + this.title + ' ' + this.$t("lectures.deleted"));
          this.$router.push({ name: 'lections' }).catch(() => {});
        })
        .catch(error => {
          if (error.response.data.errors) {
              console.log(Object.values(error.response.data.errors).join('\r\n'));
          }
        });
    },

    clearURL() {
      this.youtubePreview = null;
      this.youtubeId = this.youtubeLink = this.result = this.youtubeURL = '';
    },

    showDeleteModal() {
      this.showDelete = true;
    },

    hideDeleteModal() {
      this.showDelete = false;
    },

    stopVideo() {
      let video = document.getElementById("youtube_embed");
      let link = video.src;
      video.src = link;
    }
  },

  mounted() {
    this.getData();
    if (this.$router.history.current.params.lection_id) {
      this.editLection = true;
      this.getLectionData();
    }
    this.h3 = this.editLection ? this.$t("lectures.lecture_edit") : this.$t("lectures.lecture_add");
    this.button = this.editLection ? this.$t("buttons.post_changes") : this.$t("buttons.post");
    this.count_students_text = this.$t("buttons.choose_students");
    this.choose_course_text = this.$t("lectures.choose_course");
  }
};
</script>
