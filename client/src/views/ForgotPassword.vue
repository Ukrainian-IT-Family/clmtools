<template>
  <section class="mt-4">
    <div class="d-flex justify-content-center">
      <div class="box shadow-box w-50">
        <h3 class="text-center mb-4">{{ $t("auth.password_forgot") }}</h3>
        <p class="text-center h5 mb-4">
          {{ $t("auth.will_send") }}
        </p>
        <BAlert show variant="success" v-if="validated"
          >{{ $t("auth.already_send") }}</BAlert
        >
        <form
          class="form needs-validation"
          @submit="onSubmit"
          :class="{ 'was-validated': validated }"
          novalidate="true"
        >
          <BFormGroup>
            <BFormInput
              id="input-email"
              v-model="user.email"
              name="email"
              :placeholder="$t('auth.email')"
              required
            ></BFormInput>
          </BFormGroup>
          <BAlert show variant="danger" v-if="errors.email">{{
            Object.values(errors.email).join('\r\n')
          }}</BAlert>

          <p class="text-right">
            <RouterLink class="link link-signup" :to="{ name: 'auth.signIn' }">
              {{ $t("auth.back_to_login") }}
            </RouterLink>
          </p>

          <BButton block type="submit">
            {{ $t("auth.send") }}
          </BButton>
        </form>
      </div>
    </div>
  </section>
</template>

<script>
import { mapActions } from 'vuex';
import { FORGOT_PASSWORD } from '../store/modules/auth/types/actions';
export default {
  name: 'ForgotPasswordPage',

  data: () => ({
    user: {
      email: ''
    },
    validated: false,
    errors: {}
  }),

  methods: {
    ...mapActions('auth', ['FORGOT_PASSWORD']),

    onSubmit(e) {
      e.preventDefault();
      this.FORGOT_PASSWORD(this.user)
        .then(() => {
          this.validated = true;
          this.errors = {};
        })
        .catch(error => {
          this.validated = false;
          this.errors = error.response.data.errors;
        });
    }
  }
};
</script>
