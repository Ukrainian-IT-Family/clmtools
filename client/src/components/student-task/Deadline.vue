<template>
  <p class="position-absolute bottom-0 end-0 nav-link" v-text="deadline"></p>
</template>
<script>
import { mapGetters, mapActions } from 'vuex';
import methods from '@/components/methods/methods';

export default {
  name: 'Modals',

  mixins: [methods],

  props: ['taskId'],

  data: () => ({
    deadline: ''
  }),

  computed: {
    ...mapGetters('studentTasks', [
      'GET_TASK_ELEMENT',
        ])
  },
  methods: {
    ...mapActions('studentTasks', [
      'GET_SINGLE_TASK'
    ]),

    setDeadline(deadlineRow) {
      let today = new Date();
      let deadline = this.convertStringToDateFormat(deadlineRow);
      let dDate = deadline.getDate() < 10 ? '0' + deadline.getDate() : deadline.getDate(),
          dMonth = (deadline.getMonth() + 1) < 10 ? '0' + (deadline.getMonth() + 1) : deadline.getMonth() + 1,
          dYear = deadline.getFullYear(),
          dHour = deadline.getHours() < 10 ? '0' + deadline.getHours() : deadline.getHours(),
          dMinute = deadline.getMinutes() < 10 ? '0' + deadline.getMinutes() : deadline.getMinutes();

      if (today > deadline) {
        this.deadline = this.$t("tasks.deadline_end") + ' ' + this.whenWasDeadline(deadline);
      } else {
        this.deadline = this.$t("tasks.deadline") + ' : '+ dDate +'.'+ dMonth +'.'+ dYear +' ' + this.$t("buttons.time") + ' '+ dHour +':' + dMinute;
      }
    }
  },
  mounted() {
    this.GET_SINGLE_TASK({
      task_id: this.taskId
    })
        .then(() => {
          this.setDeadline(this.GET_TASK_ELEMENT.deadline);
        })
        .catch((error) => {
          console.log(error);
        } );
  }
};
</script>
