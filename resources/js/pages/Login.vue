<template>
   <v-app id="inspire">
      <v-main>
        <v-container fluid fill-height>
            <v-layout align-center justify-center>
                <v-flex xs12 sm8 md4 lg4>
                   <v-form ref="login" @submit.prevent="login">
                    <v-card class="elevation-12">
                        <v-toolbar dark color="purple">
                            <v-toolbar-title>Login</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>

                                <v-text-field
                                    prepend-icon="mdi-account"
                                    v-model="username"
                                    label="Username"
                                    type="text"
                                    :rules="rules.username"
                                >
                                </v-text-field>
                                <v-text-field
                                    prepend-icon="mdi-lock"
                                    v-model="password"
                                    label="Password"
                                    type="password"
                                    :rules="rules.password"
                                ></v-text-field>
                            <div class="mt-4" v-if="has_error">
                                <strong class="red--text">Login gagal! </strong> <br>
                                <strong class="red--text">Mohon periksa kembali username dan password Anda!</strong>
                            </div>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn dark color="purple" type="submit">Login</v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-form>
                </v-flex>
            </v-layout>
        </v-container>
      </v-main>
   </v-app>
</template>


<script>
  const ADMIN = 2;
  const KASIR = 1;
  const MANAGER = 3;
  export default {
    data() {
      return {
        username: null,
        password: null,
        has_error: false,
        rules: {
            username: [(v) => !!v || 'Username wajib diisi'],
            password: [ (v) => !!v || 'Password wajib diisi']
        }
      }
    },

    mounted() {
      //
    },

    methods: {
      login() {
          try{
              if(this.$refs.login.validate()){
               // get the redirect object
                var redirect = this.$auth.redirect()
                var app = this
                this.$auth.login({
                params: {
                    username: this.username,
                    password: this.password
                },
                success: function() {
                    // handle redirection

                    let  redirectTo = this.$auth.user().role === ADMIN ? 'admin.home' : (this.$auth.user().role === KASIR ? 'kasir.home': 'manager.home');
                    console.log(redirectTo)
                    this.$router.push({name: redirectTo})
                },
                error: function() {
                    app.has_error = true
                },
                rememberMe: true,
                fetchUser: true
                })
              }
          }catch(err){
              console.log(err)
          }
      }
    }
  }
</script>
