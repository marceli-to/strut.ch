<template>
  <div class="container">
    <notifications classes="notification"/>
    <main class="content" role="main">
      <div>
        <h1>{{title}}</h1>
        <nav class="tabs">
          <ul>
            <li>
              <a
                href="javascript:;"
                @click="changeTab('data')"
                :class="[tabs.data.active ? 'is-active' : '', tabs.data.error ? 'has-error' : '']"
              >Daten</a>
            </li>
            <!-- <li>
                  <a href="javascript:;" @click="changeTab('translation')" :class="[tabs.translation.active ? 'is-active' : '', tabs.translation.error ? 'has-error' : '']">Übersetzung</a>
            </li>-->
          </ul>
        </nav>
        <form @submit.prevent="submit">
          <div v-show="tabs.data.active">
            <div class="form-row" :class="errors.name_singular.de ? 'has-error': ''">
              <label>Name (Einzahl) *</label>
              <input
                type="text"
                @focus="removeError('name_singular', 'de')"
                name="name_singular"
                v-model="categoryType.name_singular.de"
              >
            </div>
            <div class="form-row" :class="errors.name_plural.de ? 'has-error': ''">
              <label>Name (Mehrzahl) *</label>
              <input
                type="text"
                @focus="removeError('name_plural', 'de')"
                name="name_plural"
                v-model="categoryType.name_plural.de"
              >
            </div>
            <div class="form-row" :class="errors.category_id ? 'has-error': ''">
              <label>Kategorie *</label>
              <div class="select-wrapper">
                <select
                  class="is-lg"
                  v-model="categoryType.category_id"
                  name="category_id"
                  @focus="removeError('category_id')"
                >
                  <option
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                  >{{ category.name.de }}</option>
                </select>
              </div>
            </div>
          </div>
          <form-buttons :route="'categories'"></form-buttons>
        </form>
      </div>
    </main>
  </div>
</template>
<script>
import PageHeader from "@/layout/PageHeader.vue";
import FormButtons from "@/components/ui/buttons/FormButtons.vue";
import Helpers from "@/mixins/helpers";

export default {
  components: {
    FormButtons: FormButtons
  },

  props: {
    type: String
  },

  mixins: [Helpers],

  data() {
    return {
      // fields to validate
      errors: {
        name_singular: {
          de: false
          //en: false
        },
        name_plural: {
          de: false
          //en: false
        },
        category_id: false
      },

      // tabs
      tabs: {
        data: {
          active: true,
          error: false
        },
        translation: {
          active: false,
          error: false
        }
      },

      categoryType: {
        name_singular: {
          de: null,
          en: null
        },
        name_plural: {
          de: null,
          en: null
        },
        category_id: null
      },
      categories: null
    };
  },

  created() {
    if (this.$props.type == "edit") {
      let uri = `/api/type/edit/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.categoryType = response.data;
      });
    }

    let uri = "/api/categories/get";
    this.axios.get(uri).then(response => {
      this.categories = response.data.data;
    });
  },

  methods: {
    // Validation methods
    validate() {
      if (
        this.categoryType.name_singular.de &&
        this.categoryType.name_plural.de &&
        this.categoryType.category_id
      ) {
        return true;
      }

      if (!this.categoryType.name_singular.de) {
        this.errors.name_singular.de = true;
        this.tabs.data.error = true;
      }

      if (!this.categoryType.name_plural.de) {
        this.errors.name_plural.de = true;
        this.tabs.data.error = true;
      }

      if (!this.categoryType.category_id) {
        this.errors.category_id = true;
        this.tabs.data.error = true;
      }
      
      return false;
    },

    // Submit method
    submit() {
      if (!this.validate()) {
        this.validationError();
        return;
      }

      if (this.$props.type == "edit") {
        this.update();
      }

      if (this.$props.type == "create") {
        this.store();
      }
    },

    // Add the type
    store() {
      let uri = "/api/type/create";
      this.axios.post(uri, this.categoryType).then(response => {
        this.$router.push({ name: "categories" });
      });
    },

    // Update the type
    update() {
      let uri = `/api/type/update/${this.$route.params.id}`;
      this.axios.post(uri, this.categoryType).then(response => {
        this.$router.push({ name: "categories" });
      });
    }
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" ? "Typ bearbeiten" : "Typ hinzufügen";
    }
  }
};
</script>