<template>
    <div>
        <div class="d-flex justify-end">
            <headline-component v-bind:headline="headline"></headline-component>
            <v-spacer></v-spacer>
            <!-- 子コンポーネントからのemit受け取り @イベント名="メソッド名" -->
            <sort-component @receiveSortObject="updateSort"></sort-component>
        </div>

        <!-- スレッド一覧 -->
        <div v-for="thread in threads" :key="thread.id">
            <!-- 1つのスレッドを描画 -->
            <router-link
                style="text-decoration: none;"
                v-bind:to="{
                    name: 'thread.show',
                    params: { thread_id: thread.id }
                }"
            >
                <thread-object-component
                    v-bind:thread="thread"
                ></thread-object-component>
            </router-link>
        </div>
    </div>
</template>

<script>
import HeadlineComponent from "../common/HeadlineComponent.vue";
import SortComponent from "./SortComponent";
import ThreadObjectComponent from "./ThreadObjectComponent.vue";

export default {
    data() {
        return {
            threads: [],
            headline: "スレッド一覧",
            received_sort_object: {}
        };
    },
    methods: {
        updateSort(emited_sort_object) {
            console.log("this is updateSort");
            this.received_sort_object = emited_sort_object;
            console.log(this.received_sort_object);

            //他のメソッドはthis.methodName()で実行できる
            this.getThreads();
        },
        getThreads() {
            console.log("this is getThreads");
            axios
                .get("/api/threads", {
                    params: {
                        sort: this.received_sort_object.sort,
                        order: this.received_sort_object.order
                    }
                })
                .then(res => {
                    this.threads = res.data;
                });
        }
    },
    components: {
        HeadlineComponent,
        SortComponent,
        ThreadObjectComponent
    },
    mounted() {
        this.getThreads();
    }
};
</script>
