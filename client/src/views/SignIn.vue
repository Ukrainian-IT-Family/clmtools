<template>
  <section class="mt-30 auth-page">
    <div class="d-flex justify-content-center">
      <div class="box shadow-box w-auth">
        <h3 class="text-center mb-30 p-0">{{ $t("auth.authorization") }}</h3>
        <form @submit.prevent novalidate="true">
          <BFormGroup>
            <BFormInput
              id="input-email"
              v-model="user.email"
              name="email"
              :placeholder="$t('auth.email')"
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
          </BFormGroup>

          <BRow>
            <BCol class="mob-col-right">
              <p class="ml-32 mob-ml-22 mb-20">
                <RouterLink
                  class="link link-signup"
                  :to="{ name: 'auth.signUp' }"
                >
                  {{ $t("auth.registration") }}
                </RouterLink>
              </p>
            </BCol>
            <BCol class="mob-col-left">
              <p class="mr-32 mob-mr-22 mb-20 text-right">
                <RouterLink
                  class="link link-signup"
                  :to="{ name: 'auth.forgotPassword' }"
                >
                  {{ $t("auth.forgot_password") }}
                </RouterLink>
              </p>
            </BCol>
          </BRow>

          <BButton block @click="onSubmit">
            {{ $t("auth.enter") }}
          </BButton>
        </form>
      </div>
    </div>
    <RegistrationModal ref="modal" />
  </section>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import RegistrationModal from '@/components/auth/RegistrationModal.vue';
import Inputmask from 'inputmask';

export default {
  name: 'SignInPage',

  components: {
    RegistrationModal
  },

  data: () => ({
    user: {
      email: '',
      password: ''
    }
  }),

  computed: {
    ...mapGetters('auth', ['hasAuthenticatedUser'])
  },

  methods: {
    ...mapActions('auth', ['USER_LOGIN']),
    showModal() {
      this.$refs.modal.showModal();
    },
    onSubmit() {
      this.USER_LOGIN(this.user)
        .then(() => {
          if (this.hasAuthenticatedUser) {
            this.makeAlert(this.$t("auth.entered"));
            this.$router.push({ path: '/' }).catch(() => {});
          } else {
            this.showModal();
          }
        })
        .catch(error => {
          if (error.response.data.errors) {
              this.makeAlert(Object.values(error.response.data.errors).join('\r\n'));
          }
        });
    },
    ...mapActions([
      'makeAlert'
    ]),
  },

   mounted() {
     const em = new Inputmask('email');
     em.mask(document.getElementById('input-email'));
   }
};
</script>
