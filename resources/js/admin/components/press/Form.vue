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
              >Bild</a>
            </li>
            <li>
              <a
                href="javascript:;"
                @click="changeTab('file')"
                :class="tabs.file.active ? 'is-active' : ''"
              >Datei</a>
            </li>
          </ul>
        </nav>
        <form @submit.prevent="submit">
          <div v-show="tabs.data.active">
            <div class="form-row" :class="errors.title.de ? 'has-error': ''">
              <label>Titel *</label>
              <input
                type="text"
                @focus="removeError('title', 'de')"
                name="title"
                v-model="press.title.de"
              >
            </div>
            <div class="form-row" :class="errors.description.de ? 'has-error': ''">
              <label>Beschreibung</label>
              <textarea
                @focus="removeError('description', 'de')"
                v-model="press.description.de"
                :class="errors.description.de ? 'has-error': ''"
                rows="5"
              ></textarea>
            </div>
            <div class="grid-press">
              <div class="span form-row" :class="errors.year ? 'has-error': ''">
                <label>Jahr *</label>
                <div class="select-wrapper is-wide">
                  <select v-model="press.year" name="year" @focus="removeError('year')">
                    <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                  </select>
                </div>
              </div>
              <div class="span form-row" :class="errors.year ? 'has-error': ''">
                <label>Projekt</label>
                <div class="select-wrapper is-wide">
                  <select v-model="press.project_id" name="project_id">
                    <option
                      v-for="project in projects"
                      :key="project.id"
                      :value="project.id"
                    >{{ project.name }}</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-row">
              <label>
                Link
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
                v-model="press.url" 
                placeholder="https://test.ch/"
                @blur="fixUri()">
            </div>
          </div>
          <div v-show="tabs.media.active">
            <image-upload
              :labelNew="'Bild hochladen'"
              :labelExisting="'Vorhandenes Bild'"
              :labelRestrictions="'jpg, png | max. 8 MB'"
              :maxFiles="1"
              :maxFilesize="8"
              :asset="press.media"
              :assetType="'image'"
              :acceptedFiles="'.png,.jpg'"
              :uploadUrl="'/api/media/upload'"
            ></image-upload>
          </div>
          <div v-show="tabs.file.active">
            <file-upload
              :labelNew="'Datei hochladen'"
              :labelExisting="'Vorhandene Datei'"
              :labelRestrictions="'pdf | max. 8 MB'"
              :maxFiles="1"
              :maxFilesize="8"
              :asset="press.file"
              :assetType="'file'"
              :acceptedFiles="'.pdf'"
              :uploadUrl="'/api/media/upload/document'"
            ></file-upload>
          </div>
          <form-buttons :route="'press'"></form-buttons>
        </form>
      </div>
    </main>
  </div>
</template>
<script>
import PageHeader from "@/layout/PageHeader.vue";
import FormButtons from "@/components/ui/buttons/FormButtons.vue";
import ImageUpload from "@/components/ui/ImageUpload.vue";
import FileUpload from "@/components/ui/FileUpload.vue";
import tinyConfig from "@/config/tinyconfig.js";
import years from "@/config/years.js";
import Editor from "@tinymce/tinymce-vue";
import Helpers from "@/mixins/helpers";
import Progress from "@/mixins/progress";

export default {
  components: {
    tinymceEditor: Editor,
    FormButtons: FormButtons,
    ImageUpload: ImageUpload,
    FileUpload: FileUpload
  },

  props: {
    type: String
  },

  mixins: [Helpers, Progress],

  data() {
    return {
      // fields to validate
      errors: {
        title: {
          de: false
          //en: false
        },
        description: {
          de: false,
          en: false
        },
        year: false
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
        },
        file: {
          active: false,
          error: false
        }
      },

      press: {
        title: {
          de: null,
          en: null
        },
        description: {
          de: null,
          en: null
        },
        year: null,
        url: null,
        media: null,
        file: null,
        project_id: null
      },

      // years
      years: years,

      // projects
      projects: [],

      previewLink: null,

      // tinymce config
      tinyConfig: tinyConfig
    };
  },

  created() {
    if (this.$props.type == "edit") {
      let uri = `/api/press/edit/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.press = response.data;
        if (this.press.url) {
          this.fixUri(this.press.url);
        }
      });
    }

    this.fetchProjects();
  },

  methods: {
    // Get all projects
    fetchProjects() {
      let uri = "/api/projects/fetch/1/asc";
      this.axios.get(uri).then(response => {
        let projects = response.data.data;
        projects.forEach(element => {
          let project = {
            id: element.id,
            name:
              element.name.de +
              ", " +
              element.location.de +
              " (" +
              element.year +
              ")"
          };
          this.projects.push(project);
        });
      });
    },

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

    // Add the press
    store() {
      let uri = "/api/press/create";
      this.axios.post(uri, this.press).then(response => {
        this.$router.push({ name: "press" });
      });
    },

    // Update the press
    update() {
      let uri = `/api/press/update/${this.$route.params.id}`;
      this.axios.post(uri, this.press).then(response => {
        this.$router.push({ name: "press" });
      });
    },

    // Image Upload Callback
    afterImageUpload(file) {
      if (file.status == "error" && file.accepted == false) {
        this.$notify({ type: "error", text: "Ungültiges Dateiformat." });
      } else {
        let file_response = JSON.parse(file.xhr.response);
        this.press.media = file_response.name;
      }
    },

    // Delete a single image by name
    deleteImageUpload(file,event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/press/delete/file/${file}`;
        let el = this.progress(event.target);
        this.axios.delete(uri).then(response => {
          this.press.media = null;
          this.progress(el);
        });
      }
    },

    // File Upload Callback
    afterFileUpload(file) {
      if (file.status == "error" && file.accepted == false) {
        this.$notify({ type: "error", text: "Ungültiges Dateiformat." });
      } else {
        let file_response = JSON.parse(file.xhr.response);
        this.press.file = file_response.name;
      }
    },

    // Delete a single file by name
    deleteFileUpload(file,event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/press/delete/file/${file}`;
        let el = this.progress(event.target);
        this.axios.delete(uri).then(response => {
          this.press.file = null;
          this.progress(el);
        });
      }
    },

    fixUri() {
      let pattern = /^((http|https|ftp):\/\/)/;
      if (this.press.url.length < 1) {
        this.press.url = null;
        this.previewLink = null;
        return;
      }

      if (!pattern.test(this.press.url)) {
        this.previewLink = "http://" + this.press.url;
        this.press.url = "http://" + this.press.url;
      }
      else {
        this.previewLink = this.press.url;
        this.press.url = this.press.url;
      }
    }
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" ? "Bearbeiten" : "Hinzufügen";
    }
  }
};
</script>