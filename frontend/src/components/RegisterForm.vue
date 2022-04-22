<template>
  <div>
    <v-overlay absolute v-model="loading">
      <v-progress-circular :size="100" indeterminate />
    </v-overlay>
    <v-form @submit.prevent="handleRegister" ref="registerForm">
      <v-text-field
        outlined
        append-icon="mdi-account"
        type="text"
        :label="$t(`${baseTranslation}.inputs.name.name`)"
        :rules="nameRules"
        v-model="registerObject.name"
      />
      <v-text-field
        outlined
        append-icon="mdi-email"
        @change="handleEmailChange()"
        type="email"
        :label="$t(`${baseTranslation}.inputs.email.name`)"
        :rules="emailRules"
        v-model="registerObject.email"
      />
      <v-text-field
        outlined
        append-icon="mdi-lock"
        type="password"
        :label="$t(`${baseTranslation}.inputs.password.name`)"
        :rules="passwordRules"
        v-model="registerObject.password"
      />
      <v-text-field
        outlined
        append-icon="mdi-lock"
        type="password"
        :label="$t(`${baseTranslation}.inputs.repeat_password.name`)"
        :rules="repeatPasswordRules"
        v-model="registerObject.repeatPassword"
      />
      <v-btn block color="primary text-subtitle-1 btn" type="submit">
        {{ $t(`${this.baseTranslation}.action`) }}
      </v-btn>
    </v-form>
  </div>
</template>

<script>
import { mapActions} from 'vuex';
export default {
  name: "RegisterForm",
  data() {
    return {
        loading: false,
        registerObject: {
            name: '',
            email: '',
            password: '',
            repeatPassword: '',
        },
        baseTranslation: "forms.register",
        nameRules: [
            (v) =>
            !!v ||
            this.$t(`${this.baseTranslation}.inputs.email.validation.required`),
        ],
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
            (v) =>
            v.length >= 8 ||
            this.$t(`${this.baseTranslation}.inputs.password.validation.length`),
        ],
        repeatPasswordRules: [
            (v) =>
            !!v ||
            this.$t(
                `${this.baseTranslation}.inputs.repeat_password.validation.required`
            ),
            (v) =>
            v.length >= 8 ||
            this.$t(`${this.baseTranslation}.inputs.repeat_password.validation.length`),
        ],
    };
  },
  methods: {
    async handleRegister() {
      if (!this.isValidForm()) {
        return;
      }
      this.loading = true;
      try{
        await this.register(this.registerObject);
      }catch(error) {
          const errorMail = error.response?.data?.errors?.email ? true : false;
          const callback = (v) => (v && !errorMail || this.$t(`${this.baseTranslation}.inputs.email.validation.unique`));
          this.emailRules.push(callback);
          this.isValidForm();
      }finally {
        this.loading = false;
      }
    },
    isValidForm() {
      return this.$refs.registerForm.validate();
    },
    handleRepeatPassword () {
        const password = this.registerObject.password;
        const repeatPassword = this.registerObject.repeatPassword;
        const repeat = password == repeatPassword;
        this.pushErrorPassword(repeat);
    },
    handleEmailChange() {
        const originalEmailRulesSize = 2;
        if(this.emailRules.length > originalEmailRulesSize) {
            this.emailRules.pop();
            this.isValidForm();
        }
    },
    pushErrorPassword (repeat) {
        const expectedSizeRulesPassword = 3;
        if(!repeat && this.passwordRules.length < expectedSizeRulesPassword) {
            const callback = (v) => (v && false || this.$t(`${this.baseTranslation}.inputs.password.validation.match`));
            this.passwordRules.push(callback);
            this.repeatPasswordRules.push(callback);
            this.isValidForm();
            return;
        }
        const originalSizeRulesPassword = 2;
        if(repeat && this.passwordRules.length > originalSizeRulesPassword) {
            this.passwordRules.pop();
            this.repeatPasswordRules.pop();
            this.isValidForm();
        }
    },
    ...mapActions(['register'])
  },
  computed: {
      password() {
          return this.registerObject.password;
      },
      repeatPassword() {
          return this.registerObject.repeatPassword;
      }
  },
  watch: {
      password() {
          this.handleRepeatPassword();
      },
      repeatPassword() {
          this.handleRepeatPassword();
      }
  }
};
</script>

<style>
.btn {
  text-transform: unset !important;
}
</style>