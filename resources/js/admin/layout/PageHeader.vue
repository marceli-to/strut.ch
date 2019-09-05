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
                    <a href="javascript:;" style="padding-bottom: 0">Projekte</a>
                    <ul>
                        <li>
                            <router-link :to="{ name: 'categories' }">Kategorien</router-link>
                        </li>
                        <!-- <li>
                            <router-link :to="{ name: 'category-types' }">Typen</router-link>
                        </li> -->
                    </ul>
                </li>
                <li>
                    <span>Büro</span>
                    <ul>
                        <li>
                            <router-link :to="{ name: 'jobs' }">Jobs</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'team' }">Team</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'awards' }">Auszeichnungen</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'lectures' }">Vorträge</router-link>
                        </li>
                    </ul>
                </li>
                <li>
                    <span>Publikationen</span>
                    <ul>
                        <li>
                            <router-link :to="{ name: 'books' }">Bücher</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'press' }">Presse</router-link>
                        </li>
                    </ul>
                </li>

            </ul>
            <router-link :to="{ name: 'logout' }" class="icon-logout">Logout</router-link>
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