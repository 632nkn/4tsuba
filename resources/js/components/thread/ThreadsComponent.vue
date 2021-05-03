<template>
    <div>
        <!-- ソート -->
        <sort-component></sort-component>

        <!-- スレッド一覧 -->
        <div v-for="thread in threads" :key="thread.id">
            <!-- 1つのスレッドを描画 -->
            <thread-object-component
                v-bind:thread="thread"
            ></thread-object-component>
        </div>

        <!-- ページネーション -->
        <template>
            <div class="text-center">
                <v-pagination
                    v-model="page"
                    :length="15"
                    :total-visible="7"
                ></v-pagination>
            </div>
        </template>
    </div>
</template>

<script>
// コンポーネントをインポート
import ThreadObjectComponent from "./ThreadObjectComponent.vue";
import SortComponent from "./SortComponent";

export default {
    data() {
        return {
            threads: [],
            page: 10
        };
    },
    methods: {
        getThreads() {
            axios.get("/api/threads/").then(res => {
                this.threads = res.data;
            });
        }
    },
    components: {
        ThreadObjectComponent,
        SortComponent
    },
    mounted() {
        this.getThreads();
    }
};
</script>
