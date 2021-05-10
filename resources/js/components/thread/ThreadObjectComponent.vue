<template>
    <v-card color="green lighten-4" outlined class="my-3">
        <div class="d-flex">
            <v-avatar class="ma-3" size="80" tile>
                <v-img :src="thread.src"></v-img>
            </v-avatar>
            <div>
                <v-card-title v-html="thread.title"></v-card-title>
                <v-card-text>
                    <v-icon>mdi-comment</v-icon>
                    <span v-html="thread.post_count"></span>
                    <v-icon>mdi-heart</v-icon>
                    <span v-html="thread.like_count"></span>
                    <span
                        v-html="'(最終更新：' + thread.updated_at + ')'"
                    ></span>
                </v-card-text>
            </div>
        </div>
    </v-card>
</template>

<script>
export default {
    props: {
        thread: {
            type: Object,
            default: null,
            required: true
        }
    }
};
</script>
