<template>
    <div>
        <headline-component v-bind:headline="'メールアドレス/パスワード 変更'"></headline-component>

        <v-form ref="form" v-model="valid">
            <v-text-field
                outlined
                label="メールアドレス"
                color="green lightten-3"
                name="email"
                prepend-icon="email"
                type="text"
                v-model="my_info.email"
                :rules="[rules.required, rules.email]"
            />

            <v-text-field
                outlined
                id="password"
                label="パスワード"
                color="green lightten-3"
                name="password"
                prepend-icon="lock"
                type="password"
                v-model="password"
                :rules="[rules.required, rules.password]"
            />

            <v-text-field
                outlined
                label="パスワード(確認)"
                color="green lightten-3"
                prepend-icon="lock"
                type="password"
                :rules="[rules.required, rules.password_confirm]"
            />
        </v-form>
        <div class="d-flex justify-end">
        <v-btn v-if="my_info.role !== 'guest'"
            :disabled="!valid"
            class="white--text"
            color="green lighten-2"
            depressed
            @click="editPersonal"
        >
             {{message}}
        </v-btn>
        <v-card v-else
        color="grey lighten-2"
        outlined
        class="my-3 d-flex"
        > <span class="grey--text">{{message_for_guest}}</span>
        </v-card>

        </div>
        <div class="mt-8 grey--text text--darken-1 d-flex justify-end">
            <v-icon class="mb-1" color="green lighten-3"
                >mdi-information-outline</v-icon
            >
            <router-link :to="link">
                {{notice}}
            </router-link>
        </div>
        
    </div>
</template>

<script>
import HeadlineComponent from "../common/HeadlineComponent.vue";
export default {
    data() {
        return {
            my_info: {},
            password: null,
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
                },
                password_confirm: value => {
                    return (
                        value === this.password || "パスワードが一致しません"
                    );
                }
            },
            notice: '表示プロフィールの変更はこちら',
            link: '/setting/account/profile',
            message: 'メールアドレス/パスワードを変更する',
            message_for_guest: 'ゲストユーザーは変更できません',
        };
    },
    components: {
        HeadlineComponent,
    },
    methods: {
        getMyInfo() {
            console.log("this is getMyInfo");
            axios.get("/api/users/me/info").then(res => {
                this.my_info = res.data;
            });
        },
        editPersonal() {
            console.log('this is editPersonal');
            axios
                .patch("/api/users/", {
                    email: this.my_info.email,
                    password: this.password,
                })
                .then(response => {
                    console.log(response);
                    console.log(response.data);
                    if(response.data != 'guest') {
                        alert('メールアドレス/パスワード を変更しました。');
                    }else {
                        alert('ゲストユーザーはメールアドレス/パスワードを変更できません。');
                    }
                    //this.$router.push("/users/" + this.my_info.id + "/posts");

                })
        }
    },
    mounted() {
        this.getMyInfo();
    }
};
</script>
