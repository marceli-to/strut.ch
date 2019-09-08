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
              <li>
                <a href="javascript:;" @click="changeTab('media')" :class="tabs.media.active ? 'is-active' : ''">Medien</a>
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
                <textarea @focus="removeError('description', 'de')" v-model="book.description.de" :class="errors.description.de ? 'has-error': ''" rows="5"></textarea>
              </div>
              <div class="form-row">
                <label>Info</label>
                <tinymce-editor api-key="vuaywur9klvlt3excnrd9xki1a5lj25v18b2j0d0nu5tbwro" :init="tinyConfig" v-model="book.info.de"></tinymce-editor>
              </div>
              <div class="form-row">
                <label>
                  Link <a :href="book.url" target="_blank" class="icon-external-link is-sm icon-mini" v-if="book.url"></a>
                </label>
                <input type="text" name="url" v-model="book.url" placeholder="https://test.ch/">
              </div>
            </div>
            <div v-show="tabs.media.active">
              <div class="form-row" v-if="book.media == null">
                <label for="document">Datei hochladen</label>
                <vue-dropzone ref="dropzone" id="dropzone" :options="dropzoneImageConfig" @vdropzone-complete="afterComplete"></vue-dropzone>
                <span class="dz-restrictions">jpg, png | max. 8 MB</span>
              </div>
              <div class="form-row" v-if="book.media">
                <label>Vorhandene Datei</label>
                <div class="dropzone-existing-assets">
                  <div>
                    <figure class="dz-existing-asset is-image"> 
                      <a :href="getMediaUri(book.media)" target="_blank" class="dz-file-preview">
                        <img :src="getMediaSource(book.media)" height="300" width="300">
                      </a>
                      <div class="dz-toolbar">
                        <a
                          :href="getMediaUri(book.media)" target="_blank"
                          class="icon-external-link icon-mini"
                        ></a>
                        <a
                          href="javascript:;"
                          class="icon-trash icon-mini"
                          @click.prevent="deleteMedia(book.media)"
                        ></a>
                      </div>
                    </figure>
                  </div>
                </div>
              </div>
            </div>
            <form-buttons 
              :route="'books'">
            </form-buttons>
          </form>
        </div>
      </main>
    </div>
</template>
<script>
import PageHeader from '@/layout/PageHeader.vue';
import FormButtons from '@/components/ui/buttons/FormButtons.vue';
import vue2Dropzone from 'vue2-dropzone';
import dropzoneImageConfig from '@/config/dropzoneconfig-image.js';
import tinyConfig from '@/config/tinyconfig.js'
import Editor from '@tinymce/tinymce-vue';
import Helpers from '@/mixins/helpers';

export default {

  components: {
    vueDropzone: vue2Dropzone,
    tinymceEditor: Editor,
    FormButtons: FormButtons,
  },

  props: {
    type: String,
  },

  mixins: [Helpers],
  
  data() {
    return {

      // fields to validate
      errors: {
        title: false,
        description: {
          de: false,
          //en: false,
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
        media: {
          active: false,
          error: false
        }
      },

      book: {
        title: null,
        description: {
          de: null,
          en: null,
        },
        info: {
          de: null,
          en: null,
        },
        link: null,
        media: null  
      },

      // dropzone config
      dropzoneImageConfig: dropzoneImageConfig,

      // tinymce config
      tinyConfig: tinyConfig,
    }
  },
  
  created() {
    if (this.$props.type == 'edit') {
      let uri = `/api/book/edit/${this.$route.params.id}`;
      this.axios.get(uri).then((response) => {
        this.book = response.data;
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

    // Add the book
    store() {
      let uri = '/api/book/create';
      this.axios.post(uri, this.book).then((response) => {
        this.$router.push({name: 'books'});
      });
    },

    // Update the book
    update() {
      let uri = `/api/book/update/${this.$route.params.id}`;
      this.axios.post(uri, this.book).then((response) => {
        this.$router.push({name: 'books'});
      });
    },

    // FileUpload Callback
    afterComplete(file) {
      if (file.status == 'error' && file.accepted == false) {
        this.$notify({type: 'error', text: 'Ungültiges Dateiformat.'});
      }
      else {
        let file_response = JSON.parse(file.xhr.response);
        this.book.media = file_response.name;
      }
      this.$refs.dropzone.removeFile(file);
    },
    
    // Build media source string 
    getMediaUri(file) {
      return `/media/${file}/sm`;
    },

    getMediaSource(file) {
      return `/media/thumbnail/${file}`;
    },

    // Delete a single file by its name
    deleteMedia(file) {
      let uri = `/api/book/delete/file/${file}`;
      this.axios.delete(uri).then((response) => {
        this.book.media = null;
      });
    },
  },

  computed: {
    title: function () {
      return this.$props.type == 'edit' ? 'Buch bearbeiten' : 'Buch hinzufügen';
    }
  }
}
</script>