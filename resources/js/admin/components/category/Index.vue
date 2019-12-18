<template>
  <div>
    <page-header/>
    <notifications classes="notification"/>
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Kategorien</h1>
          <router-link :to="{ name: 'category-create' }" class="btn-add">
            <span>Hinzufügen</span>
          </router-link>
          <div class="list-items" v-if="categories.length">
            <div
              :class="[category.publish == 0 ? 'is-disabled' : '', 'list-item']"
              v-for="category in categories"
              :key="category.id"
            >
              <div class="list-item-body">
                <h2>{{ category.name.de }}</h2>
                <div class="list-item-cards">
                  <draggable
                    v-model="category.types"
                    @end="updateTypeOrder(category.id)"
                    ghost-class="draggable-ghost"
                    tag="div"
                  >
                    <div
                      :class="[categoryType.publish == 0 ? 'is-disabled' : '', 'list-item-card']"
                      v-for="categoryType in category.types"
                      :key="categoryType.id"
                    >
                      <div>
                        {{categoryType.name_singular.de}}
                        <br>
                        {{categoryType.name_plural.de}}
                      </div>
                      <div class="list-item-card__action">
                        <a
                          href="javascript:;"
                          :class="[categoryType.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']"
                          @click.prevent="toggleTypeStatus(categoryType.id,$event)"
                        ></a>
                        <router-link
                          :to="{name: 'category-type-edit', params: { id: categoryType.id }}"
                          class="icon-edit icon-mini"
                        ></router-link>
                        <a
                          href="javascript:;"
                          class="icon-copy icon-mini"
                          @click.prevent="cloneType(categoryType.id,$event)"
                        ></a>
                        <a
                          href="javascript:;"
                          class="icon-trash icon-mini"
                          @click.prevent="destroyType(categoryType.id,$event)"
                        ></a>
                      </div>
                    </div>
                  </draggable>
                  <router-link :to="{ name: 'category-type-create' }" class="btn-add">
                    <span>Typ hinzufügen</span>
                  </router-link>
                </div>
              </div>
              <div class="list-item-action">
                <a
                  href="javascript:;"
                  :class="[category.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']"
                  @click.prevent="toggleStatus(category.id,$event)"
                ></a>
                <router-link
                  :to="{name: 'category-edit', params: { id: category.id }}"
                  class="icon-edit icon-mini"
                ></router-link>
                <a
                  href="javascript:;"
                  class="icon-copy icon-mini"
                  @click.prevent="clone(category.id,$event)"
                ></a>
                <a
                  href="javascript:;"
                  class="icon-trash icon-mini"
                  @click.prevent="destroy(category.id,$event)"
                ></a>
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
import PageHeader from "@/layout/PageHeader.vue";
import draggable from "vuedraggable";
import Progress from "@/mixins/progress";

export default {
  components: {
    draggable,
    PageHeader: PageHeader
  },

  mixins: [Progress],

  data() {
    return {
      categories: [],
      debounce: false
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      let uri = "/api/categories/get";
      this.axios.get(uri).then(response => {
        this.categories = response.data.data;
      });
    },

    // Categories
    destroy(id,event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/category/destroy/${id}`;
        let el = this.progress(event.target);
        this.axios.delete(uri).then(response => {
          this.categories = response.data.data;
          this.$notify({ type: "success", text: "Eintrag gelöscht" });
          this.progress(el);
        });
      }
    },

    clone(id,event) {
      let uri = `/api/category/clone/${id}`;
      let el = this.progress(event.target);
      this.axios.get(uri).then(response => {
        this.categories = response.data.data;
        this.$notify({ type: "success", text: "Eintrag kopiert" });
        this.progress(el);
      });
    },

    toggleStatus(id,event) {
      let uri = `/api/category/status/${id}`;
      let el = this.progress(event.target);
      this.axios.get(uri).then(response => {
        // children inherit the status (if its 0)
        // load all records again
        if (response.data == 0) {
          this.fetch();
        } else {
          const index = this.categories.findIndex(x => x.id === id);
          this.categories[index].publish = response.data;
        }
        this.$notify({ type: "success", text: "Status angepasst" });
        this.progress(el);
      });
    },

    // Category types
    destroyType(id,event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/type/destroy/${id}`;
        let el = this.progress(event.target);
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.$notify({ type: "success", text: "Eintrag gelöscht" });
          this.progress(el);
        });
      }
    },

    cloneType(id,event) {
      let uri = `/api/type/clone/${id}`;
      let el = this.progress(event.target);
      this.axios.get(uri).then(response => {
        //this.categoryTypes = response.data.data;
        this.fetch();
        this.$notify({ type: "success", text: "Eintrag kopiert" });
        this.progress(el);
      });
    },

    toggleTypeStatus(id,event) {
      let uri = `/api/type/status/${id}`;
      let el = this.progress(event.target);
      this.axios.get(uri).then(response => {
        // Types are within categories
        // we need to loop twice
        let tmpCategories = this.categories;
        tmpCategories.forEach(function(category, index) {
          category.types.forEach(function(type, idx) {
            if (type.id == id) {
              tmpCategories[index].types[idx].publish = response.data;
            }
          });
        });
        this.categories = tmpCategories;
        this.$notify({ type: "success", text: "Status angepasst" });
        this.progress(el);
      });
    },

    updateTypeOrder(categoryId) {
      let types;
      this.categories.forEach(function(category, index) {
        if (categoryId == category.id) {
          types = category.types.map(function(type, index) {
            type.order = index;
            return type;
          });
        }
      });

      if (this.debounce) return;

      this.debounce = setTimeout(
        function(types) {
          this.debounce = false;
          let uri = `/api/type/order`;
          this.axios.post(uri, { types: types }).then(response => {
            this.$router.push({ name: "categories" });
          });
        }.bind(this, types),
        1000
      );

      this.$notify({ type: "success", text: "Reihenfolge angepasst" });
    }
  }
};
</script>