<template>
  <div>
    <page-header />
    <notifications classes="notification" />
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Kategorie - Typen</h1>
          <router-link :to="{ name: 'category-type-create' }" class="btn-add"><span>Hinzufügen</span></router-link>
          <div class="list-items" v-if="categoryTypes.length">
            <div :class="[categoryType.publish == 0 ? 'is-disabled' : '', 'list-item']" v-for="categoryType in categoryTypes" :key="categoryType.id">
              <div class="list-item-body">
                <h3>{{ categoryType.name_singular.de }}</h3>
              </div>
              <div class="list-item-action">
                <a href="javascript:;" :class="[categoryType.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']" @click.prevent="toggleStatus(categoryType.id)"></a>
                <router-link :to="{name: 'category-type-edit', params: { id: categoryType.id }}" class="icon-edit icon-mini"></router-link>
                <a href="javascript:;" class="icon-copy icon-mini" @click.prevent="clone(categoryType.id)"></a>
                <a href="javascript:;" class="icon-trash icon-mini" @click.prevent="destroy(categoryType.id)"></a>
              </div>
            </div>
          </div>
          <div v-else>
            <p>Es sind keine Typen vorhanden...</p>
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
        categoryTypes: [],
        debounce: false,
      }
    },

    created() {
        let uri = '/api/types/get';
        this.axios.get(uri).then(response => {
          this.categoryTypes = response.data.data;
          console.log(this.categoryTypes);
        });
    },

    methods: {

      destroy(id) {
        let uri = `/api/type/destroy/${id}`;
        this.axios.delete(uri).then(response => {
          this.categoryTypes = response.data.data;
          this.$notify({type: 'success', text: 'Eintrag gelöscht'});
        });
      },
      
      clone(id) {
        let uri = `/api/type/clone/${id}`;
        this.axios.get(uri).then(response => {
          this.categoryTypes = response.data.data;
          this.$notify({type: 'success', text: 'Eintrag kopiert'});
        });        
      },

      toggleStatus(id) {
        let uri = `/api/type/status/${id}`;
        this.axios.get(uri).then(response => {
          const index = this.categoryTypes.findIndex(x => x.id === id);
          this.categoryTypes[index].publish = response.data;
          this.$notify({type: 'success', text: 'Status angepasst'});
        });
      },
    }
  }
</script>