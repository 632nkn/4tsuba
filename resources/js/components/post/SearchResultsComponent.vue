<template>
    <div>
        <headline-component v-bind:headline="'検索結果：'+ posts.length + '件  「' + unique_word_list.join('」OR「') + '」'">
        </headline-component>

        <!-- ポスト部分 -->
        <div v-for="(post, index) in posts" :key="post.id">
            <post-object-component
                v-bind:post="post"
                v-bind:index="index"
                v-bind:my_id="my_id"
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
            my_id: 0,
            thread: {},
            posts: {},
            unique_word_list: {},
        };
    },
    methods: {
        getMyId() {
            console.log("this is getMyId");
            axios.get("/api/users/me").then(res => {
                this.my_id = res.data;
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
        giveHightlight(search_word) {
            let hightlighted_word = '<span class="indigo--text">' + search_word + '</span>';
            return hightlighted_word;
        } 
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
        this.getMyId();
        this.getSearchedPosts();
    },
};
</script>
