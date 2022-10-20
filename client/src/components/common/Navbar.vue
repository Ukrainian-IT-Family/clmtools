<template>
    <div>
        <BNavbar type="dark" variant="dark">
            <BNavbarBrand :to="{ path: '/' }">CMLTool</BNavbarBrand>
            <BNavbarNav class="ml-auto" align="right" v-if="isLoggedIn">
                <AddCourse v-if="isLecturer" />
                <BNavItem :to="{ name: 'profile'}"><img src="/img/person.png" alt=""></BNavItem>
                <Notifications></Notifications>
                <BNavItem @click="onSignOut"><img src="/img/door_closed.png"></BNavItem>
            </BNavbarNav>
            <BNavbarNav class="ml-auto" align="right" v-else>
                <BNavItem :to="{ name: 'auth.signUp' }">{{ $t("auth.registration") }}</BNavItem>
                <BNavItem :to="{ name: 'auth.signIn' }">{{ $t("auth.entering") }}</BNavItem>
            </BNavbarNav>
        </BNavbar>
    </div>
</template>

<script>
import AddCourse from '../../views/Courses/AddCourse';
import Notifications from '../../views/Notifications';
import {mapActions, mapGetters} from "vuex";
export default {
    name: "Navbar",
    components:{
        AddCourse,
        Notifications
    },
    computed: {
        ...mapGetters('auth', {
            user: 'getAuthenticatedUser',
            fullName: 'getFullName',
            isLoggedIn: 'isLoggedIn',
            isLecturer: 'isLecturer',
        }),
    },
    async created() {
        if (this.isLoggedIn) {
            await this.GET_AUTHENTICATED_USER();
        }
    },
    methods: {
        ...mapActions('auth', [
            'GET_AUTHENTICATED_USER',
            'USER_LOGOUT'
        ]),
        async onSignOut() {
            await this.USER_LOGOUT();
            this.$router.push({ name: 'auth.signIn' }).catch(() => {});
        },
    },
};
</script>
