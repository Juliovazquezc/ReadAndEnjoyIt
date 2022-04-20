<template>
  <v-dialog
    v-model="dialog"
    max-width="60%"
    transition="dialog-bottom-transition"
  >
    <v-overlay absolute v-model="loading">
      <v-progress-circular :size="100" indeterminate />
    </v-overlay>
    <v-card>
      <v-card-title class="justify-center">
        {{ title }}
      </v-card-title>
      <v-container>
        <v-form ref="form" @submit.prevent="handleSave">
          <v-row>
            <v-col cols="12">
              <v-text-field
                outlined
                @change="handleChangeName"
                type="text"
                :rules="nameRules"
                v-model="localBook.name"
                :counter="maxLength.name"
                :label="$t(`${baseTranslation}.inputs.name.name`)"
                append-icon="mdi-book"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                outlined
                :rules="authorRules"
                v-model="localBook.author"
                type="text"
                :counter="maxLength.author"
                :label="$t(`${baseTranslation}.inputs.author.name`)"
                append-icon="mdi-account-edit"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <input-date
                :bookDate="localBook.publication_date"
                :rules="dateRules"
                @updateDate="
                  (newDate) => (localBook.publication_date = newDate)
                "
              />
            </v-col>
            <v-col>
              <v-autocomplete
                outlined
                chips
                :rules="categoryRules"
                v-model="localBook.category"
                return-object
                append-icon="mdi-form-select"
                :items="selectCategories"
                :label="$t(`${baseTranslation}.inputs.category.name`)"
                item-value="id"
                item-text="name"
              />
            </v-col>
          </v-row>
          <v-btn block color="primary" type="submit">{{ titleButton }}</v-btn>
        </v-form>
      </v-container>
    </v-card>
  </v-dialog>
</template>

<script>
import InputDate from "@/components/InputDate.vue";
import { getAllCategories } from "../services/category-service";
import { formatBookToRequest } from "../utils/book";
import { createBook, editBook } from "../services/book-service";
export default {
  name: "BookForm",
  props: {
    showForm: {
      type: Boolean,
      default: false,
    },
    book: {
      type: Object,
      default: {},
    },
    edit: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      localBook: this.book,
      baseTranslation: "forms.book",
      dialog: false,
      loading: false,
      selectCategories: [],
      maxLength: {
        name: 100,
        author: 35,
      },
      authorRules: [
        (v) =>
          !!v ||
          this.$t(`${this.baseTranslation}.inputs.author.validation.required`),
        (v) =>
          v.length <= this.maxLength.author ||
          this.$t(`${this.baseTranslation}.inputs.author.validation.length`),
      ],
      nameRules: [
        (v) =>
          !!v ||
          this.$t(`${this.baseTranslation}.inputs.name.validation.required`),
        (v) =>
          v.length <= this.maxLength.name ||
          this.$t(`${this.baseTranslation}.inputs.author.validation.length`),
      ],
      dateRules: [
        (v) =>
          !!v ||
          this.$t(
            `${this.baseTranslation}.inputs.publication_date.validation.required`
          ),
      ],
      categoryRules: [
        (v) =>
          !!(v && v.name != "") ||
          this.$t(
            `${this.baseTranslation}.inputs.category.validation.required`
          ),
      ],
    };
  },
  methods: {
    isValidForm() {
      return this.$refs.form.validate();
    },
    async handleSave() {
      if (!this.isValidForm()) {
        return;
      }
      const data = formatBookToRequest({ ...this.book });
      try {
        this.loading = true;
        if(!this.edit) {
          const { data: newBook } = await createBook(data);
          this.$emit("newBookAdded", newBook);
        }else{
          const {data: editedBook } = await editBook(this.book.id, data);
          this.$emit("editedBook", editedBook);
        }
        this.dialog = false;
      } catch (error) {
        const errorName = error.response?.data?.errors?.name ? true : false;
        this.nameRules.push(
          (v) =>
            (v && !errorName) ||
            this.$t(`${this.baseTranslation}.inputs.name.validation.unique`)
        );
        this.isValidForm();
      } finally {
        this.loading = false;
      }
    },
    handleChangeName() {
      /**Delete unique validation for the field name */
      const originalLengthNameRules = 2;
      if (this.nameRules.length > originalLengthNameRules) {
        this.nameRules.pop();
        this.isValidForm();
      }
    },
  },
  watch: {
    book() {
      this.localBook = this.book;
    },
    showForm() {
      this.dialog = this.showForm;
    },
    dialog() {
      if (this.$refs.form) {
        this.$refs.form.resetValidation();
      }
      this.$emit("resetShow", this.dialog);
    },
  },
  components: {
    InputDate,
  },
  computed: {
    title() {
      return this.edit
        ? this.$t(`${this.baseTranslation}.title.edit`)
        : this.$t(`${this.baseTranslation}.title.create`);
    },
    titleButton() {
      return this.edit
        ? this.$t(`${this.baseTranslation}.buttons.edit`)
        : this.$t(`${this.baseTranslation}.buttons.create`);
    },
  },
  async mounted() {
    try {
      this.loading = true;
      const { data } = await getAllCategories();
      this.selectCategories = data;
    } catch (error) {
      const httpCode = error.response?.status || 500;
      this.$emit("errorCategory", httpCode);
      this.dialog = false;
    } finally {
      this.loading = false;
    }
  },
};
</script>