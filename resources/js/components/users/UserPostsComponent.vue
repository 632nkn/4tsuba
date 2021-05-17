<template>
    <div>
        <h1>UserPostsComponent</h1>
    <post-object-component></post-object-component>
    </div>
</template>
<script>
import PostObjectComponent from "../post/PostObjectComponent.vue"
export default {
    props: {
        //router-linkからのprops
        user_id: {
            type: Number,
            required: true
        },
    },
    data() {
        return {
            posts: [],
            
        };
    },
    methods: {
        getUserPosts() {
            console.log("this is getUserPosts");
            axios
                .get("/api/users/" + this.user_id + "/post")
                .then(res => {
                    this.posts = res.data;
                });
        }
    },
    mounted() {
        //this.getUserPosts();
    },
    components: {
        PostObjectComponent,
    }
};
</script>
