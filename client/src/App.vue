<template>
  <div id="app">
    <Navbar />
    <BContainer class="content">
      <section class="row g-4" v-if="isLoggedIn">
        <LeftMenu v-if="!isNullUser & !isAdmin" />
        <div class="col-lg-9">
          <RouterView />
        </div>
      </section>

      <section v-else>
        <RouterView />
      </section>
    </BContainer>
    <Modals />
    <Footer v-if="isLoggedIn" />
  </div>
</template>

<style lang="scss">
@import 'scss/bootstrap.scss';
@import 'scss/common.scss';
</style>
<script>
import { mapGetters, mapMutations } from 'vuex';
import Navbar from '@/components/common/Navbar.vue';
import LeftMenu from '@/components/common/LeftMenu.vue';
import Footer from '@/components/common/Footer.vue';
import Modals from '@/components/common/Modals.vue';
import { USER_LOGOUT } from './store/modules/auth/types/mutations';
import { EventEmitter, TOKEN_EXPIRED_EVENT } from './services/EventEmitter';

export default {
  name: 'App',

  components: {
    Navbar,
    LeftMenu,
    Footer,
    Modals
  },

  computed: {
    ...mapGetters('auth', ['isLoggedIn', 'isNullUser', 'isAdmin'])
  },

  created() {
    EventEmitter.$on(TOKEN_EXPIRED_EVENT, () => {
      this.logout();
      this.$router.push({ name: 'auth.signIn' }).catch(() => {});
    });
  },

  methods: {
    ...mapMutations('auth', {
      logout: USER_LOGOUT
    })
  }
};
</script>
