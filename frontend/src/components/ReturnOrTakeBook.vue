<template>
  <v-dialog v-model="dialog" max-width="500">
      <snack-bar :showSnack="showSnackBar" :message="messageSnackBar" @hide="(show) => showSnackBar = show"/>
    <v-overlay absolute v-model="loading">
      <v-progress-circular :size="75" indeterminate />
    </v-overlay>
    <v-card>
      <v-card-title class="justify-center text-center">{{
        title
      }}</v-card-title>
      
      <v-card-actions class="justify-center">
        <v-btn
          color="success"
          text
          :disabled="forbidden"
          @click="handleConfirm"
        >
          {{ $t(`${baseTranslation}.actions.confirm`) }}</v-btn
        >
        <v-btn @click="dialog = false" color="error" text>
          {{ $t(`${baseTranslation}.actions.exit`) }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapState } from "vuex";
import { getSkeletonBook } from "../utils/book";
import { borrowBook, returnBook } from '../services/book-service';
import SnackBar from '@/components/SnackBar.vue';

export default {
  name: "ReturnOrTakeBook",
  props: {
    book: {
      type: Object,
      default: getSkeletonBook(),
    },
    showStatusChange: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      dialog: false,
      loading: false,
      localBook: this.book,
      forbidden: false,
      showSnackBar: false,
      messageSnackBar: '',
      baseTranslation: "components.return_or_take_book",
    };
  },
  watch: {
    book() {
      this.localBook = this.book;
    },
    showStatusChange() {
      this.dialog = this.showStatusChange;
    },
    dialog() {
      this.$emit("resetShow", this.dialog);
    },
  },
  computed: {
    title() {
      if (!this.isAuthenticatedUserWithTheBook()) {
        return this.$t(`${this.baseTranslation}.titles.forbidden`);
      }
      return this.localBook.status == "Borrowed"
        ? this.$t(`${this.baseTranslation}.titles.return`)
        : this.$t(`${this.baseTranslation}.titles.borrow`);
    },
    ...mapState(["user"]),
  },
  methods: {
    isAuthenticatedUserWithTheBook() {
      const status = this.localBook.status;
      this.forbidden = false;
      if (status == "Borrowed") {
        const userwithTheBook = this.localBook.user_with_the_book || {};
        if (userwithTheBook.id != this.user.id) {
          this.forbidden = true;
          return false;
        }
      }
      return true;
    },
    async handleConfirm() {
      this.loading = true;
      try {
          if(this.localBook.status == 'Available') {
              await borrowBook(this.localBook.id);
              this.formatBook();
          } else {
              await returnBook(this.localBook.id);
              this.formatBook();
          }
          this.$emit('updateBook', this.localBook);
          this.dialog = false;
      } catch (error) {
          const httpCode = error.response?.status || 500;
          this.showSnackBar = true;
          this.messageSnackBar = (httpCode == 500) ? this.$t('errors.500') : this.$t('components.return_or_take_book.errors.403');
      } finally {
          this.loading = false
      }
    },
    formatBook () {
        const status = this.localBook.status;
        if(status == 'Available') {
            this.localBook.status = 'Borrowed';
            this.localBook.user_with_the_book = {
                name: this.user.name,
                id: this.user.id
            }
            return;
        }
        this.localBook.status = 'Available',
        delete this.localBook.user_with_the_book;
    }
  },
  components: {
      SnackBar
  }
};
</script>