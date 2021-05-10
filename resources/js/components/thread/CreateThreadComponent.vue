<template>
    <div>
        <headline-component v-bind:headline="headline"></headline-component>

        <!-- 入力フォーム -->
        <v-form ref="form" v-model="valid" class="pa-4 ">
            <!-- スレッドタイトル -->
            <v-textarea
                v-model="thread.title"
                :counter="limit.title"
                color="green lightten-2"
                outlined
                rows="1"
                label="スレッドタイトル"
                auto-grow
                :hint="'必須 & 最大' + limit.title + '文字'"
                persistent-hint
                :rules="[rules.required, rules.length_title]"
            ></v-textarea>

            <!-- 本文 -->
            <v-textarea
                class="mt-6"
                v-model="thread.body"
                :counter="limit.body"
                color="green lightten-2"
                outlined
                label="本文"
                auto-grow
                :hint="'必須 & 最大' + limit.body + '文字'"
                persistent-hint
                :rules="[rules.required, rules.length_body]"
            ></v-textarea>

            <!-- 画像 -->
            <v-file-input
                v-model="thread.image"
                color="green lightten-2"
                accept="image/png, image/gif, image/jpg, image/jpeg"
                placeholder="JPG, JPEG, PNG, GIF"
                hint="スレッドのサムネイル(※)を設定できます。 ※スレッド内で最も若い番号(書き込み順)の画像"
                persistent-hint
                chips
                show-size
            ></v-file-input>

            <div class="mt-16 grey--text text--darken-1">
                <v-icon class="mb-1" color="green lighten-3"
                    >mdi-information-outline</v-icon
                >
                スレッドは削除できません(スレッド内の書き込みは編集・削除可)。
            </div>
        </v-form>

        <v-divider></v-divider>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                :disabled="!valid"
                class="white--text"
                color="green lighten-2"
                depressed
                @click="submit"
            >
                スレッドを作成する
            </v-btn>
        </v-card-actions>
    </div>
</template>

<script>
// コンポーネントをインポート
import HeadlineComponent from "../common/HeadlineComponent.vue";

export default {
    data: function() {
        return {
            headline: "スレッドを作成する",
            //フォーム項目
            thread: {},
            //バリデーション関連
            limit: { title: 10, body: 20 },
            valid: null,
            rules: {
                required: value => !!value || "必ず入力してください",
                //「value &&」がないと初期状態(すなわちvalue = null)のとき、valueが読み取れませんとエラーが出る
                length_title: value =>
                    (value && value.length <= this.limit.title) ||
                    this.limit.title + "文字以内で入力してください",
                length_body: value =>
                    (value && value.length <= this.limit.body) ||
                    this.limit.body + "文字以内で入力してください"
            }
        };
    },
    components: {
        HeadlineComponent
    },
    methods: {
        submit() {
            const result = this.$refs.form.validate();
            console.log("入力内容バリデーション" + result);
            console.log(this.thread.title);
            console.log(this.thread.body);
            console.log(this.thread.image);

            const form_data = new FormData();
            form_data.append("title", this.thread.title);
            form_data.append("body", this.thread.body);
            form_data.append("image", this.thread.image);

            axios
                .post("/api/threads", form_data, {
                    headers: { "content-type": "multipart/form-data" }
                })
                .then(response => {
                    console.log(response);
                    this.$router.push({ name: "threads" });
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        }
    }
};
</script>
