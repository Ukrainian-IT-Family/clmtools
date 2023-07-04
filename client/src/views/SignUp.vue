<template>
  <section class="mt-30 auth-page">
    <div class="d-flex justify-content-center">
      <div class="box shadow-box w-auth">
        <h3 class="text-center mb-30 p-0">{{ $t("auth.registration") }}</h3>
        <form @submit.prevent novalidate="true">

          <BFormGroup>
            <BFormInput
                id="input-name"
                v-model="user.name"
                name="first_name"
                :placeholder="$t('auth.name')"
                autofocus
            ></BFormInput>
          </BFormGroup>

          <BFormGroup>
            <BFormInput
                id="input-lastName"
                v-model="user.lastName"
                name="last_name"
                :placeholder="$t('auth.last_name')"
            ></BFormInput>
          </BFormGroup>

          <BFormGroup>
            <BFormInput
              id="input-email"
              v-model="user.email"
              name="email"
              :placeholder="$t('auth.email')"
            ></BFormInput>
          </BFormGroup>

          <BFormGroup class="mask">
            <BFormInput class="short" readonly="" value="+38"></BFormInput>
            <BFormInput
                id="input-phone"
                v-model="user.phone"
                name="phone"
                :placeholder="$t('auth.phone')"
            ></BFormInput>
          </BFormGroup>

          <BFormGroup>
            <BFormInput
              id="input-password"
              v-model="user.password"
              type="password"
              name="password"
              :placeholder="$t('auth.password')"
            ></BFormInput>
            <p class="auth-alert alert-warning">
              {{ $t("auth.password_warning") }}
            </p>
          </BFormGroup>

          <BFormGroup>
            <BFormInput
              id="input-passwordConfirmation"
              v-model="user.passwordConfirmation"
              type="password"
              name="password_confirmation"
              :placeholder="$t('auth.password_confirmation')"
            ></BFormInput>
          </BFormGroup>

          <p class="mr-32 text-right">
            <RouterLink class="link link-signup" to="/auth/sign-in">
              {{ $t("auth.login") }}
            </RouterLink>
          </p>

          <BButton block @click="onSubmit">
            {{ $t("auth.register") }}
          </BButton>
        </form>
      </div>
    </div>
    <RegistrationModal ref="modal" />
  </section>
</template>

<script>
import { mapActions } from 'vuex';
import RegistrationModal from '@/components/auth/RegistrationModal.vue';
import { USER_REGISTER } from '../store/modules/auth/types/actions';
import Inputmask from 'inputmask';

export default {
  name: 'SignUpPage',

  components: {
    RegistrationModal
  },

  data: () => ({
    user: {
      name: '',
      lastName: '',
      email: '',
      phone: '',
      password: '',
      passwordConfirmation: ''
    }
  }),

  methods: {
    ...mapActions('auth', ['USER_REGISTER']),
    ...mapActions([
      'makeAlert'
    ]),
    showModal() {
      this.$refs.modal.showModal();
    },
    onSubmit() {
      this.USER_REGISTER(this.user)
        .then(() => {
          this.showModal();
        })
        .catch(error => {
          if (error.response.data.errors) {
            this.makeAlert(Object.values(error.response.data.errors).join('\n'));
          }
        });
    }
  },

  mounted() {
    const im = new Inputmask('9999999999');
    im.mask(document.getElementById('input-phone'));
    const em = new Inputmask('email');
    em.mask(document.getElementById('input-email'));
  }
};
</script>
<style>
.form-group.mask div {
  display: flex;
}
.short {
  max-width: 55px;
}
</style>
