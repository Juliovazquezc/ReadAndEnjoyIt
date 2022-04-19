<template>
  <v-dialog v-model="dialog" max-width="290">
    <template v-slot:default>
      <v-card class="text-center">
        <v-avatar class="mt-2" color="primary" size="56">
          <v-icon dark> mdi-account-circle </v-icon>
        </v-avatar>
        <v-card-title class="justify-center">
          {{ $t(`${baseTranslation}.user_with_the_book`) }}
        </v-card-title>
        <div class="text-body-1 pa-2">{{ nameUser }}</div>
      </v-card>
    </template>
  </v-dialog>
</template>

<script>
export default {
  name: "DialogUser",
  props: {
    showDialog: {
      type: Boolean,
      default: false,
    },
    nameUser: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      dialog: false,
      baseTranslation: "components.dialog_user",
    };
  },
  watch: {
    showDialog() {
      this.dialog = this.showDialog;
    },
    dialog() {
      this.$emit("resetShow", this.dialog);
    },
  },
};
</script>