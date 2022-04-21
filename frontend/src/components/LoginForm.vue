<template>
  <div>
    <v-overlay absolute v-model="loading">
      <v-progress-circular :size="100" indeterminate />
    </v-overlay>
    <div class="error--text my-1 text-center" v-if="error.value">
      {{ error.message }}
    </div>
    <v-form @submit.prevent="loginUseCase" ref="loginForm">
      <v-text-field
        outlined
        type="email"
        :label="$t(`${this.baseTranslation}.inputs.email.name`)"
        append-icon="mdi-email"
        :rules="emailRules"
        v-model="credentials.email"
      ></v-text-field>

      <v-text-field
        outlined
        type="password"
        :label="$t(`${this.baseTranslation}.inputs.password.name`)"
        append-icon="mdi-lock"
        :rules="passwordRules"
        v-model="credentials.password"
      ></v-text-field>
      <v-btn block color="primary text-subtitle-1 btn" type="submit">
        {{ $t(`${this.baseTranslation}.action`) }}
      </v-btn>
    </v-form>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  name: "LoginForm",
  data() {
    return {
      baseTranslation: "forms.login",
      credentials: {
        email: "",
        password: "",
      },
      loading: false,
      error: {
        value: false,
        message: "asdas",
      },
      emailRules: [
        (v) =>
          !!v ||
          this.$t(`${this.baseTranslation}.inputs.email.validation.required`),
        (v) =>
          /.+@.+\..+/.test(v) ||
          this.$t(`${this.baseTranslation}.inputs.email.validation.format`),
      ],
      passwordRules: [
        (v) =>
          !!v ||
          this.$t(
            `${this.baseTranslation}.inputs.password.validation.required`
          ),
      ],
    };
  },
  methods: {
    isValidForm() {
      return this.$refs.loginForm.validate();
    },

    async loginUseCase() {
      if (!this.isValidForm()) {
        return;
      }
      this.loading = true;
      this.error.value = false;

      try {
        await this.login(this.credentials);
      } catch (error) {
        const httpCode = error.response?.status || 500;
        this.error.value = true;
        this.handleMessageError(httpCode);
      } finally {
        this.loading = false;
      }
    },

    handleMessageError(httpCode) {
      this.error.message =
        httpCode == 403
          ? this.$t(`${this.baseTranslation}.errors.403`)
          : this.$t(`${this.baseTranslation}.errors.500`);
    },
    ...mapActions(["login"]),
  },
};
</script>

<style scoped>
.btn {
  text-transform: unset !important;
}
</style>