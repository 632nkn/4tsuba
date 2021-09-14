<template>
    <div color="red">
        <headline-component :headline="headline"></headline-component>
        <v-spacer />
        <v-row>
            <v-col cols="1"></v-col>
            <v-col cols="5">
                <mute-word-form-component
                    class="mt-6"
                    v-bind:my_id="my_id"@receiveUpdate="getMuteWords"

                ></mute-word-form-component>                
            </v-col>
            <v-col cols="6">
                <div v-for="(mute_word) in mute_words" :key="mute_word.id">
                <mute-word-object-component
                v-bind:mute_word="mute_word"
                @receiveUpdate="getMuteWords"
                >
                </mute-word-object-component>
                </div>
            </v-col>
        </v-row>
    </div>
    
</template>
<script>
import HeadlineComponent from "../common/HeadlineComponent.vue";
import MuteWordObjectComponent from "./MuteWordObjectComponent.vue";
import MuteWordFormComponent from "./MuteWordFormComponent.vue";

export default {
    data() {
        return {
            headline: 'ミュートワード設定',
            my_id: 0,
            mute_words: {},
        }
    },
    methods: {
        getMyId() {
            console.log("this is getMyId");
            axios.get("/api/users/me").then(res => {
                this.my_id = res.data;
            });
        },
        getMuteWords() {
            console.log('this is getMuteWords');
            axios.get("/api/mute_words").then(
                res => {
                this.mute_words = res.data;
                console.log(this.mute_words);
            })
        },
    },
    components: {
        HeadlineComponent,
        MuteWordObjectComponent,
        MuteWordFormComponent,
    },
    mounted() {
        this.getMyId();
        this.getMuteWords();
    }
}
</script>
