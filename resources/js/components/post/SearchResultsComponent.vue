<template>
    <div>
        <headline-component v-bind:headline="'検索結果：'+ posts.length + '件  「' + unique_word_list.join('」OR「') + '」'">
        </headline-component>

        <!-- ポスト部分 -->
        <div v-for="(post, index) in posts" :key="post.id">
            <post-object-component
                v-bind:post="post"
                v-bind:index="index"
                v-bind:my_info="my_info"
                v-bind:need_thread="true"
                v-bind:search="true"
            >
            </post-object-component>
        </div>

        <v-divider></v-divider>
    </div>
</template>

<script>
import HeadlineComponent from "../common/HeadlineComponent.vue";
import PostObjectComponent from "./PostObjectComponent.vue";

export default {
    //このpropsは親コンポーネントではなく、router-linkのparam
    props: {
        search_string: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            my_info: {},
            thread: {},
            posts: {},
            unique_word_list: {},
        };
    },
    methods: {
        getMyInfo() {
            console.log("this is getMyInfo");
            axios.get("/api/users/me/info").then(res => {
                this.my_info = res.data;
            });
        },
        getSearchedPosts() {
            console.log("this is getSearchedPosts");
            console.log(this.search_string);
            //const trimed_search_string = this.search_string.trim()
            const search_word_list = this.search_string.trim().split(/[(\s)|(\t)]+/);
            console.log(search_word_list);
            //重複削除
            const set_word_list = new Set(search_word_list);
            this.unique_word_list = Array.from(set_word_list);
            console.log(this.unique_word_list);
            axios
                .get("/api/posts/", {
                    params: {
                        where: "search",
                        value: this.unique_word_list
                    }
                })
                .then(res => {
                    this.posts = res.data;
                    this.highlightSearchWord();
                });

                
        },
        highlightSearchWord() {
            console.log("this is hightlightSearchWord");
            const unique_word_string = this.unique_word_list.join('|');
            let regular_expressiion = new RegExp('(' + unique_word_string + ')', 'gi');
            console.log(regular_expressiion);

            this.posts.forEach(function(post) {
                post['body_for_search'] = post['body'].replace(regular_expressiion, '<span class="green lighten-3 font-weight-bold">$&</span>');
            })
            

        },
    },
    watch: {
        search_string: function() {
            this.getSearchedPosts();
        }
    },
    components: {
        HeadlineComponent,
        PostObjectComponent,
    },
    mounted() {
        this.getMyInfo();
        this.getSearchedPosts();
    },
};
</script>
