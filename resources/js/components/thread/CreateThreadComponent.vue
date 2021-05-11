<template>
    <div>
        <headline-component v-bind:headline="headline"></headline-component>
        <create-component v-bind:thread_or_post="thread_or_post"></create-component>
    </div>
</template>

<script>
// コンポーネントをインポート
import HeadlineComponent from "../common/HeadlineComponent.vue";
import CreateComponent from "../common/CreateComponent.vue";

export default {
    data: function() {
        return {
            headline: "スレッドを作成する",
            thread_or_post: 'thread',
        };
    },
    components: {
        HeadlineComponent,
        CreateComponent,
    },
};
</script>
