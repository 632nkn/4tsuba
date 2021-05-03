<template>
    <div class="d-flex justify-end">
        <headline-component v-bind:headline="headline"></headline-component>
        <v-spacer></v-spacer>
        <v-app-bar flat max-width="180" color="white">
            <v-autocomplete
                color="green lighten-2"
                item-color="green lighten-2"
                append-icon="mdi-menu"
                v-model="selected_item"
                :items="items"
                hint="並び順"
                persistent-hint
                :placeholder="items[0]"
                @change="changeSort()"
            ></v-autocomplete>

            <v-checkbox
                color="green lighten-2"
                on-icon="mdi-arrow-down-bold"
                off-icon="mdi-arrow-up-bold"
                :hint="hint[0]"
                persistent-hint
                v-model="desc"
                class="ml-3"
                @click="
                    changeSort();
                    changeHint();
                "
            ></v-checkbox>
        </v-app-bar>
    </div>
</template>

<script>
// コンポーネントをインポート
import HeadlineComponent from "../common/HeadlineComponent.vue";

export default {
    data() {
        return {
            headline: "スレッド一覧",
            items: ["最終更新", "新着", "書込数", "いいね数"],
            //バインドする変数
            selected_item: null,
            desc: true,
            hint: ["desc", "asc"],
            //メソッドでAPIとして送信する変数
            sort_object: {}
        };
    },
    components: {
        HeadlineComponent
    },
    methods: {
        changeHint() {
            this.hint = this.hint.reverse();
            console.log(this.hint);
        },
        changeSort() {
            console.log(this.items.indexOf(this.selected_item));
            console.log(this.desc);

            this.sort_object.type = this.items.indexOf(this.selected_item);
            this.sort_object.desc = Number(this.desc);
            //初期の「並び順」のとき、itemsに該当する文字がないためindexOfすると-1になってしまう
            //初期状態は「0」(最終更新)であるため無理やり-1を0に変換する
            if (this.sort_object.type == -1) {
                this.sort_object.type = 0;
            }
            console.log(this.sort_object);
        }
    }
};
</script>
