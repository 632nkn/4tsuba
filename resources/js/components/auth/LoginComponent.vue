<template>
<div>
    <!-- ログイン -->
    <auth-component></auth-component>

    <!-- ゲストログイン -->
    <v-card flat >
        <v-card-title class="green--text text--lighten-1">ゲストログイン</v-card-title>
    </v-card>
    <div class="d-flex justify-end">
        <v-btn
            class="white--text mt-3 mr-3"
            color="green lighten-2"
            depressed
            @click="loginAsGuest1"
        >ゲストユーザー1でログイン
        </v-btn>
        <v-btn
            class="white--text mt-3 mr-3"
            color="green lighten-2"
            depressed
            @click="loginAsGuest2"
        >ゲストユーザー2でログイン
        </v-btn>
        <v-btn
            class="white--text mt-3 mr-3"
            color="green lighten-2"
            depressed
            @click="loginAsGuest3"
        >ゲストユーザー3でログイン
        </v-btn>
    </div>
</div>
</template>

<script>
import AuthComponent from "./AuthComponent.vue";

export default {
    data() {
        return {
            guest_user_id: null
        };
    },
    components: {
        AuthComponent,
    },
    methods: {
        loginAsGuest1() {
            console.log('this is loginAsGuest1');
            axios
                .get("/api/login/guest/1")
                .then(response => {
                    console.log(response);
                    localStorage.setItem("auth", "ture");
                    this.$router.push("/threads");
                })
                .catch(error => {
                    console.log(error.response.data);
                    alert(error.response.data.message);
                });
        },
        loginAsGuest2() {
            console.log('this is loginAsGuest2');
            axios
                .get("/api/login/guest/2")
                .then(response => {
                    console.log(response);
                    localStorage.setItem("auth", "ture");
                    this.$router.push("/threads");
                })
                .catch(error => {
                    console.log(error.response.data);
                    alert(error.response.data.message);
                });
        },
        loginAsGuest3() {
            console.log('this is loginAsGuest3');
            axios
                .get("/api/login/guest/3")
                .then(response => {
                    console.log(response);
                    localStorage.setItem("auth", "ture");
                    this.$router.push("/threads");
                })
                .catch(error => {
                    console.log(error.response.data);
                    alert(error.response.data.message);
                });
        },
       
    }
};
</script>
