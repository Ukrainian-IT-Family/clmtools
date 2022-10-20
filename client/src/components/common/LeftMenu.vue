<template>
  <div class="col-lg-3">
    <h4 class="mt-5 font-weight-bold text-center">{{ $t("index.menu") }}</h4>
    <ul class="nav nav-link-secondary flex-column">
      <li class="nav-item">
        <RouterLink class="nav-link text-dark" :to="'/lections'"
          >{{ $t("lectures.lectures") }}</RouterLink
        >
        <RouterLink
          v-if="isStudent"
          class="nav-link text-dark"
          :to="{ name: 'student.tasks'}"
          >{{ $t("tasks.tasks") }}</RouterLink>
        <RouterLink
          v-if="isLecturer"
          class="nav-link text-dark"
          :to="{ name: 'Tasks'}"
        >{{ $t("tasks.tasks") }}</RouterLink>
        <RouterLink v-if="isLecturer" class="nav-link text-dark" :to="'/chat'"
          >{{ $t("chat.chat") }}</RouterLink>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  name: 'Navbar',
  computed: {
    ...mapGetters('auth', ['isStudent', 'isLecturer'])
  }
};
</script>
