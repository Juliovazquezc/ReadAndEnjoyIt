<template>
  <v-row class="fill-height my-0">
    <v-col
      cols="12"
      md="5"
      v-if="$vuetify.breakpoint.mdAndUp"
      class="
        light-blue
        darken-2
        d-flex
        fill-height
        flex-column
        justify-center
        align-center
        white--text
      "
    >
      <v-img
        src="@/assets/login_image.svg"
        max-width="60%"
        max-height="20%"
        contain
      />
      <div class="px-16">
        <v-card-title class="text-center">{{
          $t(`${this.baseTranslation}.main_message`)
        }}</v-card-title>
        <v-card-text class="text-center">{{
          $t(`${this.baseTranslation}.secondary_message`)
        }}</v-card-text>
      </div>
    </v-col>
    <v-col
      cols="12"
      md="7"
      class="d-flex flex-column fill-height justify-center align-center"
    >
      <div></div>
      <v-img
        contain
        src="@/assets/logo.svg"
        max-height="100px"
        min-width="50%"
      />
      <div class="text-h4 mt-2">Hello Again!</div>
      <div class="min-width-50 mt-5">
        <p class="text-center font-weight-light mb-6">
          {{ $t(`${this.baseTranslation}.access_message`) }}
        </p>
        <login-form/>
        <div class="text-body-2 mt-3 text-center">
          {{ $t(`${this.baseTranslation}.need_an_account`) }} Register
        </div>
      </div>
    </v-col>
  </v-row>
</template>

<script>
import LoginForm from '@/components/LoginForm.vue';

export default {
  name: "Login",
  data() {
    return {
      baseTranslation: "views.login",
    };
  },
  components:{
    LoginForm
  }
};
</script>

<style scoped>
  .min-width-50 {
    max-width: 70%;
    min-width: 60%;
  }
</style>