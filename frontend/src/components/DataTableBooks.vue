<template>
  <div>
    <book-form :book="book"
      :showForm="showForm" 
      :edit="edit"
      @errorCategory="(httpCode) => showSnackError(httpCode)"
      @resetShow="(show) => showForm = show"
      @newBookAdded="(newBook) => handleNewBook(newBook)"
      @editedBook="(editedBook) => handleEditedBook(editedBook)"
      />
    <return-or-take-book :book="bookStatus" 
      :showStatusChange="showChangeStatus"
      @resetShow="(show) => showChangeStatus = show"
      @updateBook="(book) => handleEditedBook(book)"/>
    <v-btn block color="primary" class="mt-5" @click="createBook"> {{ $t('data_tables.books.actions.create') }} </v-btn>
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
      :sort-desc.sync="sortDesc"
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
           <v-tooltip top>
            <template v-slot:activator="{ on, attrs }">
              <v-icon
                color="primary"
                v-bind="attrs"
                v-on="on"
                small
                @click="editBook(item)"
              >
                mdi-pencil
              </v-icon>
            </template>
            <span>{{
              $t(`data_tables.books.actions.edit`)
            }}</span>
          </v-tooltip>

          <v-tooltip top v-if="item.status == 'Available'">
            <template v-slot:activator="{ on, attrs }">
              <v-icon
                color="error"
                v-bind="attrs"
                v-on="on"
                class="ml-2"
                small
                @click="handleDelete(item)"
              >
                mdi-delete
              </v-icon>
            </template>
            <span>{{ $t(`data_tables.books.actions.delete`) }}</span>
          </v-tooltip>

          <v-tooltip class='ml-2' top v-else>
            <template v-slot:activator="{ on, attrs }">
              <v-icon
                color="primary"
                v-bind="attrs"
                v-on="on"
                class="ml-2"
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

          <v-tooltip top>
            <template v-slot:activator="{ on, attrs }">
              <v-icon
                color="primary"
                v-bind="attrs"
                v-on="on"
                class="ml-2"
                small
                @click="editChangeStatus(item)"
              >
                {{ getIconChangeStatusBook(item.status) }}
              </v-icon>
            </template>
            <span>{{
               getTooltipStatusBook(item.status) 
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
import BookForm from "@/components/BookForm.vue";
import ReturnOrTakeBook from "@/components/ReturnOrTakeBook.vue";
import { getSkeletonBook } from "../utils/book";


export default {
  name: "DataTableBooks",
  data() {
    return {
      book: getSkeletonBook(),
      bookStatus: getSkeletonBook(),
      loading: false,
      totalBooks: 0,
      showDialog: false,
      showForm: false,
      showChangeStatus: false,
      edit: false,
      options: {},
      userWithTheBook: "",
      loadingTable: false,
      snackBar: {
        message: '',
        show: false,
        duration: 1500,
      },
      sortDesc: true,
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
          value: "category.name",
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
      console.log(this.options);
      this.loadingTable = true;
      try {
        this.loadingTable = true;
        const { itemsPerPage, page, sortDesc, sortBy } = this.options;
        let limit = itemsPerPage < 0 ? this.totalBooks : itemsPerPage;
        const sort = sortBy.length > 0 ? sortBy[0] : 'updated_at';
        const desc = sortDesc.length > 0 ? sortDesc[0] : true;
        const { data, meta } = await BookService.getAllBooks(limit, page, sort, desc);

        this.books = data;
        this.totalBooks = meta.total;
      } catch (error) {
        console.log(error);
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
        this.snackBar.show = true;
        this.snackBar.duration = 1000;
        this.snackBar.message = this.$t('data_tables.books.messages.successfully_deteled');
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
    editBook(item) {
      this.book = {...item};
      this.showForm = true;
      this.edit = true;
    },
    createBook() {
      this.book = getSkeletonBook();
      this.showForm = true;
      this.edit = false;
    },
    editChangeStatus(item) {
      this.bookStatus = item;
      this.showChangeStatus = true;
    },
    handleNewBook(book) {
      this.books.pop();
      this.books = [book].concat(this.books);
    },
    handleEditedBook(book) {
      const index = this.books.findIndex((element) => book.id == element.id);
      Object.assign(this.books[index], book);
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
    getIconChangeStatusBook (status) {
      return status == 'Borrowed' ? 'mdi-keyboard-return' : 'mdi-hand-wave';
    },
    getTooltipStatusBook (status) {
      return status == 'Borrowed' ? this.$t('data_tables.books.actions.return_the_book') : this.$t('data_tables.books.actions.take_the_book');
    }
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
    SnackBar,
    BookForm,
    ReturnOrTakeBook
  },
};
</script>