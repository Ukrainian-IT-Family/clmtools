<template>
    <div class="container">
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 box-shadow" v-for="course in GetCourses" v-bind:key="course.id">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">{{ course.title }}</h4>
                </div>
                <div class="card-body">
                    <p>{{ $t("courses.created") }} {{ course.date }}</p>
                    <p>{{ $t("courses.users") }} {{ course.students.length }}</p>
                    <RouterLink :to="{ name: 'edit.course', params: { course_id: course.id }}">
                        <button class="btn btn-lg btn-block btn-outline-primary">
                          {{ $t("buttons.detail") }}
                        </button>
                    </RouterLink>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
    name: "Courses",

    computed: {
        ...mapGetters('courses', [
            'GetCourses',
        ]),
    },

    methods: {
        ...mapActions('courses', [
            'GET_COURSES',
        ]),

        getUserCourses(){
            this.GET_COURSES()
                .then(() => {
                    this.$parent.h1 = this.$t("courses.courses");
                })
                .catch((error) => {
                    console.log(error);
                } );
        },
    },

    mounted() {
        this.getUserCourses();
    },
};
</script>
<style>
.card-deck .card {
    flex: auto;
    margin-right: 15px;
    margin-bottom: 0;
    margin-left: 15px;
}
</style>
