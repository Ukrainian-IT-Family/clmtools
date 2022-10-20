<template>
    <div>
        <form class="form" enctype="multipart/form-data">
            <textarea
                id="body"
                cols="25"
                rows="5"
                class="form-input"
                @keydown="typing"
                v-model="body"
            >
            </textarea>
            <input
                type="file"
                @input="pickFile"
                class="d-none"
                ref="fileInput"
                name="message-file"
                accept=".doc, .docx, .pdf"
            />
            <p class="mt-2 text-center" @click="selectFile">
                <BIcon icon="cloud-arrow-up"></BIcon>
                <b>{{ messageFile ? messageFile.name : $t("buttons.choose_file") + ' (' + this.allowedExtensions.join(', ') + ', 5MB)' }}</b>
            </p>
            <p class="alert alert-danger" v-if="fileErrors">
                {{ fileErrors }}
            </p>
            <button type="button" @click="toogleDialogEmoji">😃</button>
            <button type="button" @click="sendMessage">{{ $t("buttons.send") }}</button>
            <span class="notice">
                {{ $t("buttons.enter") }}
            </span>
        </form>
        <VEmojiPicker
            v-show="showEmojiDialog"
            :style="{ width: '440px', height: '200' }"
            labelSearch="Search"
            lang="pt-BR"
            @select="onSelectEmoji"
        />
    </div>
</template>

<script>
import { VEmojiPicker } from "v-emoji-picker";
import { mapActions } from "vuex";

export default {
    name: 'LecturerChatFormComponent',
    components: {
        VEmojiPicker
    },
    data() {
        return {
            body: null,
            messageFile: null,
            fileErrors: '',
            showEmojiDialog: false,
            allowedExtensions: ['.doc', '.docx', '.pdf']
        };
    },
    props: {
        student_id: {
            default: null
        },
        lecture_id: {
            default: null
        }
    },
    methods: {
        ...mapActions('lecturerChat', [
            'POST_MESSAGE',
        ]),
        toogleDialogEmoji() {
            this.showEmojiDialog = !this.showEmojiDialog;
        },
        onSelectEmoji(emoji) {
            if(this.body !== null) {
                this.body += emoji.data;
            } else {
                this.body = emoji.data;
            }
        },
        selectFile() {
            this.$refs['fileInput'].click();
        },
        pickFile() {
            this.fileErrors = '';
            let input = this.$refs.fileInput;
            let file = input.files;
            if (file && file[0]) {
                let reader = new FileReader();
                reader.onload = e => {
                    this.messageFile = file[0];
                };
                if(file[0].size > 5242880){
                    this.fileErrors += this.$t("errors.big_file") + '\n';
                }
                let extension = file[0].name.match(/\.[0-9a-z]+$/i);
                if(!this.allowedExtensions.includes(extension[0])){
                    this.fileErrors += this.$t("errors.incorrect_format") + ' (' + this.allowedExtensions.join(', ') + ')\n';
                }
                if(!this.fileErrors){
                    reader.readAsDataURL(file[0]);
                    this.$emit('fileInput', file[0]);
                } else {
                    this.$refs['fileInput'].value = '';
                    this.messageFile = null;
                }
            }
        },
        typing(e) {
            if (e.keyCode === 13 && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        },
        sendMessage() {
            if(!this.body || this.body.trim() === '') {
                return;
            }

            const formData = new FormData();
            formData.append('lecture_id', this.lecture_id);
            formData.append('body', this.body.trim());
            formData.append('student_id', this.student_id);
            if(this.messageFile) {
                formData.append('file', this.messageFile, this.messageFile.name);
            }

            this.POST_MESSAGE({
                form_data: formData
            })
                .then(() => {
                    this.messageFile = null;
                    this.fileErrors = '';

                })
                .catch((error) => {
                    if (error.response.data.errors) {
                        console.log(Object.values(error.response.data.errors).join('\r\n'));
                    }
                } );
            this.body = null;
        },
    }
};
</script>
