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
                <a href="javascript:;" @click="changeTab('uploads')" :class="tabs.uploads.active ? 'is-active' : ''">Upload</a>
              </li>
            </ul>
          </nav>
          <form @submit.prevent="submit">
            <div class="span" v-show="tabs.data.active">
              <div class="form-row" :class="errors.title.de ? 'has-error': ''">
                <label>Titel *</label>
                <input type="text" @focus="removeError('title', 'de')" name="title" v-model="job.title.de">
              </div>
              <div class="form-row" :class="errors.lead.de ? 'has-error': ''">
                  <label>Lead/Beschreibung *</label>
                  <textarea @focus="removeError('lead', 'de')" v-model="job.lead.de" :class="errors.lead.de ? 'has-error': ''" rows="5"></textarea>
              </div>
              <div class="form-row">
                  <label>Info</label>
                  <tinymce-editor api-key="vuaywur9klvlt3excnrd9xki1a5lj25v18b2j0d0nu5tbwro" :init="tinyConfig" v-model="job.info.de"></tinymce-editor>
              </div>
            </div>
            <div class="span" v-show="tabs.uploads.active">
              <div class="form-row" v-if="job.media == null">
                <label for="document">Datei hochladen <span class="fs-xs">(PDF, max. 8 MB)</span></label>
                <vue-dropzone ref="dropzone" id="dropzone" :options="dropzoneOptions" @vdropzone-complete="afterComplete"></vue-dropzone>
              </div>
              <div class="form-row" v-if="job.media">
                <label>Vorhandene Datei</label>
                <div class="dropzone-existing-images">
                    <figure class="dz-existing-image">
                      <a :href="getMediaUri(job.media)" target="_blank" class="dz-file-preview">
                        <img src="/assets/admin/img/icon-file.png" height="100" width="100">
                      </a>
                      <a href="javascript:;" class="dz-remove" @click.prevent="deleteMedia(job.media)">Delete</a>
                    </figure>
                </div>
              </div>
            </div>
            <div class="form-row form-buttons">
              <button type="submit">Speichern</button>
              <router-link :to="{name: 'jobs'}">Zurück</router-link>
            </div>
          </form>
        </div>
      </main>
    </div>
</template>
<script>
import PageHeader from '@/layout/PageHeader.vue';
import vue2Dropzone from 'vue2-dropzone';
import tinyConfig from '@/config/tinyconfig.js'
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
          //en: false,
        },
        lead: {
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
        uploads: {
          active: false,
          error: false
        }
      },

      job: {
        title: {
          de: null,
          en: null,
        },
        lead: {
          de: null,
          en: null,
        },
        info: {
          de: null,
          en: null,
        },
        media: null  
      },

      // dropzone options
      dropzoneOptions: {
        url: "/api/media/upload/document",
        method: 'post',
        maxFilesize: 8,
        maxFiles: 1,
        createImageThumbnails: false,
        acceptedFiles: '.pdf',
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
      },

      // tinymce config
      tinyConfig: tinyConfig,
    }
  },

  created() {

    // Get the post for update view
    if (this.$props.type == 'edit') {
      let uri = `/api/job/edit/${this.$route.params.id}`;
      this.axios.get(uri).then((response) => {
        this.job = response.data;
      });
    }
  },
  
  methods: {

    // Validation methods
    validate() {

      if (this.job.title.de && this.job.lead.de) {
        return true;
      }

      if (!this.job.title.de) {
        this.errors.title.de = true;
        this.tabs.data.error = true;
      }

      if (!this.job.lead.de) {
        this.errors.lead.de = true;
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

    // Add the job
    store() {
      let uri = '/api/job/create';
      this.axios.post(uri, this.job).then((response) => {
        this.$router.push({name: 'jobs'});
      });
    },

    // Update the job
    update() {
      let uri = `/api/job/update/${this.$route.params.id}`;
      this.axios.post(uri, this.job).then((response) => {
        this.$router.push({name: 'jobs'});
      });
    },

    // FileUpload Callback
    afterComplete(file) {
      if (file.status == 'error' && file.accepted == false) {
        this.$notify({type: 'error', text: 'Ungültiges Dateiformat.'});
      }
      else {
        let file_response = JSON.parse(file.xhr.response);
        this.job.media = file_response.name;
      }
      this.$refs.dropzone.removeFile(file);
    },
    
    // Build media source string 
    getMediaUri(file) {
      return `/storage/media/downloads/${file}`;
    },

    // Delete a single file by its name
    deleteMedia(file) {
      let uri = `/api/job/delete/file/${file}`;
      this.axios.delete(uri).then((response) => {
        // @todo: delete
        // this.post.media.splice(this.post.media.indexOf(file), 1);
        this.job.media = null;
      });
    },

    // Update order
    // @todo: delete
    // updateOrder() {
    //   this.post.media.map(function(post, index) {
    //       post.order = index;
    //       return post;
    //   });
    // },

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
      return this.$props.type == 'edit' ? 'Job bearbeiten' : 'Job hinzufügen';
    }
  }
}
</script>