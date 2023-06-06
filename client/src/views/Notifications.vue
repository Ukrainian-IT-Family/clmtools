<template>
    <div>
        <li class="nav-item" @click="showNotificationsModal">
            <a href="#" target="_self" class="nav-link notification-modal-open">
                <img src="/img/bell_icon.png">
                <span class="notification-count" v-if="this.notificationsCount < 100">{{ this.notificationsCount }}</span>
                <span class="notification-count" v-else>99+</span>
            </a>
        </li>
        <div
            class="modal-notifications"
            tabindex="-1"
            role="dialog"
            v-show="alertNotificationsModal"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <i
                            class="fa-solid fa-arrow-left-long modal_i"
                            @click="hideNotificationsModal()"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                 width="30" height="30"
                                 viewBox="0 0 30 30"
                                 style=" fill:#000000;">    <path d="M 7 4 C 6.744125 4 6.4879687 4.0974687 6.2929688 4.2929688 L 4.2929688 6.2929688 C 3.9019687 6.6839688 3.9019687 7.3170313 4.2929688 7.7070312 L 11.585938 15 L 4.2929688 22.292969 C 3.9019687 22.683969 3.9019687 23.317031 4.2929688 23.707031 L 6.2929688 25.707031 C 6.6839688 26.098031 7.3170313 26.098031 7.7070312 25.707031 L 15 18.414062 L 22.292969 25.707031 C 22.682969 26.098031 23.317031 26.098031 23.707031 25.707031 L 25.707031 23.707031 C 26.098031 23.316031 26.098031 22.682969 25.707031 22.292969 L 18.414062 15 L 25.707031 7.7070312 C 26.098031 7.3170312 26.098031 6.6829688 25.707031 6.2929688 L 23.707031 4.2929688 C 23.316031 3.9019687 22.682969 3.9019687 22.292969 4.2929688 L 15 11.585938 L 7.7070312 4.2929688 C 7.5115312 4.0974687 7.255875 4 7 4 z"></path></svg>
                        </i>
                        <h5 class="modal-title">{{ $t("notifications.title") }}</h5>
                    </div>
                    <div class="modal-body notification-modal-body" v-if="notificationsExist">
                        <button type="button" @click="deleteNotifications">{{ $t("notifications.remove_all") }}</button>
                        <div
                            v-for="notification in this.GET_NOTIFICATIONS_ELEMENTS"
                            :key="notification.id"
                            class="toast"
                        >
                            <div class="toast-header">
                                <strong class="mr-auto">{{ notification.title }}</strong>
                                <small class="text-muted">{{ new Date(notification.created_at).toLocaleString('uk-UA') }}</small>
                            </div>
                            <div class="toast-body">
                                {{ notification.description }}
                                <a v-if="notification.id > 0" @click="deleteNotification(notification.id, notification.url)">{{ $t("notifications.follow_the_link") }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body" v-else>
                        {{ $t("notifications.empty") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.VUE_APP_PUSHER_APP_KEY,
    cluster: 'eu',
    encrypted: true
});

export default {
    name: 'Notifications',
    computed: {
        ...mapGetters('auth', {
            user: 'getAuthenticatedUser',
        }),
        ...mapGetters('notifications', [
            'GET_NOTIFICATIONS_ELEMENTS'
        ]),
    },
    data() {
        return {
            alertNotificationsModal: false,
            notificationsExist: false,
            notificationsCount: 0,
        };
    },
    methods: {
        ...mapActions('auth', [
            'GET_AUTHENTICATED_USER'
        ]),
        ...mapActions('notifications', [
            'GET_NOTIFICATIONS',
            'DELETE_NOTIFICATIONS',
            'DELETE_NOTIFICATION'
        ]),
        showNotificationsModal() {
            this.alertNotificationsModal = true;
        },
        hideNotificationsModal() {
            this.alertNotificationsModal = false;
        },
        deleteNotifications() {
            this.DELETE_NOTIFICATIONS()
                .then(() => {
                    this.notificationsExist = false;
                    this.notificationsCount = this.GET_NOTIFICATIONS_ELEMENTS.length;
                })
                .catch((error) => {
                    if (error.response.data.errors) {
                        console.log(Object.values(error.response.data.errors).join('\r\n'));
                    }
                });
        },
        deleteNotification(id, url) {
            this.DELETE_NOTIFICATION({
                notification_id: id
            })
                .then(() => {
                    window.location.href = url;
                })
                .catch((error) => {
                        console.log(error);
                    }
                );
        },
    },
    mounted() {
        this.GET_NOTIFICATIONS()
            .then(() => {
                window.Echo.leave('notification.' + this.user.id);
                window.Echo.channel('notification.' + this.user.id)
                    .listen('.NotificationCreated', (data) => {
                        this.GET_NOTIFICATIONS_ELEMENTS.unshift(data.notification);
                        this.notificationsExist = true;
                        this.alertNotificationsModal = true;
                        this.notificationsCount = this.GET_NOTIFICATIONS_ELEMENTS.length;
                    });
                if(this.GET_NOTIFICATIONS_ELEMENTS.length){
                    this.notificationsCount = this.GET_NOTIFICATIONS_ELEMENTS.length;
                    this.notificationsExist = true;
                }
            })
            .catch((error) => {
                if (error.response.data.errors) {
                    console.log(Object.values(error.response.data.errors).join('\r\n'));
                }
            } );
    },
};
</script>
