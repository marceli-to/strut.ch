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
              <div class="form-row" :class="errors.title.de ? 'has-error': ''">
                <label>Titel *</label>
                <input type="text" @focus="removeError('title', 'de')" name="title" v-model="press.title.de">
              </div>
              <div class="form-row" :class="errors.description.de ? 'has-error': ''">
                <label>Beschreibung</label>
                <textarea @focus="removeError('description', 'de')" v-model="press.description.de" :class="errors.description.de ? 'has-error': ''" rows="5"></textarea>
              </div>
              <div class="form-row" :class="errors.year ? 'has-error': ''">
                <label>Jahr *</label>
                <div class="select-wrapper">
                  <select class="is-md" v-model="press.year" name="year" @focus="removeError('year')">
                    <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <label>
                  Link <a :href="press.url" target="_blank" class="icon-external-link is-sm icon-mini" v-if="press.url"></a>
                </label>
                <input type="text" name="url" v-model="press.url" placeholder="https://test.ch/">
              </div>
            </div>
            <div v-show="tabs.media.active">
              <div class="form-row" v-if="press.media == null">
                <label for="document">Bild hochladen</label>
                <vue-dropzone ref="dropzone" id="dropzone" :options="dropzoneImageConfig" @vdropzone-complete="afterComplete"></vue-dropzone>
                <span class="dz-restrictions">jpg, png | max. 8 MB</span>
              </div>
              <div class="form-row" v-if="press.media">
                <label>Vorhandenes Bild</label>
                <div class="dropzone-existing-assets">
                  <div>
                    <figure class="dz-existing-asset is-image"> 
                      <a :href="getMediaUri(press.media)" target="_blank" class="dz-file-preview">
                        <img :src="getMediaSource(press.media)" height="100" width="100">
                      </a>
                      <div class="dz-toolbar">
                        <a
                          :href="getMediaUri(press.media)" target="_blank"
                          class="icon-external-link icon-mini"
                        ></a>
                        <a
                          href="javascript:;"
                          class="icon-trash icon-mini"
                          @click.prevent="deleteMedia(press.media)"
                        ></a>
                      </div>
                    </figure>
                  </div>
                </div>
              </div>
            </div>
            <form-buttons 
              :route="'press'">
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
import tinyConfig from '@/config/tinyconfig.js';
import years from '@/config/years.js';
import Editor from '@tinymce/tinymce-vue';
import Helpers from '@/mixins/helpers';

export default {

  components: {
    vueDropzone: vue2Dropzone,
    tinymceEditor: Editor,
    FormButtons: FormButtons
  },

  props: {
    type: String,
  },

  mixins: [Helpers],
  
  data() {
    return {

      // fields to validate
      errors: {
        title: {
          de: false,
          //en: false
        },
        description: {
          de: false,
          en: false,
        },
        year: false,
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

      press: {
        title: {
          de: null,
          en: null,
        },
        description: {
          de: null,
          en: null,
        },
        year: null,
        link: null,
        media: null  
      },

      // years
      years: years,

      // dropzone config
      dropzoneImageConfig: dropzoneImageConfig,

      // tinymce config
      tinyConfig: tinyConfig,
    }
  },
  
  created() {
    if (this.$props.type == 'edit') {
      let uri = `/api/press/edit/${this.$route.params.id}`;
      this.axios.get(uri).then((response) => {
        this.press = response.data;
      });
    }
  },
  
  methods: {

    // Validation methods
    validate() {

      if (this.press.title.de && this.press.year) {
        return true;
      }

      if (!this.press.title.de) {
        this.errors.title.de = true;
        this.tabs.data.error = true;
      }

      if (!this.press.year) {
        this.errors.year = true;
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

    // Add the press
    store() {
      let uri = '/api/press/create';
      this.axios.post(uri, this.press).then((response) => {
        this.$router.push({name: 'press'});
      });
    },

    // Update the press
    update() {
      let uri = `/api/press/update/${this.$route.params.id}`;
      this.axios.post(uri, this.press).then((response) => {
        this.$router.push({name: 'press'});
      });
    },

    // FileUpload Callback
    afterComplete(file) {
      if (file.status == 'error' && file.accepted == false) {
        this.$notify({type: 'error', text: 'Ungültiges Dateiformat.'});
      }
      else {
        let file_response = JSON.parse(file.xhr.response);
        this.press.media = file_response.name;
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
      if(confirm('Bitte löschen bestätigen!')) {
        let uri = `/api/press/delete/file/${file}`;
        this.axios.delete(uri).then((response) => {
          this.press.media = null;
        });
      }
    },
  },

  computed: {
    title: function () {
      return this.$props.type == 'edit' ? 'Presse-Artikel bearbeiten' : 'Presse-Artikel hinzufügen';
    }
  }
}
</script>