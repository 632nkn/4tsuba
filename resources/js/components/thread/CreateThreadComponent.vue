<template>
    <div>
        <headline-component v-bind:headline="headline"></headline-component>
        <create-component v-bind:thread_or_post="thread_or_post" @receiveInput="create"></create-component>
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
    methods: {
        create(emited_form_data) {
            const form_data = emited_form_data;
            console.log('this is post');
            for (let value of form_data.entries()) { 
                console.log(value);
            }

            axios
                .post("/api/threads", form_data, {
                    headers: { "content-type": "multipart/form-data" }
                })
                .then(response => {
                    console.log(response);
                    console.log('スレッド作成');
                    this.$router.push({ name: "threads" });
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        }

    },
    components: {
        HeadlineComponent,
        CreateComponent,
    },
};
</script>
