<template>
    <div>
        <headline-component v-bind:headline="headline"></headline-component>

        <v-card flat class="ml-4">
            <v-toolbar color="green lighten-5" flat>
                <v-toolbar-title class="green--text">{{ user_info.name }}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn v-if="my_id == user_id"
                        class="white--text"
                        color="green lighten-2"
                        depressed
                        to=/setting/account/name
                >
                        表示名を変更
                </v-btn>

                <template v-slot:extension>
                    <!-- タブ -->
                    <v-tabs
                        color="green lighten-2"
                        v-model="tab"
                        icons-and-text
                        light
                    >
                        <v-tabs-slider></v-tabs-slider>
                        <!-- @clickにtab.methodのようにしようとしたいができない -->
                        <v-tab :to="tabs[0].link" @click="updatePosts">
                            {{ tabs[0].name }}
                            <v-icon>{{ tabs[0].icon }}</v-icon>
                        </v-tab>
                        <v-tab :to="tabs[1].link" @click="updatePosts">
                            {{ tabs[1].name }}
                            <v-icon>{{ tabs[1].icon }}</v-icon>
                        </v-tab>
                    </v-tabs>
                </template>
            </v-toolbar>

            <!-- タブ中身s -->
            <v-tabs-items v-model="tab">
                <!-- タブ中身 書込 -->
                <v-tab-item value="posts">
                <div class="my-2 green--text text--lighten-1">{{user_info.posts_count}}件の書込</div>
                  
                    <div v-for="(post, index) in user_posts" :key="post.id">
                        <post-object-component
                            v-bind:post="post"
                            v-bind:index="index"
                            v-bind:my_id="my_id"
                            v-bind:need_thread="true"
                            ref="child"
                        >
                        </post-object-component>
                    </div>
                </v-tab-item>

                <!-- タブ中身 いいね -->
                <v-tab-item value="likes">
                <div class="my-2 green--text text--lighten-1">{{user_info.likes_count}}件のいいね</div>                
                    <div
                        v-for="(post, index) in user_like_posts"
                        :key="post.id"
                    >
                        <post-object-component
                            v-bind:post="post"
                            v-bind:index="index"
                            v-bind:my_id="my_id"
                            v-bind:need_thread="true"
                            @receiveTrueOrFalse="callUpdateTrueOrFalse"
                        >
                        </post-object-component>
                    </div>
                </v-tab-item>

                <!-- タブ中身 お気に入りスレッド -->
                <v-tab-item value="threads">
                    <v-card flat>
                        <v-card-text>ccc</v-card-text>
                    </v-card>
                </v-tab-item>
            </v-tabs-items>
        </v-card>
    </div>
</template>

<script>
import HeadlineComponent from "../common/HeadlineComponent.vue";
import UserPostsComponent from "./UserPostsComponent.vue";
import PostObjectComponent from "../post/PostObjectComponent.vue";
export default {
    data() {
        return {
            headline: "ユーザープロフィール",
            my_id: 0,
            user_id: this.$route.params.user_id,
            user_info: {},
            user_posts: null,
            user_like_posts: null,
            tab: null,
            tabs: [
                {
                    name: "書込",
                    icon: "mdi-post",
                    link: "posts"
                },
                {
                    name: "いいね",
                    icon: "mdi-heart",
                    link: "likes"
                },
                {
                    name: "ブックマークスレッド",
                    icon: "mdi-star",
                    link: "threads"
                }
            ]
        };
    },
    components: {
        HeadlineComponent,
        UserPostsComponent,
        PostObjectComponent
    },
    methods: {
        getMyId() {
            console.log("this is getMyId");
            axios.get("/api/users/me").then(res => {
                this.my_id = res.data;
            });
        },
        getUserInfo() {
            console.log("this is getUserInfo");
            axios.get("/api/users/" + this.user_id).then(res => {
                this.user_info = res.data;
            });
        },
        getUserPosts() {
            console.log("this is getUserPosts");
            axios
                .get("/api/posts/", {
                    params: {
                        where: "user_id",
                        value: this.user_id
                    }
                })
                .then(res => {
                    this.user_posts = res.data;
                });
        },
        getUserLikePosts() {
            console.log("this is getUserLikePosts");
            axios
                .get("/api/posts/", {
                    params: {
                        where: "user_like",
                        value: this.user_id
                    }
                })
                .then(res => {
                    this.user_like_posts = res.data;
                });
        },
        updatePosts(emited_post_id) {
          this.getUserLikePosts();
          this.getUserPosts();
        },
        //自分のプロフィールだった場合、「いいね」側でのハートマークの変更を「書込」側のハートマークへ反映
        callUpdateTrueOrFalse(emited_post_id) {
            if(this.my_id == this.user_id) {
                console.log('this is callUpdateTrueOrFalse');
                for(let i=0; i<this.$refs.child.length; i++) {
                    if(this.$refs.child[i].post.id == emited_post_id) {
                        console.log('identified,' + this.$refs.child[i].post.id);
                        this.$refs.child[i].updateTrueOrFalse();
                    }
                }
            }
        },
    },
    mounted() {
        this.getMyId();
        this.getUserInfo();
        this.getUserPosts();
        this.getUserLikePosts();
    }
};
</script>
