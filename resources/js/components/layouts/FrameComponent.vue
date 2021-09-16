<template>
    <v-app>
        <!-- ナビゲーションバー -->
        <v-navigation-drawer
            app
            nav
            permanent
            clipped
            :mini-variant="mini"
            mini-variant-width="60"
        >
            <v-container>
                <!-- アバター部分 -->
                <template v-if="my_info">
                    <v-list-item color="green lighten-2" :to="'/users/' + my_info['id'] + '/posts'">
                            <v-list-item-avatar size="50" tile>
                                <img
                                    :src="'/storage/icons/' + my_info.icon_name"
                                    style="object-fit: cover;"
                                />
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title class="green-text">
                                    {{ my_info.name}}
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{my_info.email}}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                    </v-list-item>
                </template>
                <v-divider></v-divider>

                <!-- リスト部分 -->
                <v-list dense>
                    <template v-for="nav_list in nav_lists">
                        <!-- リストがサブリストを持たない場合 -->
                        <v-list-item
                            color="green lighten-2"
                            v-if="!nav_list.lists"
                            :to="nav_list.link"
                            :key="nav_list.name"
                        >
                            <v-list-item-icon>
                                <v-icon>{{ nav_list.icon }}</v-icon>
                                <v-badge
                                    v-if="nav_list.notification"
                                    :content="nav_list.notification"
                                    :value="nav_list.notification"
                                    color="green lighten-2"
                                    overlap
                                >
                                </v-badge>

                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{ nav_list.name }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                        <!-- リストがサブリストを持つ場合 -->
                        <v-list-group
                            color="green lighten-2"
                            v-else
                            no-action
                            :prepend-icon="nav_list.icon"
                            :key="nav_list.name"
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        {{ nav_list.name }}
                                    </v-list-item-title>
                                </v-list-item-content>
                            </template>
                            <v-list-item
                                v-for="list in nav_list.lists"
                                :key="list.name"
                                :to="list.link"
                            >
                                <v-list-item-title>
                                    {{ list.name }}
                                </v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                    </template>
                </v-list>
            </v-container>
        </v-navigation-drawer>

        <!-- ヘッダー -->
        <v-app-bar  color="white" app flat outlined clipped-left height="80" class="green--text" >
            <v-toolbar-title>よつば</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-text-field
                class="mt-5"
                dense
                color="green lighten-2"
                label="書き込みに含まれる単語を検索"
                placeholder="(渋谷 OR 代々木) ランチ"
                hint="複数単語はOR検索になります"
                outlined
                v-model="search_string"
            >
            </v-text-field>
            <router-link 
                style="text-decoration: none;"
                class="green--text text--lighten-1"
                v-bind:to="{name: 'posts.search', params: {search_string: search_string}}"
            >            
                <v-btn
                    icon
                    class="white--text"
                    color="green lighten-2"
                    depressed
                >
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>
            </router-link>            

            <v-toolbar-items>
                <v-btn text to="/login">ログイン</v-btn>
                <v-menu offset-y>
                    <template v-slot:activator="{ on }">
                        <v-btn v-on="on" text
                            >その他<v-icon>mdi-menu-down</v-icon></v-btn
                        >
                    </template>
                    <v-list>
                        <v-list-item
                            v-for="support in supports"
                            :key="support.name"
                            :to="support.link"
                        >
                            <v-list-item-icon>
                                <v-icon>{{ support.icon }}</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>{{
                                    support.name
                                }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-toolbar-items>
        </v-app-bar>

        <!-- コンテンツ表示位置 -->
        <v-main>
            <v-card max-width="800" class="mx-2 mt-6" flat>
            <confirm-login-component></confirm-login-component>
            <router-view />
            </v-card>
        </v-main>

    </v-app>
</template>

<script>
import ConfirmLoginComponent from "../auth/ConfirmLoginComponent.vue";
export default {
    data() {
        return {
            my_info: null,
            search_string: null,
            mini: true,
            supports: [
                {
                    name: "よつばとは？",
                    icon: "mdi-vuetify",
                    link: "/explanation"
                },
                {
                    name: "ユーザー登録",
                    icon: "mdiaccount-plus",
                    link: "/register"
                },
                {
                    name: "作者Github",
                    icon: "mdi-github-face",
                    link: "/guthub-issue-board"
                },
            ],
            nav_lists: [
                {
                    name: "スレッド一覧",
                    icon: "mdi-clipboard-text-multiple",
                    link: "/threads"
                },
                {
                    name: "スレッド作成",
                    icon: "mdi-plus-thick",
                    link: "/threads/create"
                },
                {
                    name: "設定",
                    icon: "mdi-cogs",
                    lists: [
                        {
                            name: "ミュートワード",
                            link: "/setting/mute_words"
                        },
                        {
                            name: "ミュートユーザー",
                            link: "/setting/mute_users"
                        },
                        {
                            name: "マイプロフィール",
                            link: "/setting/account/profile"
                        }
                    ]
                },
                {
                    name: "ログアウト",
                    icon: "mdi-logout",
                    link: "/logout"
                }
            ]
        };
    },
    methods: {
        getMyInfo() {
            console.log("this is getMyInfo");
            axios.get("/api/users/me/info").then(res => {
                this.my_info = res.data;
            });
        },
        handleResize: function() {
            if (window.innerWidth <= 960) {
                this.mini = true;
            } else {
                this.mini = false;
            }
        },
    },
    created() {
        window.addEventListener("resize", this.handleResize);
        this.handleResize();
    },
    destroyed() {
        window.removeEventListener("resize", this.handleResize);
    },
    mounted() {
        this.getMyInfo();
    },
    components: {
        ConfirmLoginComponent,
    }
};
</script>
