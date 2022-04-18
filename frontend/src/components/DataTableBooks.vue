<template>
  <v-data-table
    :headers="headers"
    :items="books"
    :items-per-page="5"
    class="elevation-1 mt-5"
  ></v-data-table>
</template>

<script>
export default {
  name: "DataTableBooks",
  data() {
    return {
      headers: [
      ],
      books: [

      ]
    };
  },
};
</script>