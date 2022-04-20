<template>
  <v-container class="text-center align-center fill-height gradient" fluid>
    <v-overlay absolute v-model="loading">
      <v-progress-circular :size="100" indeterminate />
    </v-overlay>
    <v-row justify="center" align="center">
      <v-col cols="12" class="d-flex flex-column justify-center align-center">
        <div style="width: 80%">
          <v-card>
            <div class="d-flex flex-wrap justify-center align-center pa-6">
              <v-avatar color="primary" size="56">
                <v-icon dark> mdi-account-circle </v-icon>
              </v-avatar>
              <div
                class="d-flex flex-wrap justify-center align-center"
                v-if="!error.value"
              >
                <div class="text-center">
                  <v-card-title class="justify-center">{{ user.name }}</v-card-title>
                  <v-card-subtitle> {{ user.email }}</v-card-subtitle>
                </div>
                <div class="ml-2">
                  <logout-button/>
                </div>
              </div>
              <div v-else>
                <v-card-title class='error--text'>{{ error.message }}</v-card-title>
              </div>
            </div>
          </v-card>
          <data-table-books></data-table-books>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import DataTableBooks from "@/components/DataTableBooks.vue";
import LogoutButton from "@/components/LogoutButton.vue";
import { mapActions } from "vuex";

export default {
  name: "Books",
  data() {
    return {
      loading: false,
      error: {
        value: false,
        message: "",
      },
    };
  },
  methods: {
    ...mapActions(["retrieveInfoUser"]),
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
  },
  components: {
    DataTableBooks,
    LogoutButton
  },
  async mounted() {
    this.loading = true;
    try {
      await this.retrieveInfoUser();
      this.error.value = false;
    } catch (error) {
      this.error.value = true;
      this.error.message = this.$t('errors.user_info');
    } finally {
      this.loading = false;
    }
  },
};
</script>

<style>
.gradient {
  background: rgb(18, 19, 21);
  background: linear-gradient(
    179deg,
    rgba(18, 19, 21, 1) 0%,
    rgba(2, 136, 209, 1) 100%
  );
}
</style>