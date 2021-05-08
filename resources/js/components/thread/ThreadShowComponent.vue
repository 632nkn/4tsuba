<template>
    <div>
        <!-- スレッドオブジェクト-->
        <thread-object-component
            v-bind:thread="thread"
        ></thread-object-component>
    </div>
</template>

<script>
// コンポーネントをインポート
import ThreadObjectComponent from "./ThreadObjectComponent.vue";

export default {
    props: {
        thread_id: {
            type: Number,
            default: 1,
            required: true
        }
    },
    data() {
        return {
            thread: {}
        };
    },
    methods: {
        getThread() {
            console.log("this is getThread");
            axios.get("/api/threads/" + this.thread_id).then(res => {
                this.thread = res.data;
            });
        }
    },
    components: {
        ThreadObjectComponent
    },
    mounted() {
        this.getThread();
    }
};
</script>
