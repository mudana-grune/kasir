<template>
  <v-app-bar flat app>
    <v-btn icon @click="toggleDrawer(!drawerOpen)">
      <v-icon>
        {{ drawerOpen ? 'mdi-chevron-left' : 'mdi-menu' }}
      </v-icon>
    </v-btn>

    <v-spacer></v-spacer>

    <v-menu offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn fab :elevation="1" small v-bind="attrs" v-on="on">
          <v-icon>mdi-account</v-icon>
        </v-btn>
      </template>
      <v-list dense>
        <v-list-item v-for="menu in accountMenus" :key="menu.id" @click="menu.action">
          <v-list-item-icon>
            <v-icon v-text="menu.icon"></v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>{{ menu.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-menu>
  </v-app-bar>
</template>

<script>
export default {
  props: {
    value: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      accountMenus: [
        {
          id: 'logout',
          title: 'Logout',
          icon: 'mdi-logout',
          action: () => {
            this.$auth.logout();
          },
        },
      ],
    };
  },
  computed: {
    drawerOpen() {
      return this.value;
    },
  },
  methods: {
    toggleDrawer(val) {
      this.$emit('input', val);
    },
  },
  created() {},
};
</script>
