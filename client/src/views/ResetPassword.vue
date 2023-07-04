<template>
  <section class="mt-30 auth-page">
    <div class="d-flex justify-content-center">
      <div class="box shadow-box w-auth">
        <h3 class="text-center mb-30 p-0">{{ $t("auth.password_restore") }}</h3>

        <form
          class="needs-validation"
          :class="{ 'was-validated': validated }"
          @submit.prevent="onSubmit"
          novalidate="true"
        >
          <BAlert show variant="success" v-if="validated"
            >{{ $t("auth.password_changed") }}</BAlert
          >
          <BAlert show variant="danger" v-if="errors.message">{{
            errors.message
          }}</BAlert>

          <BAlert show variant="danger" v-if="errors.password">{{
            Object.values(errors.password).join('\r\n')
          }}</BAlert>

          <BFormGroup>
            <BFormInput
              id="input-password"
              v-model="user.password"
              name="password"
              type="password"
              :placeholder="$t('auth.new_password')"
              required
            ></BFormInput>
          </BFormGroup>

          <BFormGroup>
            <BFormInput
              id="input-passwordConfirmation"
              v-model="user.passwordConfirmation"
              name="password_confirmation"
              type="password"
              :placeholder="$t('auth.password_confirmation')"
              required
            ></BFormInput>
          </BFormGroup>

          <BButton block type="submit">
            {{ $t("auth.password_change") }}
          </BButton>
        </form>
      </div>
    </div>
  </section>
</template>

<script>
import { mapActions } from 'vuex';
import { RESET_PASSWORD } from '../store/modules/auth/types/actions';

export default {
  name: 'ResetPasswordPage',

  data: () => ({
    user: {
      password: '',
      passwordConfirmation: ''
    },
    validated: false,
    errors: {}
  }),

  methods: {
    ...mapActions('auth', ['RESET_PASSWORD']),

    onSubmit() {
      this.RESET_PASSWORD({
        token: this.$route.params.token,
        email: this.$route.params.email,
        password: this.user.password,
        passwordConfirmation: this.user.passwordConfirmation
      })
        .then(() => {
          this.validated = true;
          this.errors = {};

          setTimeout(() => {
            this.$router.push({ name: 'auth.signIn' }).catch(() => {});
          }, 2000);
        })
        .catch(error => {
          this.validated = false;
          this.errors = error.response.data.error;

          if (error.response.data.errors) {
            this.errors = error.response.data.errors;
          }
        });
    }
  }
};
</script>
