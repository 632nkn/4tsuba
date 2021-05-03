<template>
<div>
    <h1>Bコンポーネント</h1>
    <c-component></c-component>
</div>
</template>

<script>
    // コンポーネントCをインポート
    import CComponent from './CComponent.vue';

    export default {
        // componentsでコンポーネントBを登録(ここで登録してないと、エラーになる)
        components: {
            'c-component': CComponent
        },
    }
</script>