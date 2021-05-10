<template>
    <v-card color="cyan lighten-5" outlined class="my-3">
        <div>
            <!-- １行目 -->
            <v-card-text>
                <span v-html="post.displayed_post_id"></span>
                <span v-html="post.user.name"></span>
                <span v-html="post.created_at"></span>
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
                    <span v-html="post.body"></span>
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
        return {};
    }
};
</script>
