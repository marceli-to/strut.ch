<template>
  <div>
    <header class="site-header">
      <div>
        <a href="/admin/" class="brand"></a>
        <a href="javascript:;" @click="toggleMenu()" class="icon-menu"></a>
      </div>
    </header>
    <nav class="site-nav" :class="{'is-visible': menuVisible}">
      <div>
        <a href="javascript:;" @click="toggleMenu()" class="icon-close"></a>
      </div>
      <ul>
        <li>
          <router-link :to="{ name: 'home' }">Home</router-link>
        </li>
        <li>
          <router-link :to="{ name: 'news' }">News</router-link>
        </li>
        <li>
          <router-link :to="{ name: 'projects' }">Bauten</router-link>
          <ul>
            <li>
              <router-link :to="{ name: 'categories' }">Kategorien</router-link>
            </li>
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
        <li>
          <router-link :to="{ name: 'contents' }">Statischer content</router-link>
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
    };
  },
  methods: {
    toggleMenu() {
      this.menuVisible = !this.menuVisible;
    }
  }
};
</script>