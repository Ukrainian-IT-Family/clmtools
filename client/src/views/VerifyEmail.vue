<template>
  <div class="modal bg-dark bg-opacity-40" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $t("auth.email_confirm") }}</h5>
        </div>
        <div class="modal-body">
          <p v-text="message"></p>
        </div>
        <div class="modal-footer">
          <button
            v-show="expired"
            type="button"
            class="btn btn-secondary"
            @click="reSend"
          >
            {{ $t("auth.resend") }}
          </button>
          <RouterLink
            class="link link-signup"
            to="/auth/sign-in"
            v-show="checked"
          >
            <button type="button" class="btn btn-secondary">
              {{ $t("auth.go_to_login") }}
            </button>
          </RouterLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import {
  RESEND_VERIFY_EMAIL,
  VERIFY_EMAIL
} from '../store/modules/auth/types/actions';

export default {
  name: 'VerifyEmail',

  data: () => ({
    message: null,
    expired: false,
    url: null,
    registered_user_id: null,
    checked: false
  }),

  methods: {
    ...mapActions('auth', ['VERIFY_EMAIL', 'RESEND_VERIFY_EMAIL']),
    ...mapActions([
      'makeAlert'
    ]),

    reSend() {
      this.RESEND_VERIFY_EMAIL({ id: this.registered_user_id })
        .then(() => {
          this.makeAlert(this.$t("auth.resended"));
        })
        .catch(error => {
          if (error.response.data.errors) {
            this.makeAlert(Object.values(error.response.data.errors).join('\r\n'));
          }
        });
    }
  },
  mounted() {
    this.registered_user_id = this.$router.history.current.params.user_id;
    let params = new URLSearchParams(this.$router.history.current.query);
    this.url = this.registered_user_id + '?' + params.toString();
    this.message = this.$t("auth.check");
    this.VERIFY_EMAIL({ url: this.url })
      .then(() => {
        this.message = this.$t("auth.thanks");
        this.checked = true;
      })
      .catch(error => {
        console.log(error);
        this.expired = error.response.data.error.code === 401;
        this.message = error.response.data.error.message;
      });
  }
};
</script>

<style>
.modal {
  display: block;
}
</style>
