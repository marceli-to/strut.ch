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
              <div class="grid-team">
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
            <div v-show="tabs.media.active">
              <div class="form-row" v-if="team.media == null">
                <label for="document">Datei hochladen</label>
                <vue-dropzone ref="dropzone" id="dropzone" :options="dropzoneImageConfig" @vdropzone-complete="afterComplete"></vue-dropzone>
                <span class="dz-restrictions">jpg, png | max. 8 MB</span>
              </div>
              <div class="form-row" v-if="team.media">
                <label>Vorhandene Datei</label>
                <div class="dropzone-existing-assets">
                  <div>
                    <figure class="dz-existing-asset is-image"> 
                      <a :href="getMediaUri(team.media)" target="_blank" class="dz-file-preview">
                        <img :src="getMediaSource(team.media)" height="300" width="300">
                      </a>
                      <div class="dz-toolbar">
                        <a
                          :href="getMediaUri(team.media)" target="_blank"
                          class="icon-external-link icon-mini"
                        ></a>
                        <a
                          href="javascript:;"
                          class="icon-trash icon-mini"
                          @click.prevent="deleteMedia(team.media)"
                        ></a>
                      </div>
                    </figure>
                  </div>
                </div>
              </div>
            </div>
            <form-buttons 
              :route="'team'">
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
import tinyConfig from '@/config/tinyconfig-lg.js'
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
        media: {
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

      // dropzone config
      dropzoneImageConfig: dropzoneImageConfig,

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

    // Add the team
    store() {
      let uri = '/api/team/create';
      this.axios.post(uri, this.team).then((response) => {
        this.$router.push({name: 'team'});
      });
    },

    // Update the team
    update() {
      let uri = `/api/team/update/${this.$route.params.id}`;
      this.axios.post(uri, this.team).then((response) => {
        this.$router.push({name: 'team'});
      });
    },

    // FileUpload Callback
    afterComplete(file) {
      if (file.status == 'error' && file.accepted == false) {
        console.log(file);
        this.$notify({type: 'error', text: 'Ungültiges Dateiformat.'});
      }
      else {
        let file_response = JSON.parse(file.xhr.response);
        this.team.media = file_response.name;
      }
      this.$refs.dropzone.removeFile(file);
    },
    
    // Build media source string 
    getMediaUri(file) {
      return `/media/${file}/sm`;
    },

    getMediaSource(file) {
      return `/media/${file}/sm`;
    },

    // Delete a single file by its name
    deleteMedia(file) {
      let uri = `/api/team/delete/file/${file}`;
      this.axios.delete(uri).then((response) => {
        this.team.media = null;
      });
    },
  },

  computed: {
    title: function () {
      return this.$props.type == 'edit' ? 'Teammitglied bearbeiten' : 'Teammitglied hinzufügen';
    }
  }
}
</script>