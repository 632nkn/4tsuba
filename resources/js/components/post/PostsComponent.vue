<template>
    <div>
        <div @click="getPosts" style="cursor: pointer;">
        <thread-object-component
            v-bind:thread="thread"
        ></thread-object-component>
        </div>

        <!-- ポスト部分 -->
        <div v-for="(post, index) in posts" :key="post.id">
            <post-object-component
                v-bind:post="post"
                v-bind:index="index"
                v-bind:my_id="my_id"
                @receiveUpdate="updateEntry"
                @receiveForResponses="getResponses"
            >
            </post-object-component>
        </div>

        <v-divider></v-divider>
        <!-- 書き込み部分 -->
        <create-component @receiveInput="storePost"></create-component>
    </div>
</template>

<script>
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
            default: 1
        }
    },
    data() {
        return {
            my_id: 0,
            thread: {},
            posts: {}
        };
    },
    methods: {
        getMyId() {
            console.log("this is getMyId");
            axios.get("/api/users/me").then(res => {
                this.my_id = res.data;
            });
        },
        getThread() {
            console.log("this is getThread");
            axios.get("/api/threads/" + this.thread_id).then(res => {
                this.thread = res.data;
            });
        },
        getPosts() {
            console.log("this is getPosts");
            axios
                .get("/api/posts/", {
                    params: {
                        where: "thread_id",
                        value: this.thread_id
                    }
                })
                .then(res => {
                    this.posts = res.data;
                });
        },
        getResponses(emitted_displayed_post_id) {
            console.log("this is getResponses");
            axios
                .get("/api/posts/", {
                    params: {
                        where: "responses",
                        value: [this.thread_id, emitted_displayed_post_id],
                    }
                })
                .then(res => {
                    this.posts = res.data;
                });
            
        },
        storePost(emitted_form_data) {
            const form_data = emitted_form_data;
            form_data.append("thread_id", this.thread_id);
            console.log("this is post");
            for (let value of form_data.entries()) {
                console.log(value);
            }
            axios
                .post("/api/posts", form_data, {
                    headers: { "content-type": "multipart/form-data" }
                })
                .then(response => {
                    console.log(response);
                    console.log("書き込み作成");
                    this.updateEntry();
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        },
        updateEntry() {
            console.log('this is updateEntry');
            this.getPosts();
            this.getThread();
        },
    },
    components: {
        ThreadObjectComponent,
        PostObjectComponent,
        CreateComponent
    },
    mounted() {
        this.getMyId();
        this.getThread();
        this.getPosts();
    }
};
</script>
