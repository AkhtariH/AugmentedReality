<template>
    <nav>
        <v-app-bar color="blue" dark app>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer">

            </v-app-bar-nav-icon>
            <v-toolbar-title class="text-uppercase">
                <span class="font-weight-bold">AR</span>
                <span>T</span>
                <v-spacer></v-spacer>
               
            </v-toolbar-title>
        </v-app-bar>
        <v-navigation-drawer v-model="drawer"   dark app class="blue accent-2">
            <v-list flat>
                <v-list-item v-for="link in links" :key="link.text" router :to="link.route" active-class="border">
                    <v-list-item-action>
                        <v-icon>{{link.icon}}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>{{link.text}}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
    </nav>
</template>

<script>
export default {
    data: () =>({
        drawer:true,
        links: [
            {icon: 'fas fa-home', text: 'Home', route: '/'},
            {icon: 'fas fa-upload', text: 'Upload new object', route: '/upload'},
            {icon: 'fas fa-map-marked', text: 'Map', route: '/map'},
            {icon: 'fas fa-cogs', text: 'Settings', route: '/settings'}
            
        ]
    })
}
</script>

<style scoped>
.border{
    border-left: 4px solid #2c3e50;
}
</style>