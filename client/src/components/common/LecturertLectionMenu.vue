<template>
  <div class="col-lg-3">
    <ul class="nav nav-link-secondary flex-column">
      <li class="nav-item flex">
        <RouterLink class="nav-link text-dark" :to="'lections'"
          >{{ $t("lectures.lectures") }}</RouterLink
        >
        <RouterLink class="nav-link text-dark" :to="'tasks'"
          >{{ $t("tasks.tasks") }}</RouterLink
        >
        <RouterLink class="nav-link text-dark" :to="'more-info'"
          >{{ $t("chat.chat") }}</RouterLink
        >
      </li>
    </ul>
  </div>
</template>

<style>
.flex {
  display: flex;
}
</style>
