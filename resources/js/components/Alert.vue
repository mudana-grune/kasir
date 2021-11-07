<template>
  <v-snackbar
    right
    top
    :timeout="5000"
    v-model="notification.isOpen"
    :color="notification.color"
    :multi-line="notification.multiLine"
  >
    <span class="font-weight-bold text-subtitle-1">
      {{ notification.text ? notification.text : "" }}
    </span>
    <template v-slot:action="{ attrs }">
      <v-btn
        color="white"
        text
        v-bind="attrs"
        @click="$store.commit('closeNotification')"
      >
        <v-icon dark> mdi-close </v-icon>
      </v-btn>
    </template>
    <v-progress-linear absolute bottom  dark indeterminate />
  </v-snackbar>
</template>
<script>
import { mapState } from "vuex";

export default {
  data() {
    return {
      currentTime: 0,
    };
  },
  computed: mapState({
    notification: (state) => state.notification,
  }),
  methods: {
    syncPbar() {
      //Create a timeout every 100 miliseconds
      setTimeout(() => {
        //Increment the time counter by 100
        this.currentTime += 100;

        //If our current time is larger than the timeout
        if (this.timeout <= this.currentTime) {
          //Wait 500 miliseconds for the dom to catch up, then reset the snackbar
          setTimeout(() => {
            this.$emit("input", false); //Update the v-model to false
            this.currentTime = 0; // reset the current time
          }, 500);
        } else {
          //Recursivly update the progress bar
          this.syncPbar();
        }
      }, 100);
    },
  },
  watch: {
    value(v) {
      if (v) this.syncPbar();
    },
  },
};
</script>
