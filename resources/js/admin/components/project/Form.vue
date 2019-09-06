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
                <a href="javascript:;" @click="changeTab('images')" :class="tabs.images.active ? 'is-active' : ''">Bilder</a>
              </li>
              <li>
                <a href="javascript:;" @click="changeTab('files')" :class="tabs.files.active ? 'is-active' : ''">Dateien</a>
              </li>
            </ul>
          </nav>
          <form @submit.prevent="submit">
            <div class="span" v-show="tabs.data.active">
              <div class="form-row" :class="errors.name.de ? 'has-error': ''">
                <label>Name *</label>
                <input type="text" @focus="removeError('name', 'de')" name="name" v-model="project.name.de">
              </div>
              <div class="form-row" :class="errors.location.de ? 'has-error': ''">
                <label>Ort *</label>
                <input type="text" @focus="removeError('location', 'de')" name="location" v-model="project.location.de">
              </div>
              <div class="form-row" :class="errors.year ? 'has-error': ''">
                <label>Jahr *</label>
                <div class="select-wrapper">
                  <select class="is-md" v-model="project.year" name="year" @focus="removeError('year')">
                    <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                  <label>Beschreibung</label>
                  <tinymce-editor api-key="vuaywur9klvlt3excnrd9xki1a5lj25v18b2j0d0nu5tbwro" :init="tinyConfig" v-model="project.description.de"></tinymce-editor>
              </div>
              <div class="form-row">
                  <label>Info</label>
                  <tinymce-editor api-key="vuaywur9klvlt3excnrd9xki1a5lj25v18b2j0d0nu5tbwro" :init="tinyConfig" v-model="project.info.de"></tinymce-editor>
              </div>
            </div>
            <div class="span" v-show="tabs.images.active">
              <div class="form-row" v-if="project.images == null">
                <label for="document">Bild hochladen <span class="fs-xs">(PDF, max. 8 MB)</span></label>
                <vue-dropzone ref="dropzoneImages" id="dropzoneImages" :options="dropzoneImageConfig" @vdropzone-complete="afterImageComplete"></vue-dropzone>
              </div>
              <div class="form-row" v-if="project.images">
                <label>Vorhandene Bilder</label>
                <div class="dropzone-existing-images">
                    <figure class="dz-existing-image">
                      <a :href="getImageUri(project.images)" target="_blank" class="dz-file-preview">
                        <img src="/assets/admin/img/icon-file.png" height="100" width="100">
                      </a>
                      <a href="javascript:;" class="dz-remove" @click.prevent="deleteImage(project.images)">Löschen</a>
                    </figure>
                </div>
              </div>
            </div>
            <div class="span" v-show="tabs.files.active">
              <div class="form-row" v-if="project.files == null">
                <label for="document">Datei hochladen <span class="fs-xs">(PDF, max. 8 MB)</span></label>
                <vue-dropzone ref="dropzoneFiles" id="dropzoneFiles" :options="dropzoneDocumentConfig" @vdropzone-complete="afterFileComplete"></vue-dropzone>
              </div>
              <div class="form-row" v-if="project.files">
                <label>Vorhandene Datei</label>
                <div class="dropzone-existing-images">
                    <figure class="dz-existing-image">
                      <a :href="getFileUri(project.images)" target="_blank" class="dz-file-preview">
                        <img src="/assets/admin/img/icon-file.png" height="100" width="100">
                      </a>
                      <a href="javascript:;" class="dz-remove" @click.prevent="deleteFile(project.images)">Löschen</a>
                    </figure>
                </div>
              </div>
            </div>
            <div class="form-row form-buttons">
              <button type="submit">Speichern</button>
              <router-link :to="{name: 'projects'}">Zurück</router-link>
            </div>
          </form>
        </div>
      </main>
    </div>
</template>
<script>
import PageHeader from '@/layout/PageHeader.vue';
import vue2Dropzone from 'vue2-dropzone';
import dropzoneDocumentConfig from '@/config/dropzone-document.js';
import dropzoneImageConfig from '@/config/dropzone-image.js';
import tinyConfig from '@/config/tinyconfig.js'
import Editor from '@tinymce/tinymce-vue';
import years from '@/config/years.js';

export default {

  components: {
    vueDropzone: vue2Dropzone,
    tinymceEditor: Editor
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
          //en: false,
        },
        location: {
          de: false,
          //en: false,
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
        images: {
          active: false,
          error: false
        },
        files: {
          active: false,
          error: false
        }
      },

      project: {
        name: {
          de: null,
          en: null,
        },
        location: {
          de: null,
          en: null,
        },
        description: {
          de: null,
          en: null,
        },
        info: {
          de: null,
          en: null,
        },
        year: null,
        images: null,
        files: null
      },

      // years
      years: years,

      // dropzone config
      dropzoneDocumentConfig: dropzoneDocumentConfig,
      dropzoneImageConfig: dropzoneImageConfig,

      // tinymce config
      tinyConfig: tinyConfig,
    }
  },

  created() {

    // Get the post for update view
    if (this.$props.type == 'edit') {
      let uri = `/api/project/edit/${this.$route.params.id}`;
      this.axios.get(uri).then((response) => {
        this.job = response.data;
      });
    }
  },
  
  methods: {

    // Validation methods
    validate() {

      if (this.project.name.de && this.project.location.de && this.project.year) {
        return true;
      }

      if (!this.project.name.de) {
        this.errors.name.de = true;
        this.tabs.data.error = true;
      }

      if (!this.project.location.de) {
        this.errors.location.de = true;
        this.tabs.data.error = true;
      }
      
      if (!this.project.year) {
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

    // Add project
    store() {
      let uri = '/api/project/create';
      this.axios.post(uri, this.project).then((response) => {
        this.$router.push({name: 'projects'});
      });
    },

    // Update project
    update() {
      let uri = `/api/project/update/${this.$route.params.id}`;
      this.axios.post(uri, this.project).then((response) => {
        this.$router.push({name: 'projects'});
      });
    },

    // File Upload Callback
    afterFileComplete(file) {
      if (file.status == 'error' && file.accepted == false) {
        this.$notify({type: 'error', text: 'Ungültiges Dateiformat.'});
      }
      else {
        let file_response = JSON.parse(file.xhr.response);
        this.project.files.push(file_response.name);
      }
      this.$refs.dropzoneFiles.removeFile(file);
    },

    // Image Upload Callback
    afterImageComplete(file) {
      if (file.status == 'error' && file.accepted == false) {
        this.$notify({type: 'error', text: 'Ungültiges Dateiformat.'});
      }
      else {
        let file_response = JSON.parse(file.xhr.response);
        this.project.images.push(file_response.name);
      }
      this.$refs.dropzoneFiles.removeFile(file);
    },

    // Build media source string 
    getFileUri(file) {
      return `/storage/media/downloads/${file}`;
    },

    getImageUri(file) { },

    // Delete a single file by its name
    deleteFile(file) {
      let uri = `/api/project/delete/file/${file}`;
      this.axios.delete(uri).then((response) => {
        this.project.files.splice(this.project.files.indexOf(file), 1);
        this.project.files = null;
      });
    },

    deleteImage(image) {
      
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
      return this.$props.type == 'edit' ? 'Projekt bearbeiten' : 'Projekt hinzufügen';
    }
  }
}
</script>