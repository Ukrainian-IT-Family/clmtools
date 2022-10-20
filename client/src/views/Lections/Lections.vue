<template>
  <div class="row-fluid card example-1 square scrollbar-grey bordered-grey">
    <LecturertLectionMenu v-if="isLecturer" />
    <h3>{{ $t("lectures.lectures") }}</h3>
    <RouterLink
      class="nav-link text-dark"
      :to="{ name: 'add.lection' }"
      v-if="isLecturer"
    >
      <button class="btn btn-info float-right">
        {{ $t("lectures.add_lecture") }}
      </button>
    </RouterLink>
    <ul class="thumbnails card-body">
      <li
        class="span4"
        v-for="lection in getLections"
        v-bind:key="lection.id"
        @click="onLectionClick(lection)"
      >
        <div class="thumbnail">
          <img
            data-src="holder.js/150x150"
            alt="150x150"
            :src="lection.image"
            style="width: 150px; height: 150px;"
          />
          <div class="caption">
            <RouterLink
              class="nav-link text-dark position-absolute end-0"
              :to="{ name: 'edit.lection', params: { lection_id: lection.id } }"
              v-if="isLecturer"
            >
              <button class="btn btn-info float-right">
                {{ $t("buttons.edit") }}
              </button>
            </RouterLink>
            <h3>{{ lection.title }}</h3>
            <p v-if="isLecturer">{{ $t("courses.course") }}: {{ lection.course }}</p>
            <p>{{ $t("buttons.added") }}: {{ lection.created_at }}</p>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import LecturertLectionMenu from '@/components/common/LecturertLectionMenu.vue';

export default {
  name: 'Lections',

  components: {
    LecturertLectionMenu
  },

  computed: {
    ...mapGetters('auth', ['getAuthenticatedUser', 'isLecturer']),
    ...mapGetters('lections', ['getLections'])
  },

  methods: {
    ...mapActions('lections', ['GET_LECTIONS']),

    getUserLections() {
      this.GET_LECTIONS({ user_id: this.getAuthenticatedUser.id })
        .then(() => {})
        .catch(error => {
          if (error.response.data.errors) {
              console.log(Object.values(error.response.data.errors).join('\r\n'));
          }
        });
    },

    onLectionClick(lection) {
      if (!this.isLecturer) {
        this.$router
          .push({ name: 'detail.lection', params: { lection_id: lection.id } })
          .catch(() => {});
      }
    }
  },

  mounted() {
    if (this.getAuthenticatedUser.id) {
      this.getUserLections();
    }
  }
};
</script>

<style>
.span4,
.thumbnail {
  display: flex;
}
ul.thumbnails {
  display: inline;
}
</style>
