<template>
    <div>
        <headline-component v-bind:headline="headline"></headline-component>

        <v-form ref="form" v-model="valid">
            <v-text-field
                label="表示名"
                color="green lightten-3"
                name="name"
                prepend-icon="mdi-account"
                type="text"
                v-model="my_info.name"
                :rules="[rules.required]"
            />
        </v-form>
        <div class="d-flex justify-end">
        <v-btn
            :disabled="!valid"
            class="white--text"
            color="green lighten-2"
            depressed
            @click="changeName"
        >
             {{message}}
        </v-btn>
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
            headline: "表示名変更",
            my_info: {},
            valid: null,
            rules: {
                required: value => !!value || "必ず入力してください",
            },
            notice: 'メールアドレス / パスワード の変更はこちら',
            link: '/setting/account/confirm',
            message: '変更する'
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
        changeName() {
            console.log('this is changeName');
            axios
                .patch("/api/users/" + this.my_info.id, {
                    name: this.my_info.name,
                })
                .then(response => {
                    console.log(response);
                    this.$router.push("/users/" + this.my_info.id + "/posts");
                })

        }
    },
    mounted() {
        this.getMyInfo();
    }
};
</script>
