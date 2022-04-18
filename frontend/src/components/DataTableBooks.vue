<template>
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
  <template v-slot:item.status="{item}">
    <v-chip :color="getColorStatus(item.status)">
      {{ item.status }}
    </v-chip>
  </template>
  </v-data-table>
</template>

<script>
import * as BookService from "../services/book-service";
export default {
  name: "DataTableBooks",
  data() {
    return {
      totalBooks: 0,
      options: {},
      loadingTable: false,
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
      ],
      books: [],
    };
  },
  methods: {
    async fillBooks() {
      this.loadingTable = true;
      const { itemsPerPage, page } = this.options;
      let limit = (itemsPerPage < 0 ) ? this.totalBooks : itemsPerPage;
      const { data, meta } = await BookService.getAllBooks(limit, page);
      this.books = data;
      this.totalBooks = meta.total;
      this.loadingTable = false;
    },
    getColorStatus(status){
      return (status == 'Borrowed') ? 'error' : 'success'; 
    }
  },
  watch: {
    options: {
      async handler() {
        await this.fillBooks();
      },
    },
  },
};
</script>