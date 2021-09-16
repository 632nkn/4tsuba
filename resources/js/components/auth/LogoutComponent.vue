<template>
    <div class="p-5">
        <h1>Laravel Airlock</h1>
        <button class="btn btn-danger mb-3" @click="logout">ログアウト</button>
                <v-btn
                    class="white--text"
                    color="green lighten-2"
                    depressed
                    @click="logout"
                >
                    はい
                </v-btn>

    </div>
</template>

<script>
// export default {
//     data() {
//         return {
//             email: "",
//             password: "",
//             errors: []
//         };
//     },
//     methods: {
//         login() {
//             axios.get("/sanctum/csrf-cookie").then(response => {
//                 axios
//                     .post("/api/login", {
//                         email: this.email,
//                         password: this.password
//                     })
//                     .then(response => {
//                         console.log('ログインメソッド成功');
//                         console.log(response);
//                         localStorage.setItem("auth", "ture");
//                         this.$router.push("/about");
//                     })
//                     .catch(error => {
//                 console.log(error);
//                 console.log('ログイン失敗のキャッチ');
//             });
//             });
//         }
//     }
// };
export default {
    data() {
        return {};
    },
    methods: {
        logout() {
            axios.post("/api/logout", {}).then(response => {
                console.log(response);
                localStorage.removeItem("auth");
                this.$router.push("/login");
            });
        }
    }
};
</script>
