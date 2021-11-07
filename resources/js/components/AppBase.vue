<template>
    <v-app class="outerset">
        <left-nav v-model="drawerOpen"></left-nav>
        <base-app-bar v-model="drawerOpen"></base-app-bar>
        <v-main class="mainset">
            <v-container class="mainset-container py-8 px-4 px-md-6 mb-10" fluid>
                <alert></alert>
                <router-view :key="$route.path"></router-view>
            </v-container>
            <base-footer></base-footer>
        </v-main>
    </v-app>
</template>
<script>
import Alert from './Alert.vue';
import BaseAppBar from './BaseAppBar.vue';
import BaseFooter from './BaseFooter.vue';
import LeftNav from './LeftNav.vue';
export default {
    data(){
        return {
            drawerOpen: true,
        }
    },
    components: {
        BaseAppBar,
        BaseFooter,
        LeftNav,
        Alert
    }
}
</script>
