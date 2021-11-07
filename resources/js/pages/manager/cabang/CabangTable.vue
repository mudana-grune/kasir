<template>
  <div class="row">
    <div class="col-lg-8 col-center-black">
      <v-data-table
        :headers="headers"
        :items="displayedCabang"
        :page.sync="currentPage"
        :loading="loading"
        :options.sync="options"
        :server-items-length="totalCabang"
        @page-count="totalPages = $event"
        hide-default-footer
      >
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>Daftar Cabang</v-toolbar-title>
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
                  title="Tambah Cabang"
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
                    <v-form ref="cabang">
                      <v-row>
                        <v-col cols="12" sm="6" md="6">
                          <v-text-field
                            v-model="editedItem.nama"
                            label="Nama"
                            :rules="[(value) => !!value || 'Wajib diisi']"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="6">
                          <v-text-field
                            v-model="editedItem.alamat"
                            label="Alamat"
                            :rules="[(value) => !!value || 'Wajib diisi']"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="6">
                          <v-text-field
                            v-model="editedItem.email"
                            label="Email"
                            :rules="[
                              (value) =>
                                value &&
                                value.length > 0 &&
                                !/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(
                                  value
                                )
                                  ? 'Email tidak valid'
                                  : true,
                            ]"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="6">
                          <v-text-field
                            v-model="editedItem.telepon"
                            label="Nomor Telepon"
                            :rules="[
                              (value) =>
                                value &&
                                value.length > 0 &&
                                !/\+?([ -]?\d+)+|\(\d+\)([ -]\d+)/g.test(value)
                                  ? 'Nomor telepon tidak valid'
                                  : true,
                            ]"
                          ></v-text-field>
                        </v-col>
                      </v-row>
                    </v-form>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="close">
                    Batal
                  </v-btn>
                  <v-btn color="blue darken-1" text @click="save">
                    Simpan
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
            <v-dialog v-model="dialogDelete" max-width="550px">
              <v-card>
                <v-card-title class="text-h5"
                  >Apakah Anda yakin menghapus cabang ini ?</v-card-title
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
          <v-icon color="red" @click="deleteItem(item)"> mdi-delete </v-icon>
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
import { getAll, store, destroy, update, show } from "../../../services/crud";
import Alert from "../../../components/Alert.vue";
import VuexStore from '../../../store';

export default {
  components: {
    Alert,
  },
  data() {
    return {
      currentPage: 1,
      totalPages: 0,
      dialog: false,
      dialogDelete: false,
      loading: false,
      totalCabang: 0,
      cabang: [],
      cabangExists: false,
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
        nama: "",
        alamat: "",
        email: "",
        telepon: "",
        email: "",
        ig: "",
      },
      defaultItem: {
        id: 0,
        nama: "",
        alamat: "",
        email: "",
        telepon: "",
        email: "",
        ig: "",
      },
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Tambah Cabang" : "Edit Cabang";
    },
    headers() {
      return [
        {
          text: "#",
          align: "start",
          value: "nomor",
          sortable: false,
        },
        {
          text: "Nama",
          align: "start",
          value: "nama",
        },
        { text: "Alamat", value: "alamat" },
        { text: "Email", value: "email" },
        { text: "Telepon", value: "telepon", sortable: false, align: "end" },
        { text: "Manage", value: "actions", sortable: false, align: "end" },
      ];
    },
    displayedCabang() {
      return this.cabang.map((cb, index) => ({
        ...cb,
        nomor: index + 1,
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
        this.getAllCabang();
      },
    },
  },
  created() {
    this.getAllCabang();
  },
  methods: {
    getAllCabang: async function () {
      try {
        let url = "cabang";
        this.loading = true;
        const { itemsPerPage, page, sortBy, sortDesc } = this.options;
        const res = await getAll(url, {
          itemsPerPage,
          page,
          sortBy,
          sortDesc,
        });
        this.cabang = res.cabang.data;
        this.totalCabang = res.cabang.total;
        console.log(this.cabang);
      } catch (err) {
        console.log(err);
      } finally {
        this.loading = false;
      }
    },
    editItem(item) {
      this.editedIndex = this.displayedCabang.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
    deleteItem(item) {
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },
    deleteItemConfirm() {
      let id = this.editedItem.id;
      let url = `cabang/${id}`;
      try {
        const res = destroy(url);
        if (res) {
            let notif = {
                text: 'Cabang berhasil dihapus',
                isOpen: true,
                color: 'success',
                multiLine: true,
            };
            VuexStore.commit('setNotification', notif);
          this.closeDelete();
          this.getAllCabang();
        }
      } catch (err) {
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
          nama: this.editedItem.nama,
          alamat: this.editedItem.alamat,
          email: this.editedItem.email,
          telepon: this.editedItem.telepon,
          ig: this.editedItem.ig,
        };
        let url =
          this.editedIndex > -1 ? `cabang/${this.editedItem.id}` : "cabang";
        if (this.$refs.cabang.validate()) {
          const res =
            this.editedIndex > -1
              ? update(url, payloads)
              : store(url, payloads);
          if (res) {
            this.close();
            this.getAllCabang();
             let notif = {
                text:  this.editedIndex > -1 ? 'Cabang berhasil diedit' : 'Cabang berhasil ditambahkan',
                isOpen: true,
                color: 'success',
                multiLine: true,
            };
            VuexStore.commit('setNotification', notif);
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
.col-center-block {
  margin: 0 auto;
}
</style>
