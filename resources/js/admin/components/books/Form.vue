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
            <li>
              <a
                href="javascript:;"
                @click="changeTab('media')"
                :class="tabs.media.active ? 'is-active' : ''"
              >Medien</a>
            </li>
          </ul>
        </nav>
        <form @submit.prevent="submit">
          <div v-show="tabs.data.active">
            <div class="form-row" :class="errors.title ? 'has-error': ''">
              <label>Titel *</label>
              <input type="text" @focus="removeError('title')" name="title" v-model="book.title">
            </div>
            <div class="form-row" :class="errors.description.de ? 'has-error': ''">
              <label>Beschreibung *</label>
              <textarea
                @focus="removeError('description', 'de')"
                v-model="book.description.de"
                :class="errors.description.de ? 'has-error': ''"
                rows="5"
              ></textarea>
            </div>
            <div class="form-row">
              <label>Info</label>
              <tinymce-editor
                api-key="vuaywur9klvlt3excnrd9xki1a5lj25v18b2j0d0nu5tbwro"
                :init="tinyConfig"
                v-model="book.info.de"
              ></tinymce-editor>
            </div>
            <div class="form-row">
              <label>
                Link / E-Mail
                <a
                  :href="previewLink"
                  target="_blank"
                  class="icon-external-link is-sm icon-mini"
                  v-if="previewLink"
                ></a>
              </label>
              <input 
                type="text" 
                name="url" 
                v-model="book.url" 
                placeholder="https://test.ch/"
                @blur="fixUri()"
              >
            </div>
          </div>
          <div v-show="tabs.media.active">
            <image-upload
              :labelNew="'Bild hochladen'"
              :labelExisting="'Vorhandenes Bild'"
              :labelRestrictions="'jpg, png | max. 8 MB'"
              :maxFiles="1"
              :maxFilesize="8"
              :asset="book.media"
              :assetType="'image'"
              :acceptedFiles="'.png,.jpg'"
              :uploadUrl="'/api/media/upload'"
            ></image-upload>
          </div>
          <form-buttons :route="'books'"></form-buttons>
        </form>
      </div>
    </main>
  </div>
</template>
<script>
import PageHeader from "@/layout/PageHeader.vue";
import FormButtons from "@/components/ui/buttons/FormButtons.vue";
import ImageUpload from "@/components/ui/ImageUpload.vue";
import tinyConfig from "@/config/tinyconfig.js";
import Editor from "@tinymce/tinymce-vue";
import Helpers from "@/mixins/helpers";

export default {
  components: {
    ImageUpload: ImageUpload,
    tinymceEditor: Editor,
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
        title: false,
        description: {
          de: false
          //en: false,
        }
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
        media: {
          active: false,
          error: false
        }
      },

      book: {
        title: null,
        description: {
          de: null,
          en: null
        },
        info: {
          de: null,
          en: null
        },
        url: null,
        media: null
      },

      previewLink: null,

      // tinymce config
      tinyConfig: tinyConfig
    };
  },

  created() {
    if (this.$props.type == "edit") {
      let uri = `/api/book/edit/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.book = response.data;
        if (this.book.url) {
          this.fixUri(this.book.url);
        }
      });
    }
  },

  methods: {

    // Validation methods
    validate() {
      if (this.book.title && this.book.description.de) {
        return true;
      }

      if (!this.book.title) {
        this.errors.title = true;
        this.tabs.data.error = true;
      }

      if (!this.book.description.de) {
        this.errors.description.de = true;
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

    // Add the book
    store() {
      let uri = "/api/book/create";
      this.axios.post(uri, this.book).then(response => {
        this.$router.push({ name: "books" });
      });
    },

    // Update the book
    update() {
      let uri = `/api/book/update/${this.$route.params.id}`;
      this.axios.post(uri, this.book).then(response => {
        this.$router.push({ name: "books" });
      });
    },

    // Image Upload Callback
    afterImageUpload(file) {
      if (file.status == "error" && file.accepted == false) {
        this.$notify({ type: "error", text: "Ungültiges Dateiformat." });
      } else {
        let file_response = JSON.parse(file.xhr.response);
        this.book.media = file_response.name;
      }
    },

    // Delete a single file by name
    deleteImageUpload(file) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/book/delete/file/${file}`;
        this.axios.delete(uri).then(response => {
          this.book.media = null;
        });
      }
    },

    fixUri() {
      // check for '@'
      let index = 0, 
          pattern = /^((http|https|ftp):\/\/)/;
      
      if (this.book.url.length < 1) {
        this.book.url = null;
        this.previewLink = null;
        return;
      }

      if ((index = this.book.url.indexOf('@')) !== -1) {
        this.previewLink = 'mailto:' + this.book.url;
      }
      else {
        if (!pattern.test(this.book.url)) {
          this.previewLink = "http://" + this.book.url;
          this.book.url = "http://" + this.book.url;
        }
        else {
          this.previewLink = this.book.url;
          this.book.url = this.book.url;
        }
      }
    }
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" ? "Buch bearbeiten" : "Buch hinzufügen";
    }
  }
};
</script>