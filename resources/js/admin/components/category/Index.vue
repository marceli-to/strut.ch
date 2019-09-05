<template>
  <div>
    <page-header />
    <notifications classes="notification" />
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Kategorien</h1>
          <router-link :to="{ name: 'category-create' }" class="btn-add"><span>Hinzufügen</span></router-link>
          <div class="list-items" v-if="categories.length">
            <div :class="[category.publish == 0 ? 'is-disabled' : '', 'list-item']" v-for="category in categories" :key="category.id">
              <div class="list-item-body">
                <h3>{{ category.name.de }}</h3>
                
                <div class="list-item-bubbles">
                  <div class="list-item-bubble" v-for="categoryType in category.types" :key="categoryType.id">
                    <div>{{categoryType.name_singular.de}}</div>
                    <div class="list-item-bubble__action">
                      <a href="javascript:;" :class="[categoryType.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']" @click.prevent="toggleTypeStatus(categoryType.id)"></a>
                      <router-link :to="{name: 'category-type-edit', params: { id: categoryType.id }}" class="icon-edit icon-mini"></router-link>
                      <a href="javascript:;" class="icon-copy icon-mini" @click.prevent="cloneType(categoryType.id)"></a>
                      <a href="javascript:;" class="icon-trash icon-mini" @click.prevent="destroyType(categoryType.id)"></a>
                    </div>
                  </div>
                  <div>
                    <router-link :to="{ name: 'category-type-create' }" class="btn-add">
                      <span>Typ hinzufügen</span>
                    </router-link>
                  </div>
                </div>

              </div>
              <div class="list-item-action">
                <a href="javascript:;" :class="[category.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']" @click.prevent="toggleStatus(category.id)"></a>
                <router-link :to="{name: 'category-edit', params: { id: category.id }}" class="icon-edit icon-mini"></router-link>
                <a href="javascript:;" class="icon-copy icon-mini" @click.prevent="clone(category.id)"></a>
                <a href="javascript:;" class="icon-trash icon-mini" @click.prevent="destroy(category.id)"></a>
              </div>
            </div>
          </div>
          <div v-else>
            <p>Es sind keine Kategorien vorhanden...</p>
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
        categories: [],
        debounce: false,
      }
    },

    created() {
      this.fetch();
    },

    methods: {

      fetch() {
        let uri = '/api/categories/get';
          this.axios.get(uri).then(response => {
          this.categories = response.data.data;
        });
      },

      // Categories
      destroy(id) {
        let uri = `/api/category/destroy/${id}`;
        this.axios.delete(uri).then(response => {
          this.categories = response.data.data;
          this.$notify({type: 'success', text: 'Eintrag gelöscht'});
        });
      },
      
      clone(id) {
        let uri = `/api/category/clone/${id}`;
        this.axios.get(uri).then(response => {
          this.categories = response.data.data;
          this.$notify({type: 'success', text: 'Eintrag kopiert'});
        });        
      },

      toggleStatus(id) {
        let uri = `/api/category/status/${id}`;
        this.axios.get(uri).then(response => {
          // children inherit the status (if its 0)
          // load all records again
          if (response.data == 0) {
            this.fetch();
          }
          else {
            const index = this.categories.findIndex(x => x.id === id);
            this.categories[index].publish = response.data;
          }
          this.$notify({type: 'success', text: 'Status angepasst'});
        });
      },

      // CategoryTypes
      destroyType(id) {
        let uri = `/api/type/destroy/${id}`;
        this.axios.delete(uri).then(response => {
          //this.categoryTypes = response.data.data;
          this.fetch();
          this.$notify({type: 'success', text: 'Eintrag gelöscht'});
        });
      },
      
      cloneType(id) {
        let uri = `/api/type/clone/${id}`;
        this.axios.get(uri).then(response => {
          //this.categoryTypes = response.data.data;
          this.fetch();
          this.$notify({type: 'success', text: 'Eintrag kopiert'});
        });        
      },

      toggleTypeStatus(id) {
        let uri = `/api/type/status/${id}`;
        this.axios.get(uri).then(response => {
          // Types are within categories
          // we need to loop twice
          let tmpCategories = this.categories;
          tmpCategories.forEach(function(category, index) {
            category.types.forEach(function(type, idx){
              if (type.id == id) {
                tmpCategories[index].types[idx].publish = response.data;
              }
            })
          });
          this.categories = tmpCategories;
          this.$notify({type: 'success', text: 'Status angepasst'});
        });
      },      
    }
  }
</script>