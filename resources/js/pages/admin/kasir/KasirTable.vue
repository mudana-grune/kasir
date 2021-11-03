<template>
  <div class="row">
      <div class="col-lg-8 col-center-block">
        <v-data-table
        :headers="headers"
        :items="displayedUsers"
        :page.sync="currentPage"
        :loading="loading"
        :options.sync="options"
        :server-items-length="totalUser"
        @page-count="totalPages = $event"
        hide-default-footer
        >
        <template v-slot:top>
            <v-toolbar flat>
            <v-toolbar-title>Daftar Kasir</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on, attrs }">
                <v-btn
                    color="primary"
                    dark
                    small
                    fab
                    v-bind="attrs"
                    v-on="on"
                    title="Tambah Kasir"
                >
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
                </template>
                <v-card>
                <v-card-title>
                    <span class="text-h5">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                    <v-container>
                    <v-form ref="user">
                        <v-row>
                        <v-col cols="12" sm="6" md="6">
                            <v-text-field
                            v-model="editedItem.name"
                            label="Nama"
                            :rules="[(value) => !!value || 'Wajib diisi']"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="6">
                            <v-text-field
                            v-model="editedItem.username"
                            label="Username"
                            :rules="[(value) => !!value || 'Wajib diisi', userExists ? 'User sudah digunakan ': true]"
                            @input="checkUserExists()"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="6" v-if="editedIndex > -1">
                            <v-switch
                            v-model="editedItem.passwordChanged"
                            label="Ganti password?"
                            ></v-switch>
                        </v-col>
                        <v-col
                            v-if="editedItem.passwordChanged || editedIndex === -1"
                            cols="12"
                            sm="6"
                            md="6"
                        >
                            <v-text-field
                            type="password"
                            v-model="editedItem.password"
                            :label="
                                editedIndex > -1 ? `Password Baru` : 'Password'
                            "
                            :rules="
                                editedIndex > -1
                                ? [
                                    (value) =>
                                        value && value.length >= 6 ||
                                        'Minimum 6 Karakter',
                                    ]
                                : [
                                    (value) => !!value || 'Wajib diisi',
                                    (value) =>
                                        value.length >= 6 || 'Minimum 6 Karakter',
                                    ]
                            "
                            ></v-text-field>
                        </v-col>
                        </v-row>
                    </v-form>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="close"> Batal </v-btn>
                    <v-btn color="blue darken-1" text @click="save"> Simpan </v-btn>
                </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                <v-card-title class="text-h5"
                    >Apakah Anda yakin menghapus user ini ?</v-card-title
                >
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" text @click="closeDelete"
                    >Batal</v-btn
                    >
                    <v-btn color="red darken-1" text @click="deleteItemConfirm"
                    >Hapus</v-btn
                    >
                    <v-spacer></v-spacer>
                </v-card-actions>
                </v-card>
            </v-dialog>
            </v-toolbar>
        </template>
        <template v-slot:item.actions="{ item }">
            <v-icon color="green" class="mr-2" @click="editItem(item)">
            mdi-pencil
            </v-icon>
            <v-icon color="red" @click="deleteItem(item)">
            mdi-delete
            </v-icon>
        </template>
        </v-data-table>
        <div class="text-center pt-2 mt-3">
        <v-pagination
            v-model="currentPage"
            :length="totalPages"
            total-visible="7"
        ></v-pagination>
        </div>
      </div>
  </div>
</template>

<script>
const ADMIN_ROLE = 2;
const KASIR_ROLE = 1;
import io from 'lodash';
import { getAll, store, update, destroy } from "../../../services/crud";
export default {
  data() {
    return {
      currentPage: 1,
      totalPages: 0,
      dialog: false,
      dialogDelete: false,
      loading: false,
      totalUser: 0,
      users: [],
      userExists: false,
      options: {
        groupBy: [],
        groupDesc: [],
        itemsPerPage: 5,
        multiSort: false,
        mustSort: false,
        page: 1,
        sortBy: [],
        sortDesc: [],
      },
      editedIndex: -1,
      editedItem: {
        id: 0,
        name: "",
        username: "",
        password: "",
        carbs: 0,
        protein: 0,
        passwordChanged: false,
      },
      defaultItem: {
        id: 0,
        name: "",
        username: "",
        password: "",
        carbs: 0,
        protein: 0,
        passwordChanged: false,
      },
    };
  },

  computed: {
    cabang() {
      return this.$auth.user().cabang ? this.$auth.user().cabang.id : null;
    },
    formTitle() {
      return this.editedIndex === -1 ? "Tambah Kasir" : "Edit Kasir";
    },
    headers() {
      return [
        {
          text: "#",
          align: "start",
          value: "nomor",
          sortable: false
        },
        {
          text: "Nama",
          align: "start",
          value: "name",
        },
        { text: "Username", value: "username" },
        { text: "Manage", value: "actions", sortable: false , align: 'end'},
      ];
    },
    displayedUsers() {
      return this.users.map((user, index) => ({
        ...user,
        nomor: index+1,
      }));
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
    options: {
      handler() {
        this.getAllUser();
      },
    },
  },

  created() {
    this.getAllUser();
  },
  methods: {
    checkUserExists: io.debounce(async function(){
      try{
        let url = 'users/check';
        let username = this.editedItem.username;
        const res = await getAll(url, { username });
        res ? this.userExists = true : this.userExists = false;
      }catch(err){
        console.log(err);
      }
    }, 500),
    getAllUser: async function () {
      try {
        let url = "users";
        this.loading = true;
        const { itemsPerPage, page, sortBy, sortDesc } = this.options;
        const res = await getAll(url, {
          itemsPerPage,
          page,
          sortBy,
          sortDesc,
        });
        console.log(res);
        this.users = res.users.data;
        this.totalUser = res.users.total;
        console.log(this.totalUser);
      } catch (error) {
        console.log(error);
      } finally {
        this.loading = false;
      }
    },
    editItem(item) {
      this.editedIndex = this.displayedUsers.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      let id = this.editedItem.id;
      let url =`users/${id}`;
      try{
         const res = destroy(url);
         if(res){
            this.closeDelete();
            this.getAllUser();
         }
      }catch(err){
          console.log(err);
      }
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
     try {
        let payloads = {
          id: this.editedItem.id,
          name: this.editedItem.name,
          username: this.editedItem.username,
          password:
            this.editedItem.passwordChanged || this.editedIndex === -1
              ? this.editedItem.password
              : "",
          role: KASIR_ROLE,
          cabang_id: this.cabang,
        };
        let url =
          this.editedIndex > -1 ? `users/${this.editedItem.id}` : "users";
        if (this.$refs.user.validate()) {
          const res =
            this.editedIndex > -1
              ? update(url, payloads)
              : store(url, payloads);
          if (res) {
            this.close();
            this.getAllUser();
          }
        }
      } catch (error) {
        console.log(error);
      }

    },
  },
};
</script>

<style scoped>
.col-center-block{
    margin: 0 auto;
}
</style>
