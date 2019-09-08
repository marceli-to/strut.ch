<template>
    <div class="container">
      <notifications classes="notification" />
      <main class="content" role="main">
        <div>
          <h1>{{title}}</h1>
          <nav class="tabs">
            <ul>
              <li>
                <a href="javascript:;" @click="changeTab('data')" :class="[tabs.data.active ? 'is-active' : '', tabs.data.error ? 'has-error' : '']">Daten</a>
              </li>
              <!-- <li>
                  <a href="javascript:;" @click="changeTab('translation')" :class="[tabs.translation.active ? 'is-active' : '', tabs.translation.error ? 'has-error' : '']">Übersetzung</a>
              </li> -->
            </ul>
          </nav>
          <form @submit.prevent="submit">
            <div v-show="tabs.data.active">
              <div class="form-row" :class="errors.name.de ? 'has-error': ''">
                <label>Name *</label>
                <input type="text" @focus="removeError('name', 'de')" name="name" v-model="category.name.de">
              </div>
            </div>
            <form-buttons 
              :route="'categories'">
            </form-buttons>
          </form>
        </div>
      </main>
    </div>
</template>
<script>
import PageHeader from '@/layout/PageHeader.vue';
import FormButtons from '@/components/buttons/FormButtons.vue';

export default {

  components: {
    FormButtons: FormButtons
  },

  props: {
    type: String,
  },
  
  data() {
    return {

      // fields to validate
      errors: {
        name: {
          de: false,
          //en: false
        },
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
        },
      },

      category: {
        name: {
          de: null,
          en: null,
        },
      },
    }
  },
  
  created() {
    if (this.$props.type == 'edit') {
      let uri = `/api/category/edit/${this.$route.params.id}`;
      this.axios.get(uri).then((response) => {
        this.category = response.data;
      });
    }
  },
  
  methods: {

    // Validation methods
    validate() {

      if (this.category.name.de) {
        return true;
      }

      if (!this.category.name.de) {
        this.errors.name.de = true;
        this.tabs.data.error = true;
      }
      return false;
    },

    validationError() {
      this.$notify({type: 'error', text: 'Bitte markierte Felder prüfen!'});
      window.scrollTo({top: 0, behavior: 'smooth'});
    },

    // Submit method
    submit() {

      if (!this.validate()) {
        this.validationError();
        return;
      }

      if (this.$props.type == 'edit') {
        this.update();
      }

      if (this.$props.type == 'create') {
        this.store();
      }
    },

    // Add the category
    store() {
      let uri = '/api/category/create';
      this.axios.post(uri, this.category).then((response) => {
        this.$router.push({name: 'categories'});
      });
    },

    // Update the category
    update() {
      let uri = `/api/category/update/${this.$route.params.id}`;
      this.axios.post(uri, this.category).then((response) => {
        this.$router.push({name: 'categories'});
      });
    },

    changeTab(tab) {
      // set all tabs inactive and remove errors if any
      for (let prop in this.tabs) {
        this.tabs[prop].active = false;
        this.tabs[prop].error = false;
      };

      // set active tab
      this.tabs[tab].active = true;
    },

    removeError(field, language) {
      if (language) {
        this.errors[field][language] = false;
      }
      else {
        this.errors[field] = false;
      }
    }
  },

  computed: {
    title: function () {
      return this.$props.type == 'edit' ? 'Kategorie bearbeiten' : 'Kategorie hinzufügen';
    }
  }
}
</script>