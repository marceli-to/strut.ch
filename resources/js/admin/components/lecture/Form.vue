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
                <input type="text" @focus="removeError('title', 'de')" name="title" v-model="lecture.title.de">
              </div>
              <div class="form-row" :class="errors.description.de ? 'has-error': ''">
                <label>Beschreibung</label>
                <textarea @focus="removeError('description', 'de')" v-model="lecture.description.de" :class="errors.description.de ? 'has-error': ''" rows="5"></textarea>
              </div>
              <div class="form-row" :class="errors.year ? 'has-error': ''">
                <label>Jahr *</label>
                <div class="select-wrapper">
                  <select class="is-md" v-model="lecture.year" name="year" @focus="removeError('year')">
                    <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                  </select>
                </div>
              </div>
            </div>
            <div v-show="tabs.media.active">
              <div class="form-row" v-if="lecture.media == null">
                <label for="document">Datei hochladen <span class="fs-xs">(JPG | PNG, max. 8 MB)</span></label>
                <vue-dropzone ref="dropzone" id="dropzone" :options="dropzoneImageConfig" @vdropzone-complete="afterComplete"></vue-dropzone>
              </div>
              <div class="form-row" v-if="lecture.media">
                <label>Vorhandene Datei</label>
                <div class="dropzone-existing-images">
                    <figure class="dz-existing-image">
                      <a :href="getMediaUri(lecture.media)" target="_blank" class="dz-file-preview">
                        <img :src="getMediaSource(lecture.media)" height="300" width="300">
                      </a>
                      <a href="javascript:;" class="dz-remove" @click.prevent="deleteMedia(lecture.media)">Löschen</a>
                    </figure>
                </div>
              </div>
            </div>
            <div class="form-row form-buttons">
              <button type="submit">Speichern</button>
              <router-link :to="{name: 'lectures'}">Zurück</router-link>
            </div>
          </form>
        </div>
      </main>
    </div>
</template>
<script>
import PageHeader from '@/layout/PageHeader.vue';
import vue2Dropzone from 'vue2-dropzone';
import dropzoneImageConfig from '@/config/dropzone-image.js';
import tinyConfig from '@/config/tinyconfig.js';
import years from '@/config/years.js';
import Editor from '@tinymce/tinymce-vue';

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
        title: {
          de: false,
          //en: false
        },
        description: {
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
        media: {
          active: false,
          error: false
        }
      },

      lecture: {
        title: {
          de: null,
          en: null,
        },
        description: {
          de: null,
          en: null,
        },
        year: null,
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
      let uri = `/api/lecture/edit/${this.$route.params.id}`;
      this.axios.get(uri).then((response) => {
        this.lecture = response.data;
      });
    }
  },
  
  methods: {

    // Validation methods
    validate() {

      if (this.lecture.title.de && this.lecture.year) {
        return true;
      }

      if (!this.lecture.title.de) {
        this.errors.title.de = true;
        this.tabs.data.error = true;
      }

      if (!this.lecture.year) {
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

    // Add the lecture
    store() {
      let uri = '/api/lecture/create';
      this.axios.post(uri, this.lecture).then((response) => {
        this.$router.push({name: 'lectures'});
      });
    },

    // Update the lecture
    update() {
      let uri = `/api/lecture/update/${this.$route.params.id}`;
      this.axios.post(uri, this.lecture).then((response) => {
        this.$router.push({name: 'lectures'});
      });
    },

    // FileUpload Callback
    afterComplete(file) {
      if (file.status == 'error' && file.accepted == false) {
        this.$notify({type: 'error', text: 'Ungültiges Dateiformat.'});
      }
      else {
        let file_response = JSON.parse(file.xhr.response);
        this.lecture.media = file_response.name;
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
      let uri = `/api/lecture/delete/file/${file}`;
      this.axios.delete(uri).then((response) => {
        this.lecture.media = null;
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
      return this.$props.type == 'edit' ? 'Vortrag bearbeiten' : 'Vortrag hinzufügen';
    }
  }
}
</script>