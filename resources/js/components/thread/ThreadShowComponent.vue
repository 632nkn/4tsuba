<template>
    <div>
        <!-- スレッドオブジェクト-->
        <thread-object-component
            v-bind:thread="thread"
        ></thread-object-component>

        <!-- ポスト部分 -->
        <div v-for="post in posts" :key="post.id">
            <post-object-component v-bind:post="post"> </post-object-component>
        </div>
    </div>
</template>

<script>
// コンポーネントをインポート
import ThreadObjectComponent from "./ThreadObjectComponent.vue";
import PostObjectComponent from "../post/PostObjectComponent.vue";

export default {
    //このpropsは親コンポーネントではなく、router-linkのparam
    props: {
        thread_id: {
            type: Number,
            default: 1,
            required: true
        }
    },
    data() {
        return {
            thread: {},
            posts: {}
        };
    },
    methods: {
        getThread() {
            console.log("this is getThread");
            axios.get("/api/threads/" + this.thread_id).then(res => {
                this.thread = res.data;
            });
        },
        getPosts() {
            console.log("this is getPosts");
            axios.get("/api/posts/all/" + this.thread_id).then(res => {
                this.posts = res.data;
            });
        }
    },
    components: {
        ThreadObjectComponent,
        PostObjectComponent
    },
    mounted() {
        this.getThread();
        this.getPosts();
    }
};
</script>
