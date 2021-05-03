<template>
    <div>
        <v-app-bar color="green lighten-1" app dense dark prominent>
            <v-row  justify="center" align-content="baseline">

            <v-toolbar-title class="mb-10">よつば</v-toolbar-title>

            <v-spacer></v-spacer>

            <v-text-field
                class="mt-5"
                label="書き込みに含まれる単語を検索"
                value="(渋谷 OR 代々木) ランチ"
                hint="AND検索、OR検索に対応しています"
                outlined
            ></v-text-field>

            <v-btn icon class="mt-5">
                <v-icon large >mdi-magnify</v-icon>
            </v-btn>

            <v-btn icon class="mt-5">
                <v-icon large>mdi-login-variant</v-icon>
            </v-btn>

            <v-menu left bottom >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on" class="mt-5">
                        <v-icon large>mdi-dots-vertical</v-icon>
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item v-for="n in 5" :key="n" @click="() => {}">
                        <v-list-item-title>Option {{ n }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
            </v-row>
        </v-app-bar>
    </div>
</template>
