<template>
  <div>
    <page-header />
    <notifications classes="notification" />
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>News</h1>
          <router-link :to="{ name: 'news-create' }" class="btn-add"><span>Hinzufügen</span></router-link>
          <div class="list-items" v-if="news.length">
            <div :class="[n.publish == 0 ? 'is-disabled' : '', 'list-item']" v-for="n in news" :key="n.id">
              <div class="list-item-body">
                <h3>{{ n.title.de }}</h3>
              </div>
              <div class="list-item-action">
                <a href="javascript:;" :class="[n.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']" @click.prevent="toggleStatus(n.id)"></a>
                <router-link :to="{name: 'news-edit', params: { id: n.id }}" class="icon-edit icon-mini"></router-link>
                <a href="javascript:;" class="icon-copy icon-mini" @click.prevent="clone(n.id)"></a>
                <a href="javascript:;" class="icon-trash icon-mini" @click.prevent="destroy(n.id)"></a>
              </div>
            </div>
          </div>
          <div v-else>
            <p>Es sind keine News vorhanden...</p>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
<script>
  import PageHeader from '@/layout/PageHeader.vue';
  export default {
    components: {
      PageHeader: PageHeader,
    },

    data() {
      return {
        news: [],
      }
    },

    created() {
        let uri = '/api/news/get';
        this.axios.get(uri).then(response => {
          this.news = response.data.data;
        });
    },

    methods: {

      destroy(id) {
        if(confirm('Bitte löschen bestätigen!')) {
          let uri = `/api/news/destroy/${id}`, self = this;
          this.axios.delete(uri)
          .then(response => {
            this.news.splice(this.news.indexOf(id), 1);
            self.$notify({type: 'success', text: 'Eintrag gelöscht'});
          })
          .catch(function(error) {
            self.$notify({type: 'error', text: error.response.data});
          });
        }
      },
      
      clone(id) {
        let uri = `/api/news/clone/${id}`;
        this.axios.get(uri).then(response => {
          this.news.push(response.data);
          this.$notify({type: 'success', text: 'Eintrag kopiert'});
        });        
      },

      toggleStatus(id) {
        let uri = `/api/news/status/${id}`;
        this.axios.get(uri).then(response => {
          const index = this.news.findIndex(x => x.id === id);
          this.news[index].publish = response.data;
          this.$notify({type: 'success', text: 'Status angepasst'});
        });
      },
    }
  }
</script>