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
                <a href="javascript:;" @click="changeTab('image')" :class="tabs.image.active ? 'is-active' : ''">Bild</a>
              </li>
            </ul>
          </nav>
          <form @submit.prevent="submit">
            <div v-show="tabs.data.active">
              <div class="grid">
                <div class="span form-row" :class="errors.firstname ? 'has-error': ''">
                  <label>Vorname *</label>
                  <input type="text" @focus="removeError('firstname')" name="firstname" v-model="team.firstname">
                </div>
                <div class="span form-row" :class="errors.name ? 'has-error': ''">
                  <label>Name *</label>
                  <input type="text" @focus="removeError('name')" name="name" v-model="team.name">
                </div>
                <div class="span form-row">
                  <label>Funktion</label>
                  <input type="text" name="role" v-model="team.role.de" placeholder="z.B. Architekt ETH">
                </div>
                <div class="span form-row">
                  <label>Position</label>
                  <input type="text" name="position" v-model="team.position.de" placeholder="z.B. Partner">
                </div>
                <div class="span form-row">
                  <label>Telefon</label>
                  <input type="text" @focus="removeError('phone')" name="phone" v-model="team.phone" placeholder="Format: +41 52 2xx xx xx">
                </div>
                <div class="span form-row" :class="errors.email ? 'has-error': ''">
                  <label>E-Mail *</label>
                  <input type="text" @focus="removeError('email')" name="email" v-model="team.email">
                </div>
              </div>
              <div class="form-row">
                <label>Lebenslauf</label>
                <tinymce-editor api-key="vuaywur9klvlt3excnrd9xki1a5lj25v18b2j0d0nu5tbwro" :init="tinyConfig" v-model="team.cv.de"></tinymce-editor>
              </div>
            </div>
            <div v-show="tabs.image.active">
              <div class="form-row">
                <label for="document">Datei hochladen <span class="fs-xs">(JPG | PNG, max. 8 MB)</span></label>
                <vue-dropzone ref="dropzone" id="dropzone" :options="dropzoneOptions" @vdropzone-complete="afterComplete"></vue-dropzone>
              </div>
              <div class="form-row" v-if="team.media">
                <label>Vorhandene Datei</label>
                <div class="dropzone-existing-images">
                    <figure class="dz-existing-image">
                      <a :href="getMediaUri(team.media)" target="_blank" class="dz-file-preview">
                        <img src="/assets/admin/img/icon-file.png" height="100" width="100">
                      </a>
                      <a href="javascript:;" class="dz-remove" @click.prevent="deleteMedia(team.media)">Delete</a>
                    </figure>
                </div>
              </div>
            </div>
            <div class="form-row form-buttons">
              <button type="submit">Speichern</button>
              <router-link :to="{name: 'team'}">Zurück</router-link>
            </div>
          </form>
        </div>
      </main>
    </div>
</template>
<script>
import PageHeader from '@/layout/PageHeader.vue';
import vue2Dropzone from 'vue2-dropzone';
import tinyConfig from '@/config/tinyconfig-lg.js'
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
        name: false,
        firstname: false,
        email: false,
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
        image: {
          active: false,
          error: false
        }
      },

      team: {
        firstname: null,
        name: null,
        role: {
          de: null,
          en: null,
        },
        position: {
          de: null,
          en: null,
        },
        phone: null,
        email: null,
        cv: {
          de: null,
          en: null,
        },
        media: null  
      },

      // dropzone options
      dropzoneOptions: {
        url: "/api/media/upload",
        method: 'post',
        maxFilesize: 8,
        maxFiles: 1,
        createImageThumbnails: false,
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
      },

      // tinymce config
      tinyConfig: tinyConfig,
    }
  },
  
  created() {
    if (this.$props.type == 'edit') {
      let uri = `/api/team/edit/${this.$route.params.id}`;
      this.axios.get(uri).then((response) => {
        this.team = response.data;
      });
    }
  },
  
  methods: {

    // Validation methods
    validate() {

      if (this.team.name && 
        this.team.firstname &&
        this.team.email) {
        return true;
      }

      if (!this.team.name) {
        this.errors.name = true;
        this.tabs.data.error = true;
      }

      if (!this.team.firstname) {
        this.errors.firstname = true;
        this.tabs.data.error = true;
      }

      if (!this.team.email) {
        this.errors.email = true;
        this.tabs.data.error = true;
      }
      return false;
    },

    // Submit method
    submit() {
      if (this.$props.type == 'edit') {
        this.update();
      }
      if (this.$props.type == 'create') {
        this.store();
      }
    },

    // Add the team
    store() {
      if (!this.validate()) {
        this.onFail();
        return;
      }

      let uri = '/api/team/create';
      this.axios.post(uri, this.team).then((response) => {
        this.$router.push({name: 'team'});
      });
    },

    // Update the team
    update() {
      if (this.validate()) {
        let uri = `/api/team/update/${this.$route.params.id}`;
        this.axios.post(uri, this.team).then((response) => {
          this.$router.push({name: 'team'});
        });
      }
    },

    onFail() {
      this.$notify({type: 'error', text: 'Bitte markierte Felder prüfen!'});
      window.scrollTo({top: 0, behavior: 'smooth'});
    },

    // FileUpload Callback
    afterComplete(file) {
        let file_response = JSON.parse(file.xhr.response);
        this.team.media = file_response.name;
        this.$refs.dropzone.removeFile(file);
    },
    
    // Build media source string 
    getMediaUri(file) {
      return `/storage/media/downloads/${file}`;
    },

    // Delete a single file by its name
    deleteMedia(file) {
      let uri = `/api/team/delete/file/${file}`;
      this.axios.delete(uri).then((response) => {
        // @todo: delete
        // this.post.media.splice(this.post.media.indexOf(file), 1);
        this.team.media = null;
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
      return this.$props.type == 'edit' ? 'Teammitglied bearbeiten' : 'Teammitglied hinzufügen';
    }
  }
}
</script>