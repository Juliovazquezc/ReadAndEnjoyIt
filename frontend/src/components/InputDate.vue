<template>
    <v-menu
        v-model="menu"
        :close-on-content-click="false"
        :nudge-right="40"
        transition="scale-transition"
        offset-y
        min-width="auto"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            v-model="date"
            :label="$t('forms.book.inputs.publication_date.name')"
            append-icon="mdi-calendar"
            readonly
            outlined
            :rules="rules"
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>
        <v-date-picker
          v-model="date"
          @input="menu = false"
        ></v-date-picker>
      </v-menu>
</template>

<script>
export default {
    name: 'InputDate',
    props: {
        bookDate: {
            type: String,
            default: '',
        },
        rules: {
          type: Array,
          default: []
        }
    },
    data() {
        return {
            date: '',
            menu: false
        }
    },
    watch: {
        date() {
            this.$emit('updateDate', this.date);
        },
        bookDate () {
          this.date = this.bookDate
        }
    },
    mounted() {
        this.date = this.bookDate;
    },

}
</script>