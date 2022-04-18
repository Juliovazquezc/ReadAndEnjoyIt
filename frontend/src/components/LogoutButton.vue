<template>
  <v-tooltip top>
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="warning" dark v-bind="attrs" v-on="on" @click="logout">
        <v-icon>mdi-logout</v-icon>
      </v-btn>
    </template>
    <span>Logout</span>
  </v-tooltip>
</template>

<script>
import { mapActions } from "vuex";
export default {
  name: "LogoutButton",
  methods: {
    ...mapActions(["logout"]),
  },
};
</script>