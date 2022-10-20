<template>
    <div>
        <h1 v-text="h1" class="mt-5 font-weight-bold text-primary"></h1>
        <Courses v-if="isLecturer" />
        <Admin v-if="isAdmin" />
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Courses from './Courses/Courses';
import Admin from './Admin';

export default {
    name: 'IndexPage',
    computed: {
        ...mapGetters('auth', {
            isLecturer: 'isLecturer',
            isStudent: 'isStudent',
            course: 'getStudentCourse',
            isAdmin: 'isAdmin'
        }),
    },
    components:{
        Courses,
        Admin
    },
    data(){
        return {
            h1: ''
        };
    },
    mounted() {
        if (this.isStudent) {
            this.h1 = this.course ? this.$t("index.student_welcome_course") + this.course + '!' : this.$t("index.student_welcome");
        } else if (this.isLecturer) {
            this.h1 = this.$t("index.lecturer_welcome");
        } else if (this.isAdmin) {
            this.h1 = '';
        } else {
            this.h1 = this.$t("index.null_welcome");
        }
    }
};
</script>
