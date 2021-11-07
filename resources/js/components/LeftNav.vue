<template>
  <v-navigation-drawer v-model="drawerOpen" app>
    <v-list-item>
      <v-list-item-content>
        <v-list-item-title class="title">
          Kasir
        </v-list-item-title>
        <v-list-item-subtitle v-if="!$auth.check(3)">
          <strong>{{$auth.user().cabang.nama }}</strong>
        </v-list-item-subtitle>
         <v-list-item-subtitle>
          {{$auth.user().name}}
        </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>

    <v-divider></v-divider>

    <v-list dense nav>
      <v-list-item-group>
        <template v-for="menu in menus">
              <v-list-item  v-if="!menu.hasChildren" :key="menu.id" :to="menu.route">
                <v-list-item-icon>
                  <v-icon>{{ menu.icon }}</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title>{{ menu.label }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>


              <v-list-group v-else :value="true" :key="menu.id">
                <template v-slot:activator>
                  <v-list-item-icon>
                    <v-icon>{{ menu.icon }}</v-icon>
                  </v-list-item-icon>
                  <v-list-item-content>
                    <v-list-item-title>{{ menu.label }}</v-list-item-title>
                  </v-list-item-content>
                </template>
                <div>
                  <v-list-item v-for="submenu in menu.children" :key="submenu.title" :to="submenu.route" exact>
                    <v-list-item-icon>
                      <v-icon>{{ submenu.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                      <v-list-item-title>{{ submenu.label }}</v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </div>
              </v-list-group>
        </template>
      </v-list-item-group>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
const ADMIN_ROLE = 2;
const USER_ROLE = 1;
const MANAGER_ROLE = 3;
const adminMenus = [
    {
        id: 'dashboard',
        label: 'Dashborad',
        route: {name: 'admin.dashboard'},
        icon: 'mdi-home-city',
        hasChildren: false,
    },
    {
        id:'paket',
        label: 'Paket Treatment',
        icon: 'mdi-briefcase',
        hasChildren: true,
        children: [
            {
                id: 'daftarPaket',
                label: 'Daftar Paket',
                hasChildren: false,
                route: {name: 'admin.paket'}
            },
            {
                id: 'jenisPaket',
                label: 'Jenis Paket',
                route: { name: 'admin.paket.jenis'},
                hasChildren: false
            }
        ]
    },
    {
        id: 'kasir',
        label: 'Kasir',
        icon: 'mdi-account-multiple',
        hasChildren: true,
        children: [
            {
                id: 'daftarKasir',
                label: 'Daftar Kasir',
                hasChildren: false,
                route: { name: 'admin.kasir'}
            },
        ]
    }
];
const managerMenus = [
    {
        id: 'dashboard',
        label: 'Dashborad',
        route: {name: 'manager.dashboard'},
        icon: 'mdi-home-city',
        hasChildren: false,
    },
    {
        id: 'cabang',
        label: 'Cabang',
        icon: 'mdi-home-group',
        hasChildren: true,
        children: [
            {
                id: 'daftarCabang',
                label: 'Daftar Cabang',
                hasChildren: false,
                route: { name: 'manager.cabang.list'}
            }
        ]
    }

];
const kasirMenus = [
    {

        id: 'dashboard',
        label: 'Dashborad',
        route: {name: 'kasir.dashboard'},
        icon: 'mdi-home-city',
        hasChildren: false,
    }
];
const navLeftMenus = [
  {
    id: 'dashboard',
    label: 'general.nav.dashboard',
    route: { name: 'admin.dashboard' },
    icon: 'mdi-home-city',
    hasChildren: false,
    isRestrictedAdminAllowed: false
  },
  {
    id: 'team',
    label: 'general.nav.teams',
    icon: 'mdi-account-group',
    hasChildren: true,
    isRestrictedAdminAllowed: false,
    children: [
      {
        id: 'team.datatable',
        label: 'general.crud.list',
        route: { name: 'admin.team' },
        hasChildren: false,
        isAdminAllowed: true,
      },
      {
        id: 'team.form',
        label: 'general.crud.createNew',
        route: { name: 'admin.team.create' },
        hasChildren: false,
        isAdminAllowed: false,
      },
    ],
  },
  {
    id: 'user',
    label: 'general.nav.users',
    icon: 'mdi-account',
    hasChildren: true,
    isRestrictedAdminAllowed: false,
    children: [
      {
        id: 'user.datatable',
        label: 'general.crud.list',
        route: { name: 'admin.user' },
        hasChildren: false,
        isAdminAllowed: true,
      },
      {
        id: 'user.form',
        label: 'general.crud.createNew',
        route: { name: 'admin.user.create' },
        hasChildren: false,
        isAdminAllowed: true,
      }
    ]
  },
  {
    id: 'paymentList',
    label: 'general.nav.paymentList',
    route: { name: 'admin.paymentlist' },
    icon: 'mdi-pen',
    hasChildren: false,
    isRestrictedAdminAllowed: true,
  },
  {
    id: 'project',
    label: 'general.nav.projects',
    icon: 'mdi-home-variant',
    hasChildren: true,
    isRestrictedAdminAllowed: true,
    children: [
      {
        id: 'project.datatable',
        label: 'general.crud.list',
        route: { name: 'admin.project' },
        hasChildren: false,
        isAdminAllowed: true,
      },
      {
        id: 'project.form',
        label: 'general.crud.createNew',
        route: { name: 'admin.project.create' },
        hasChildren: false,
        isAdminAllowed: true,
      },
    ]
  },
  {
    id: 'news',
    label: 'general.nav.news',
    icon: 'mdi-newspaper-variant-outline',
    hasChildren: true,
    isRestrictedAdminAllowed: false,
    children: [
      {
        id: 'news.datatable',
        label: 'general.crud.list',
        route: { name: 'admin.news' },
        hasChildren: false,
        isAdminAllowed: true,
      },
      {
        id: 'news.form',
        label: 'general.crud.createNew',
        route: { name: 'admin.news.create' },
        hasChildren: false,
        isAdminAllowed: true,
      }
    ]
  },
  {
    id: 'admin_action_log',
    label: 'general.nav.admin_action_log',
    icon: 'mdi-history',
    route: { name: 'admin.admin_action_log' },
    hasChildren: false,
    isRestrictedAdminAllowed: false,
  },
  {
    id: 'admin_user_login',
    label: 'general.nav.admin_user_log',
    icon: 'mdi-login-variant',
    route: { name: 'admin.logs.user_login' },
    hasChildren: false,
    isRestrictedAdminAllowed: false,
  },
  {
    id: 'admin_manage',
    label: 'general.nav.admins',
    icon: 'mdi-account-key',
    hasChildren: true,
    isRestrictedAdminAllowed: false,
    children: [
      {
        id: 'admin.datatable',
        label: 'general.crud.list',
        route: { name: 'admin.admin_manage' },
        hasChildren: false,
        isAdminAllowed: true,
      },
      {
        id: 'admin.datatable',
        label: 'general.crud.createNew',
        route: { name: 'admin.admin_manage.create' },
        hasChildren: false,
        isAdminAllowed: false,
      },
    ]
  },
];
export default {
  props: {
    value: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      navLeftMenus,
      adminMenus,
      managerMenus,
      kasirMenus
    };
  },
  computed: {
    drawerOpen: {
      get() {
        return this.value;
      },
      set(val) {
        this.$emit('input', val);
      },
    },
    isAdmin() {
        return this.$auth.check(ADMIN_ROLE);
    },
    isManager(){
        return this.$auth.check(MANAGER_ROLE);
    },
    isUser(){
        return this.$auth.check(USER_ROLE);
    },
    menus(){
        return this.isAdmin ? adminMenus : (this.isManager ? managerMenus : kasirMenus);
    },
  },
  created() {},
};
</script>
