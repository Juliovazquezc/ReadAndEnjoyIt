<template>
  <div>
    <dialog-user
      :showDialog="showDialog"
      :nameUser="userWithTheBook"
      @resetShow="(value) => (showDialog = value)"
    />
    <snack-bar :message="snackBar.message" :showSnack="snackBar.show" :duration="snackBar.duration" />
    <v-overlay absolute v-model="loading">
      <v-progress-circular :size="100" indeterminate />
    </v-overlay>
    <v-data-table
      :headers="headers"
      :items="books"
      :items-per-page="10"
      :server-items-length="totalBooks"
      :options.sync="options"
      :loading="loadingTable"
      class="elevation-1 mt-5"
      :footer-props="{
        showFirstLastPage: true,
        firstIcon: 'mdi-arrow-collapse-left',
        lastIcon: 'mdi-arrow-collapse-right',
        prevIcon: 'mdi-minus',
        nextIcon: 'mdi-plus',
      }"
    >
      <template v-slot:item.status="{ item }">
        <v-chip :color="getColorStatus(item.status)">
          {{ item.status }}
        </v-chip>
      </template>
      <template v-slot:item.actions="{ item }">
        <div>
          <v-tooltip top v-if="item.status == 'Available'">
            <template v-slot:activator="{ on, attrs }">
              <v-icon
                color="error"
                v-bind="attrs"
                v-on="on"
                small
                @click="handleDelete(item)"
              >
                mdi-delete
              </v-icon>
            </template>
            <span>{{ $t(`data_tables.books.actions.delete`) }}</span>
          </v-tooltip>

          <v-tooltip top v-else>
            <template v-slot:activator="{ on, attrs }">
              <v-icon
                color="primary"
                v-bind="attrs"
                v-on="on"
                small
                @click="showUser(item)"
              >
                mdi-account-search
              </v-icon>
            </template>
            <span>{{
              $t(`data_tables.books.actions.show_user_with_the_book`)
            }}</span>
          </v-tooltip>
        </div>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import * as BookService from "../services/book-service";
import DialogUser from "@/components/DialogUser.vue";
import SnackBar from "@/components/SnackBar.vue";
export default {
  name: "DataTableBooks",
  data() {
    return {
      loading: false,
      totalBooks: 0,
      showDialog: false,
      options: {},
      userWithTheBook: "",
      loadingTable: false,
      snackBar: {
        message: '',
        show: false,
        duration: 1500,
      },
      headers: [
        { text: this.$t(`data_tables.books.headers.name`), value: "name" },
        { text: this.$t(`data_tables.books.headers.author`), value: "author" },
        { text: this.$t(`data_tables.books.headers.status`), value: "status" },
        {
          text: this.$t(`data_tables.books.headers.publication_date`),
          value: "publication_date",
        },
        {
          text: this.$t(`data_tables.books.headers.category`),
          value: "category",
        },
        {
          text: this.$t(`data_tables.books.headers.actions`),
          value: "actions",
          sortable: false,
        },
      ],
      books: [],
    };
  },
  methods: {
    async fillBooks() {
      this.loadingTable = true;
      try {
        this.loadingTable = true;
        const { itemsPerPage, page } = this.options;
        let limit = itemsPerPage < 0 ? this.totalBooks : itemsPerPage;
        const { data, meta } = await BookService.getAllBooks(limit, page);
        this.books = data;
        this.totalBooks = meta.total;
      } catch (error) {
        const httpCode = error.response?.status || 500;
        this.books = [];
        this.showSnackError(httpCode);
      } finally {
        this.loadingTable = false;
      }
    },
   
    async handleDelete(item) {
      this.loading = true;
      try {
        await BookService.deleteBook(item.id);
        const indexItem = this.books.indexOf(item);
        this.books.splice(indexItem, 1);
        if (this.books.length == 0) {
          this.options.page = 1;
        } else {
          await this.fillBooks();
        }
      }catch (error) {
        const httpCode = error.response?.status || 500;
        this.showSnackError(httpCode);
      } finally {
        this.loading = false;
      }
    },

    showUser(item) {
      this.showDialog = !this.showDialog;
      this.userWithTheBook = item.user_with_the_book.name;
    },
    showSnackError(httpCode = 500) {
      this.snackBar.show = true;
      let message = (httpCode == 500) ? this.$t('errors.500') : this.$t('data_tables.books.errors.delete.403');
      /**Not found translation */
      if (message.includes(httpCode)) {
        message = this.$t('errors.general');
      }
      this.snackBar.message = message 
      this.snackBar.duration = 5000;
    },
    getColorStatus(status) {
      return status == "Borrowed" ? "error" : "success";
    },
  },
  watch: {
    options: {
      async handler() {
        await this.fillBooks();
      },
    },
  },
  components: {
    DialogUser,
    SnackBar
  },
};
</script>