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

        <v-divider></v-divider>
        <!-- 書き込み部分 -->
        <create-component @receiveInput="post"></create-component>
    </div>
</template>

<script>
// コンポーネントをインポート
import ThreadObjectComponent from "../thread/ThreadObjectComponent.vue";
import PostObjectComponent from "./PostObjectComponent.vue";
import CreateComponent from "../common/CreateComponent.vue";

export default {
    //このpropsは親コンポーネントではなく、router-linkのparam
    props: {
        thread_id: {
            type: Number,
            default: 1,
            required: true
        },
        dest_d_post_id: {
            type: Number,
            default: 1,
        }
    },
    data() {
        return {
            thread: {},
            posts: {},
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
            axios.get("/api/posts/thread/" + this.thread_id).then(res => {
                this.posts = res.data;
            });
        },
        post(emited_form_data) {
            
            const form_data = emited_form_data;
            form_data.append("thread_id", this.thread_id);
            console.log('this is post');
            for (let value of form_data.entries()) { 
                console.log(value);
            }
            
            axios
            .post("/api/posts", form_data, {
                headers: { "content-type": "multipart/form-data" }
            })
            .then(response => {
                console.log(response);
                console.log('書き込み作成');

                //書き込み再描画
                this.getPosts();
            })
            .catch(error => {
                console.log(error.response.data);
            });
        } 
    },
    components: {
        ThreadObjectComponent,
        PostObjectComponent,
        CreateComponent,
    },
    mounted() {
        this.getThread();
        this.getPosts();
    }
};
</script>
