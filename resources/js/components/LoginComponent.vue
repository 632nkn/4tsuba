<template>
    <div class="p-5">
        <button class="btn btn-success mb-3" @click="getUser">
            ユーザ情報取得
        </button>
        <v-card flat>
            <v-toolbar color="green lighten-3" dark flat>
                <v-toolbar-title>Login form</v-toolbar-title>
                <v-spacer />
            </v-toolbar>
            <v-card-text>
                <v-form ref="form" v-model="valid">
                    <v-text-field
                        label="メールアドレス"
                        placeholder="4tsuba@test.com"
                        color="green lightten-3"
                        name="email"
                        prepend-icon="email"
                        type="text"
                        v-model="email"
                        :rules="[rules.required, rules.email]"
                    />

                    <v-text-field
                        id="password"
                        label="パスワード"
                        placeholder="p@ssw0rd"
                        color="green lightten-3"
                        name="password"
                        prepend-icon="lock"
                        type="password"
                        v-model="password"
                        :rules="[rules.required, rules.password]"
                    />
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    :disabled="!valid"
                    class="white--text"
                    color="green lighten-3"
                    depressed
                    @click="login"
                >
                    ログイン
                </v-btn>
            </v-card-actions>
        </v-card>
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
        return {
            email: "",
            password: "",
            //バリデーション項目
            valid: null,
            rules: {
                required: value => !!value || "必ず入力してください",
                email: value => {
                    const pattern = /^[a-zA-Z0-9_.+-]+@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/;
                    return (
                        pattern.test(value) || "メールアドレスを入力して下さい"
                    );
                },
                password: value => {
                    const pattern = /^(?=.*?[a-z])(?=.*?\d)(?=.*?[!-\/:-@[-`{-~])[!-~]{8,100}$/i;
                    return (
                        pattern.test(value) ||
                        "8文字以上 かつ 半角英数字記号を含む"
                    );
                }
            }
        };
    },
    methods: {
        login() {
            axios.get("/sanctum/csrf-cookie").then(response => {
                axios
                    .post("/api/login", {
                        email: this.email,
                        password: this.password
                    })
                    .then(response => {
                        console.log(response);
                        localStorage.setItem("auth", "ture");
                        this.$router.push("/threads");
                    })
                    .catch(error => {
                        console.log(error.response.data);
                        alert(error.response.data.message);
                    });
            });
        },
        getUser() {
            axios
                .get("/api/user")
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    alert(error.response.data.message);
                });
        }
    }
};
</script>
