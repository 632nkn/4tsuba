<template>
    <div>

        <!-- 入力フォーム -->
        <v-form ref="form" v-model="valid" class="pa-4 ">
            <!-- スレッドタイトル -->
            <v-textarea v-if="thread_or_post === 'thread'"
                v-model="input.title"
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
                v-model="input.body"
                :counter="limit.body"
                color="green lightten-2"
                outlined
                :label="body_label[0]"
                auto-grow
                :hint="'必須 & 最大' + limit.body + '文字'"
                persistent-hint
                :rules="[rules.required, rules.length_body]"
            ></v-textarea>

            <!-- 画像 -->
            <v-file-input
                v-model="input.image"
                color="green lightten-2"
                accept="image/png, image/gif, image/jpg, image/jpeg"
                placeholder="JPG, JPEG, PNG, GIF"
                :hint="hint[0]"
                persistent-hint
                chips
                show-size
            ></v-file-input>

            <template v-if="thread_or_post === 'thread'">
            <div  class="mt-16 grey--text text--darken-1">
                <v-icon class="mb-1" color="green lighten-3"
                    >mdi-information-outline</v-icon
                >
                スレッドは削除できません(スレッド内の書き込みは編集・削除可)。
            </div>
            </template>
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
                {{button_message[0]}}
            </v-btn>
        </v-card-actions>
    </div>
</template>

<script>

export default {
    props: {
        thread_or_post: {
            type: String,
            default: "post",
        },
        thread_id: {
            type: Number,
            default: 1
        }
    },
    data: function() {
        return {
            //入力項目
            input: {},
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
            },
            hint: ["", "スレッドのサムネイル(※)を設定できます。 ※スレッド内で最も若い番号(書き込み順)の画像"],
            button_message: ["書き込む", "スレッドを作成する"],
            body_label: ["書き込む", "本文"],
        };
    },
    methods: {
        submit() {
            const result = this.$refs.form.validate();
            console.log("入力内容バリデーション " + result);
            console.log(this.input.title);
            console.log(this.input.body);
            console.log(this.input.image);

            const form_data = new FormData();
            form_data.append("body", this.input.body);
            form_data.append("image", this.input.image);

            if(this.thread_or_post === 'thread') {
            form_data.append("title", this.input.title);
            axios
                .post("/api/threads", form_data, {
                    headers: { "content-type": "multipart/form-data" }
                })
                .then(response => {
                    console.log(response);
                    console.log('スレッド作成');
                    this.$router.push({ name: "threads" });
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            } else {
            form_data.append("thread_id", this.thread_id);
              axios
                .post("/api/posts", form_data, {
                    headers: { "content-type": "multipart/form-data" }
                })
                .then(response => {
                    console.log(response);
                    console.log('書き込み作成');
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            }
        },
        switchWords() {
            if(this.thread_or_post === 'thread') {
                this.hint = this.hint.reverse();
                this.button_message = this.button_message.reverse();
                this.body_label = this.body_label.reverse();
            }
        }

    },
    mounted() {
        this.switchWords();
    }
};
</script>
