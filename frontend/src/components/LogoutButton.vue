<template>
  <v-tooltip top>
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="warning" dark v-bind="attrs" v-on="on" @click="logout">
        <v-icon>mdi-logout</v-icon>
      </v-btn>
    </template>
    <span>{{ $t(`${baseTranslation}.action`) }}</span>
  </v-tooltip>
</template>

<script>
import { mapActions } from "vuex";
export default {
  name: "LogoutButton",
  data() {
    return {
      baseTranslation: 'components.logout_button'
    }
  },
  methods: {
    ...mapActions(["logout"]),
  },
};
</script>