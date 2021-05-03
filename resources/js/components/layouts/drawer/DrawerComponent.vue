<template>
<div>
    <v-card height="100">
    </v-card>
    <v-card >
        <v-navigation-drawer
            v-model="drawer"
            :mini-variant.sync="mini"
            permanent
        >
            <v-list-item class="px-2">
                <v-list-item-avatar>
                    <v-img
                        src="https://randomuser.me/api/portraits/men/85.jpg"
                    ></v-img>
                </v-list-item-avatar>

                <v-list-item-title>John Leider</v-list-item-title>

                <v-btn icon @click.stop="mini = !mini">
                    <v-icon>mdi-chevron-left</v-icon>
                </v-btn>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense>
                <v-list-item v-for="item in items" :key="item.title" link>
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
    </v-card>
    </div>
</template>

<script>
export default {
  name: 'App',
  data: () => ({
    items: [
      { title: 'Index', icon: 'mdi-web', url: '/' },
      { title: 'Home', icon: 'mdi-home', url: '/home' },
      { title: 'Favorites', icon: 'mdi-heart', url: '/favorites' },
      { title: 'About', icon: 'mdi-information-variant', url: '/about' }
    ]
  })
}
</script>

