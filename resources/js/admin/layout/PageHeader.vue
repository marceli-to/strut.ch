<template>
    <div>
        <header class="site-header">
            <div>
                <a href="/" class="brand"></a>
                <a href="javascript:;" @click="toggleMenu()" class="icon-menu"></a>
            </div>
        </header>
        <nav class="site-nav" :class="{'is-visible': menuVisible}">
            <div>
                <router-link :to="{ name: 'logout' }" class="icon-logout">Logout</router-link>
                <a href="javascript:;" @click="toggleMenu()" class="icon-close"></a>
            </div>
            <ul>
                <li>
                    <router-link :to="{ name: 'posts' }">Posts</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'masonry' }">Masonry</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'jobs' }">Jobs</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'team' }">Team</router-link>
                </li>
            </ul>
        </nav>
    </div>
</template>
<script>
export default {
    data() {
        return {
            menuVisible: false
        }
    },
    methods: {
        toggleMenu() {
            this.menuVisible = !this.menuVisible;
        }
    }
}
</script>