<template>
    <div>
        <div
            class="modal bg-white-transparent"
            tabindex="-1"
            role="dialog"
            v-show="isLoading"
        >
            <div class="mx-auto-center" role="document">
                <div class="spinner-border" style="width: 8rem; height: 8rem;" role="status">
                    <span class="sr-only">{{ $t("buttons.loading") }}</span>
                </div>
            </div>
        </div>
        <div
            class="modal bg-black-transparent"
            tabindex="-1"
            role="dialog"
            v-show="isAlert"
        >
            div class="modal-dialog" role="document">
            <div class="modal-content mx-auto" style="width: fit-content;">
                <div class="modal-header">
                    <p> </p>
                    <i
                        class="fa-solid fa-xmark"
                        @click="setAlert(false)"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 320 512"
                            style="max-width: 15px;min-width: 15px;"
                        ><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/></svg>
                    </i>
                </div>
                <div class="modal-body">
                    <p v-text="isAlertText" style="font-size: 20px; white-space: break-spaces;"></p>
                </div>
                <div class="modal-footer d-flex">
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="setAlert(false)"
                    >
                        {{ $t("buttons.close") }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters, mapMutations } from 'vuex';;

export default {
  name: 'Modals',
  computed: {
    ...mapGetters([
        'isLoading',
        'isAlert',
        'isAlertText'
    ])
  },
  methods: {
    ...mapMutations([
        'setAlert'
    ]),
  },
};
</script>
<style>
.mx-auto-center {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}
.bg-white-transparent {
    background-color: rgba(255, 255, 255, 1);
}
.bg-black-transparent {
    background-color: rgba(0, 0, 0, 0.8);
}
</style>
