<template>
  <div class="container">
    <div v-if="errors" class="alert-danger alert" v-text="errors"></div>

      <div>
          <label class="form-check-label">
              {{ $t("index.find_by_name") }}
          </label><br>
          <svg @click="filterByClick()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/></svg>
          <input
              type="text"
              v-model="search"
              class="mr-2 ml-2"
          />

          <button
              type="button"
              class="h6 btn-primary"
              @click="filterByClick()"
          >
              {{ $t("index.find") }}
          </button>
      </div>

    <h3>{{ $t("index.users") }}</h3>
    <hr />
      <div class="d-flex">
          <table class="table table-bordered">
              <thead>
              <tr>
                  <th scope="col">{{ $t("index.id") }}</th>
                  <th scope="col" class="min-width">{{ $t("index.name") }}</th>
                  <th scope="col" class="min-width">{{ $t("index.last_name") }}</th>
                  <th scope="col" class="min-width-long">{{ $t("index.email") }}</th>
                  <th scope="col" class="min-width">{{ $t("index.role") }}</th>
                  <th scope="col">{{ $t("index.operation") }}</th>
              </tr>
              </thead>
              <tbody v-if="GET_ALL_ROLES">
              <tr
                  v-for="user in allUsers"
                  v-bind:key="user.id"
              >
                  <th scope="row" @click="showEditUserModal(user.id)">{{ user.id }}</th>
                  <td @click="showEditUserModal(user.id)">{{ user.name }}</td>
                  <td @click="showEditUserModal(user.id)">{{ user.last_name }}</td>
                  <td @click="showEditUserModal(user.id)">{{ user.email }}</td>
                  <td @click="showEditUserModal(user.id)">{{ GET_ALL_ROLES[user.role] }}</td>
                  <td class="float-right">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" @click="showUserDeleteModal(user.id)">
                          <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                          <path
                              d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128H416L394.8 466.1z"
                          />
                      </svg>
                  </td>
              </tr>
              </tbody>
          </table>
          <table class="table table-bordered second-table ml-5">
              <h5>{{ $t("index.filter") }}</h5>
              <p>{{ $t("index.role") }}:</p>
              <div class="form-check">
                  <label class="form-check-label">
                      <input class="form-check-input" @change="filterUsers()" type="radio" value="" v-model="filterRole" name="userRole" checked>
                    {{ $t("index.all") }}
                  </label>
              </div>
              <div class="form-check" v-for="(role, index) in GET_ALL_ROLES" v-bind:key="role">
                  <label class="form-check-label">
                    <input class="form-check-input" @change="filterUsers()" type="radio" :value="index" v-model="filterRole" name="userRole">
                    {{ role }}
                  </label>
              </div>
          </table>
      </div>
    <div
      class="modal preview_modal"
      tabindex="-1"
      role="dialog"
      v-show="editUserModal"
    >
      <div class="modal-dialog one-column" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <i class="fa-solid fa-arrow-left-long" @click="hideEditUserModal()">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                <path
                  d="M9.375 233.4l128-128c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H480c17.69 0 32 14.31 32 32s-14.31 32-32 32H109.3l73.38 73.38c12.5 12.5 12.5 32.75 0 45.25c-12.49 12.49-32.74 12.51-45.25 0l-128-128C-3.125 266.1-3.125 245.9 9.375 233.4z"
                />
              </svg>
            </i>
            <h6 class="modal-title">{{ $t("index.role") }}</h6>
          </div>
            <div class="modal-content align-items-center" v-if="editedUser">
                <h3 class="modal-title">{{ editedUser.name + ' ' + editedUser.last_name }}</h3>
                <div class="dropdown">
                    <button
                        class="btn btn-secondary dropdown-toggle"
                        type="button"
                        id="dropdownMenuButton"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        @click="showEditUserDropdown()"
                    >
                        {{ editUserRole }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" v-if="editUserDropdown">
                        <a
                            class="dropdown-item"
                            href="#"
                            v-for="(roleName, roleCode) in GET_ALL_ROLES" v-bind:key="roleName"
                            @click="chooseRole(roleCode)"
                        >{{ roleName }}</a>
                    </div>
                </div>
            </div>
          <div class="modal-footer d-flex">
            <button
              type="button"
              class="btn btn-primary"
              @click="hideEditUserModal()"
            >
              {{ $t("buttons.cancel") }}
            </button>
            <button
              type="button"
              class="btn btn-primary"
              @click="onUpdateUser()"
            >
              {{ $t("buttons.confirm") }}
            </button>
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal preview_modal"
      tabindex="-1"
      role="dialog"
      v-show="userDelete"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ $t("buttons.warning") }}</h5>
            <i
              class="fa-solid fa-arrow-left-long"
              @click="hideUserDeleteModal()"
            >
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                <path
                  d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"
                />
              </svg>
            </i>
          </div>
          <div class="modal-body mx-auto">
            <p>{{ $t("index.delete_user") }}</p>
          </div>
          <div class="modal-footer d-flex mx-auto">
            <button
              type="button"
              class="btn btn-primary"
              @click="hideUserDeleteModal()"
            >
              {{ $t("buttons.cancel") }}
            </button>
            <button
              type="button"
              class="btn btn-primary"
              @click="onDeleteUser()"
            >
              {{ $t("buttons.delete") }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  name: 'Admin',

  data: function() {
    return {
      editUserRole: '',
      newUserRole: '',
      editedUser: null,
      errors: '',
      allUsers: [],
      editUserModal: false,
      editUserDropdown: false,
      userDelete: false,
      userDeleteId: '',
      search: '',
      filterRole: '',
    };
  },

  computed: {
    ...mapGetters('users', ['GET_ALL_USERS', 'GET_ALL_ROLES']),

    filteredUsers() {
      return this.allUsers.filter(item => {
        let full_name = (item.name + ' ' + item.last_name).toLowerCase();
        return full_name.indexOf(this.search.toLowerCase()) > -1;
      });
    },

  },

  methods: {
    ...mapActions('users', [
      'GET_USERS',
      'EDIT_USER',
      'DELETE_USER',
      'GET_ROLES'
    ]),
    ...mapActions([
      'makeAlert'
    ]),

    filterUsers() {
      this.allUsers = !this.filterRole ? this.GET_ALL_USERS : this.GET_ALL_USERS.filter(item => {
          return item.role === this.filterRole || (item.role === null && this.filterRole === "null");
      });
    },

    filterByClick() {
        if (this.search) {
          this.allUsers = this.filteredUsers;
        } else {
          this.filterUsers();
        }
    },

    showEditUserModal(id) {
      let key = Object.keys(this.GET_ALL_USERS).find(key => this.GET_ALL_USERS[key].id === id);
      this.editedUser = this.GET_ALL_USERS[key];
      this.editUserRole = this.GET_ALL_ROLES[this.editedUser.role];
      this.editUserModal = true;
    },

    hideEditUserModal() {
      this.editUserModal = false;
    },

    showEditUserDropdown() {
      this.editUserDropdown = !this.editUserDropdown;
    },

    hideEditUserDropdown() {
      this.editUserDropdown = false;
    },

    chooseRole(role) {
      this.newUserRole = role;
      this.editUserRole = this.GET_ALL_ROLES[role];
      this.hideEditUserDropdown();
    },

    onUpdateUser() {
      this.EDIT_USER({
          user_id: this.editedUser.id,
          role: this.newUserRole
      })
          .then(() => {
              this.hideEditUserModal();
              this.makeAlert(this.$t("index.user_role") + ' ' + this.editedUser.name + ' ' + this.$t("message.successfully_changed"));
          })
          .catch(error => {
              if (error.response) {
                  this.errors = Object.values(error.response.data.errors).join(
                      '\r\n'
                  );
              }
          });
    },

    showUserDeleteModal(id) {
      this.userDelete = true;
      this.userDeleteId = id;
    },

    hideUserDeleteModal() {
      this.userDelete = false;
    },

    onDeleteUser() {
      this.DELETE_USER({
          user_id: this.userDeleteId
      })
          .then(() => {
              this.hideUserDeleteModal();
              this.makeAlert(this.$t("index.user_delete"));
          })
          .catch(error => {
              if (error.response.data.errors) {
                  console.log(Object.values(error.response.data.errors).join('\r\n'));
              }
          });
    },

    getUsers() {
      this.GET_USERS()
        .then(() => {
            this.allUsers = this.GET_ALL_USERS;
        })
        .catch(error => {
          if (error.response.data.errors) {
            console.log(Object.values(error.response.data.errors).join('\r\n'));
          }
        });
    },
    getRoles() {
      this.GET_ROLES()
          .then(() => {})
          .catch(error => {
              if (error.response.data.errors) {
                  console.log(Object.values(error.response.data.errors).join('\r\n'));
              }
          });
    },
  },
  created() {
     this.getRoles();
     this.getUsers();
  }
};
</script>
<style>
    .modal-content.align-items-center {
        margin-bottom: 160px;
    }
</style>
