<template>
  <main role="main" class="container">
    <div class="d-flex">
      <StudentLectionMenu />
      <Deadline v-if="task_id" :taskId='task_id'></Deadline>
    </div>
    <div class="starter-template">
      <h2 v-text="title">Bootstrap starter template</h2>
      <p class="lead" v-text="description"></p>
      <iframe
        v-if="link"
        width="560"
        height="315"
        :src="link"
        title="YouTube video player"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen
      >
      </iframe>
    </div>
  </main>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import StudentLectionMenu from '@/components/common/StudentLectionMenu.vue';
import constants from '/src/services/Constants.js';
import Deadline from '@/components/student-task/Deadline.vue';

export default {
  name: 'DetailLection',

  components: {
    StudentLectionMenu,
    Deadline
  },

  data: function() {
    return {
      title: null,
      link: null,
      description: '',
      task_id: ''
    };
  },

  computed: {
    ...mapGetters('lections', ['getLection'])
  },

  methods: {
    ...mapActions('lections', ['GET_LECTION']),

    loadURL(video_url) {
      const url = video_url.split(/(vi\/|v%3D|v=|\/v\/|youtu\.be\/|\/embed\/)/);
      const YId =
        undefined !== url[2] ? url[2].split(/[^0-9a-z_/\\-]/i)[0] : url[0];
      if (YId === url[0]) {
        return this.getLection.lection.link;
      }

      return constants.youtube.embedTemplate.concat(YId);
    }
  },
  mounted() {
    this.GET_LECTION({
      lection_id: this.$router.history.current.params.lection_id
    })
      .then(() => {
        this.title = this.getLection.lection.title;
        this.link = this.loadURL(this.getLection.lection.link);
        this.description = this.getLection.lection.description;
        this.task_id = this.getLection.lection.task_id;
      })
      .catch(error => {
        if (error.response.data.errors) {
            console.log(Object.values(error.response.data.errors).join('\r\n'));
        }
      });
  }
};
</script>

<style>
.modal {
  display: block;
}
</style>
