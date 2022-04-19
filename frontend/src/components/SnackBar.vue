<template>
  <v-snackbar v-model="show" centered :timeout="duration">
    {{ message }}
    <template v-slot:action="{ attrs }">
      <v-btn color="pink" text v-bind="attrs" @click="show = false">
        {{ $t(`${baseTranslation}.close`) }}
      </v-btn>
    </template>
  </v-snackbar>
</template>

<script>
export default {
  name: "SnackBar",
  props: {
    duration: {
      type: Number,
      default: 1500,
    },
    message: {
      type: String,
      default: "",
    },
    showSnack: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      show: false,
      baseTranslation: "components.snack_bar",
    };
  },
  watch: {
    showSnack() {
      this.show = this.showSnack;
    },
  },
};
</script>