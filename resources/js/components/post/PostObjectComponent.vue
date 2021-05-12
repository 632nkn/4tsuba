<template>
    <v-card color="cyan lighten-5" outlined class="my-3">
        <div>
            <!-- １行目 -->
            <v-card-text>
                <span v-html="post.displayed_post_id"></span>
                <span v-html="post.user.name"></span>
                <span v-html="post.created_at"></span>
                <v-checkbox
                    color="green lighten-2"
                    on-icon="mdi-heart"
                    off-icon="mdi-heart-outline"
                    v-model="true_or_false"
                    class="ml-3"
                    :label="String(post.likes_count)"
                    @click="switchLike()"
                ></v-checkbox>
            </v-card-text>
            <!-- ２行目 -->
            <div class="d-flex">
                <template v-if="post.image">
                    <v-avatar class="ma-3" size="250" tile>
                        <!-- vueのルート publicディレクトリからの相対パスを記入する この場合 public/storage/images/example.png -->
                        <img
                            :src="'/storage/images/' + post.image.image_name"
                            style="object-fit: contain;"
                        />
                    </v-avatar>
                </template>
                <v-card-text>
                    <div v-html="post.body"></div>
                    <template v-if="post.responded_count">
                        <v-icon>mdi-message</v-icon>
                        <span>{{post.responded_count}}件の返信</span>
                    </template>
                </v-card-text>

            </div>
        </div>
    </v-card>
</template>

<script>
export default {
    props: {
        post: {
            type: Object,
            default: null,
            required: true
        }
    },
    data() {
        return {
            true_or_false: Boolean(this.post.login_user_liked),
        };
    },
    methods: {
        switchLike() {
            //チェックボックスを押すと false → true になってこの処理(いいね登録)が走る
            if(this.true_or_false) {
                console.log('this is Like');
                console.log(this.post.thread_id);
                console.log(this.post.id);
                axios
                    .put("/api/like", {
                        thread_id: this.post.thread_id,
                        post_id: this.post.id,
                    })
                    .then(response => {
                        console.log(response);
                        console.log('いいね登録');
                        this.post.likes_count++;
                        this.post.login_user_liked++;
                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            //いいね解除
            } else {
                console.log('this is unLike');
                console.log(this.post.thread_id);
                console.log(this.post.id);
                axios
                    .delete("/api/like", {data:{
                        thread_id: this.post.thread_id,
                        post_id: this.post.id,
                    }})
                    .then(response => {
                        console.log(response);
                        console.log('いいね解除');
                        this.post.likes_count--;
                        this.post.login_user_liked--;
                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            }
        },
    }
};
</script>
