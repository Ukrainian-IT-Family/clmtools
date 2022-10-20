<template>
  <div class="row-fluid card example-1 square scrollbar-grey bordered-grey">
    <h3>{{ $t("tasks.tasks") }}</h3>
    <RouterLink
      class="nav-link text-dark"
      :to="{ name: 'add.task' }"
      v-if="isLecturer"
    >
      <button class="btn btn-info float-right">
        {{ $t("tasks.create_task") }}
      </button>
    </RouterLink>
    <ul class="thumbnails card-body">
      <li
        class="span4"
        v-for="task in GET_ALL_TASKS"
        v-bind:key="task.id"
      >
        <div class="thumbnail">
          <div class="caption">
            <h3>{{ task.title }}</h3>
            <p>{{ $t("buttons.published") }}: {{ task.date }}</p>
            <p>{{ $t("courses.course") }}: {{ task.course.title }}</p>
              <div class="nav-link text-dark position-absolute end-0 toped">
                  <div class="float-right counts ml-auto">
                      <h2>{{ task.rated.length }}</h2><br>{{ $t("tasks.rated") }}
                  </div>
                  <div class="float-right counts ml-auto">
                      <h2>{{ task.students.length }}</h2><br>{{ $t("tasks.assigned") }}
                  </div>
                  <div class="float-right counts ml-auto">
                      <h2>{{ task.passed.length }}</h2><br>{{ $t("tasks.passed") }}
                  </div>
                  <div class="float-right mr-5">
                      <h4>{{ $t("tasks.deadline") }}:<br>{{ task.deadline }}</h4>
                  </div>
              </div>
              <RouterLink :to="{ name: 'detail.task', params: { task_id: task.id } }">
                  <button class="btn btn-info">
                    {{ $t("buttons.detail") }}
                  </button>
              </RouterLink>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'Tasks',

  computed: {
    ...mapGetters('auth', ['getAuthenticatedUser', 'isLecturer']),
    ...mapGetters('tasks', ['GET_ALL_TASKS'])
  },

  methods: {
    ...mapActions('tasks', ['GET_TASKS']),

    getUserTasks() {
      this.GET_TASKS()
        .then(() => {})
        .catch(error => {
          if (error.response.data.errors) {
              console.log(Object.values(error.response.data.errors).join('\r\n'));
          }
        });
    },
  },

  mounted() {
    this.getUserTasks();
  }
};
</script>
