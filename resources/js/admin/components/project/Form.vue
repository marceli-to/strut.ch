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
            <!-- 
            <li>
              <a href="javascript:;" @click="changeTab('translation')" :class="[tabs.translation.active ? 'is-active' : '', tabs.translation.error ? 'has-error' : '']">Übersetzung</a>
            </li>
            -->
            <li>
              <a
                href="javascript:;"
                @click="changeTab('images')"
                :class="tabs.images.active ? 'is-active' : ''"
              >Bilder</a>
            </li>
            <li>
              <a
                href="javascript:;"
                @click="changeTab('files')"
                :class="tabs.files.active ? 'is-active' : ''"
              >Dateien</a>
            </li>
          </ul>
        </nav>
        <form @submit.prevent="submit">
          <div v-show="tabs.data.active">
            <div class="grid-project">
              <div>
                <div class="form-row" :class="errors.name.de ? 'has-error': ''">
                  <label>Name *</label>
                  <input
                    type="text"
                    @focus="removeError('name', 'de')"
                    name="name"
                    v-model="project.name.de"
                  >
                </div>
                <div class="form-row" :class="errors.location.de ? 'has-error': ''">
                  <label>Ort *</label>
                  <input
                    type="text"
                    @focus="removeError('location', 'de')"
                    name="location"
                    v-model="project.location.de"
                  >
                </div>
                <div class="form-row">
                  <label>Beschreibung</label>
                  <tinymce-editor
                    api-key="vuaywur9klvlt3excnrd9xki1a5lj25v18b2j0d0nu5tbwro"
                    :init="tinyConfig"
                    v-model="project.description.de"
                  ></tinymce-editor>
                </div>
                <div class="form-row">
                  <label>Info</label>
                  <tinymce-editor
                    api-key="vuaywur9klvlt3excnrd9xki1a5lj25v18b2j0d0nu5tbwro"
                    :init="tinyConfig"
                    v-model="project.info.de"
                  ></tinymce-editor>
                </div>
              </div>
              <aside class="sidebar">
                <div>
                  <div class="form-row form-row--narrow" :class="errors.year ? 'has-error': ''">
                    <label class="is-sm">Jahr *</label>
                    <div class="select-wrapper is-wide">
                      <select v-model="project.year" name="year" @focus="removeError('year')">
                        <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row form-row--narrow" :class="errors.status ? 'has-error': ''">
                    <label class="is-sm">Status</label>
                    <div class="select-wrapper is-wide">
                      <select
                        v-model="project.status"
                        name="status"
                        @change="onChangeStatus($event)"
                        @focus="removeError('status')"
                      >
                        <option v-for="s in status" :key="s" :value="s">{{ s }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row form-row--narrow">
                    <label class="is-sm">Wettbewerb</label>
                    <div class="select-wrapper is-wide">
                      <select
                        v-model="project.competition"
                        name="competition"
                        @change="onChangeCompetition($event)"
                      >
                        <option v-for="c in competition" :key="c" :value="c">{{ c }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row form-row--narrow" :class="errors.category_id ? 'has-error': ''">
                    <label class="is-sm">Kategorie *</label>
                    <div class="select-wrapper is-wide">
                      <select
                        v-model="project.category_id"
                        name="category_id"
                        @change="onChangeCategory($event)"
                        @focus="removeError('category_id')"
                      >
                        <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name.de }}</option>
                      </select>
                    </div>
                  </div>
                  <div
                    class="form-row form-row--narrow"
                    v-if="project.category_id"
                    :class="errors.category_type_id ? 'has-error': ''"
                  >
                    <label class="is-sm">Typ *</label>
                    <div class="select-wrapper is-wide">
                      <select
                        v-model="project.category_type_id"
                        name="type"
                        @change="onChangeType($event)"
                        @focus="removeError('category_type_id')"
                      >
                        <option
                          v-for="t in types"
                          :key="t.id"
                          :value="t.id"
                          :selected="t.name_singular.de"
                        >{{ t.name_singular.de }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row form-row--narrow">
                    <label class="is-sm">Detailseite?</label>
                    <div class="form-radio">
                      <input
                        v-model="project.has_detail"
                        type="radio"
                        name="has_detail"
                        id="has_detail_1"
                        value="1"
                        class="visually-hidden"
                      >
                      <label for="has_detail_1" class="form-control">Ja</label>
                      <input
                        v-model="project.has_detail"
                        type="radio"
                        name="has_detail"
                        id="has_detail_0"
                        value="0"
                        class="visually-hidden"
                      >
                      <label for="has_detail_0" class="form-control">Nein</label>
                    </div>
                  </div>
                  <div class="form-row is-last">
                    <label class="is-sm">Publizieren?</label>
                    <div class="form-radio">
                      <input
                        v-model="project.publish"
                        type="radio"
                        name="publish"
                        id="publish_1"
                        value="1"
                        class="visually-hidden"
                      >
                      <label for="publish_1" class="form-control">Ja</label>
                      <input
                        v-model="project.publish"
                        type="radio"
                        name="publish"
                        id="publish_0"
                        value="0"
                        class="visually-hidden"
                      >
                      <label for="publish_0" class="form-control">Nein</label>
                    </div>
                  </div>
                </div>
              </aside>
            </div>
          </div>
          <div v-show="tabs.images.active">
            <div class="form-row">
              <label for="document">
                Bilder hochladen
              </label>
              <vue-dropzone
                ref="dropzoneImages"
                id="dropzoneImages"
                :options="dropzoneImageConfig"
                @vdropzone-complete="afterImageComplete"
              ></vue-dropzone>
              <span class="dz-restrictions">jpg, png | max. 8 MB</span>
            </div>
            <div class="form-row" v-if="project.images.length">
              <label>Vorhandene Bilder</label>
              <div class="dropzone-existing-assets has-images">
                <div>
                  <figure
                    :class="[image.publish == 0 ? 'is-disabled' : '', 'dz-existing-asset is-image']"
                    v-for="(image,index) in project.images"
                    :key="image.id"
                  >
                    <img :src="getImageUri(image.name)" height="300" width="300">
                    <div class="dz-toolbar">
                      <a
                        href="javascript:;"
                        :class="[image.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']"
                        @click.prevent="toggleImage(image)"
                      ></a>
                      <a
                        href="javascript:;"
                        class="icon-edit icon-mini"
                        @click.prevent="showAssetEdit($event)"
                      ></a>
                      <a
                        href="javascript:;"
                        class="icon-trash icon-mini"
                        @click.prevent="deleteImage(image.name)"
                      ></a>
                    </div>
                    <div class="dz-edit-form">
                      <a
                        href="javascript:;"
                        class="dz-icon-hide-form"
                        @click.prevent="hideAssetEdit($event)"
                      >Schliessen</a>
                      <div class="dz-edit-form-row">
                        <label>Datei:</label>
                        <a 
                        :href="getPreviewUri(image.name)"
                        target="_blank"
                        >
                          {{image.name}}
                        </a>
                      </div>
                      <div class="dz-edit-form-row">
                        <label>Alt-Tag:</label>
                        <input
                          type="text"
                          v-model="image.caption.de"
                          class="is-caption"
                        >
                      </div>
                      <div class="dz-edit-form-row">
                        <label>Vorschaubild für:</label>
                          <input type="checkbox" class="visually-hidden" v-model="image.is_preview_status" name="is_preview_status" :id="'is_preview_status_'+index">
                          <label :for="'is_preview_status_'+index" class="form-control is-auto">Status</label>
                          <input type="checkbox" class="visually-hidden" v-model="image.is_preview_type" name="is_preview_type" :id="'is_preview_type_'+index">
                          <label :for="'is_preview_type_'+index" class="form-control is-auto">Typ</label>
                          <input type="checkbox" class="visually-hidden" v-model="image.is_preview_year" name="is_preview_year" :id="'is_preview_year_'+index">
                          <label :for="'is_preview_year_'+index" class="form-control is-auto">Jahr</label>
                      </div>
                    </div>
                  </figure>
                </div>
              </div>
            </div>
          </div>
          <div v-show="tabs.files.active">
            <div class="form-row">
              <label for="document">
                Dateien hochladen
              </label>
              <vue-dropzone
                ref="dropzoneFiles"
                id="dropzoneFiles"
                :options="dropzoneFileConfig"
                @vdropzone-complete="afterFileComplete"
              ></vue-dropzone>
              <span class="dz-restrictions">pdf | max. 8 MB</span>
            </div>
            <div class="form-row" v-if="project.downloads.length">
              <label>Vorhandene Dateien</label>
              <div class="dropzone-existing-assets has-files">
                <div>
                  <figure
                    class="dz-existing-asset"
                    v-for="file in project.downloads"
                    :key="file.id"
                  > 
                    <a :href="getFileUri(file.name)" target="_blank" class="dz-file-preview">
                      <img src="/assets/admin/img/icons/file.svg" height="100" width="100">
                    </a>
                    <div class="dz-toolbar">
                      <a 
                        href="javascript:;"
                        :class="[file.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']"
                        @click.prevent="toggleFile(file)"
                      ></a>
                      <a
                        href="javascript:;"
                        class="icon-edit icon-mini"
                        @click.prevent="showAssetEdit($event)"
                      ></a>
                      <a
                        href="javascript:;"
                        class="icon-trash icon-mini"
                        @click.prevent="deleteFile(file.name)"
                      ></a>
                    </div>
                    <div class="dz-edit-form">
                      <a
                        href="javascript:;"
                        class="dz-icon-hide-form"
                        @click.prevent="hideAssetEdit($event)"
                      >Schliessen</a>
                      <div class="dz-edit-form-row">
                        <label>Datei:</label>
                        {{file.name}}
                      </div>
                      <div class="dz-edit-form-row">
                        <label>Alt-Tag:</label>
                        <input
                          type="text"
                          v-model="file.caption.de"
                          class="is-caption"
                        >
                      </div>
                    </div>
                  </figure>
                </div>
              </div>
            </div>
          </div>
          <form-buttons 
            :route="'projects'">
          </form-buttons>
        </form>
      </div>
    </main>
  </div>
</template>
<script>
import PageHeader from "@/layout/PageHeader.vue";
import FormButtons from '@/components/ui/buttons/FormButtons.vue';
import draggable from 'vuedraggable';
import vue2Dropzone from "vue2-dropzone";
import dropzoneFileConfig from "@/config/dropzoneconfig-file.js";
import dropzoneImageConfig from "@/config/dropzoneconfig-image.js";
import tinyConfig from "@/config/tinyconfig.js";
import Editor from "@tinymce/tinymce-vue";
import years from "@/config/years.js";
import Helpers from '@/mixins/helpers';

export default {
  components: {
    FormButtons: FormButtons,
    vueDropzone: vue2Dropzone,
    tinymceEditor: Editor,
    draggable,
  },

  props: {
    type: String
  },
  
  mixins: [Helpers],
    
  data() {
    return {
      // fields with possible errors
      errors: {
        name: {
          de: false
          //en: false,
        },
        location: {
          de: false
          //en: false,
        },
        year: false,
        category_id: false,
        category_type_id: false,
        status: false
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
          en: null
        },
        location: {
          de: null,
          en: null
        },
        description: {
          de: null,
          en: null
        },
        info: {
          de: null,
          en: null
        },
        year: null,
        status: null,
        competition: null,
        category_id: null,
        category_type_id: null,
        has_detail: 1,
        publish: 0,

        // media
        images: [],
        downloads: []
      },

      // years
      years: years,

      // categories
      categories: [],

      // types
      types: [],

      // status options
      status: ["Ausgeführt", "In Planung", "Studie"],

      // competition options
      competition: ["", "1. Preis", "2. Preis", "Andere"],

      // dropzone config for pdf
      dropzoneFileConfig: dropzoneFileConfig,

      // dropzone config for images
      dropzoneImageConfig: dropzoneImageConfig,

      // tinymce config
      tinyConfig: tinyConfig
    };
  },

  created() {
    // Get the project
    if (this.$props.type == "edit") {
      this.fetchProject();
    }

    // Get all categories
    this.fetchCategories();

    // Update dropzone default config
    this.dropzoneImageConfig.maxFiles = 50;
    this.dropzoneFileConfig.maxFiles = 50;
  },

  methods: {

    // Fetch methods
    fetchProject() {
      let uri = `/api/project/edit/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.project = response.data;
        this.fetchTypes(this.project.category_id);
      });
    },

    fetchCategories() {
      let uri = "/api/categories/get";
      this.axios.get(uri).then(response => {
        this.categories = response.data.data;
      });
    },

    fetchTypes(categoryId) {
      let uri = `/api/types/get/${categoryId}`;
      this.axios.get(uri).then(response => {
        this.types = response.data.data;
      });
    },

    // Validation methods
    validate() {
      if (
        this.project.name.de &&
        this.project.location.de &&
        this.project.year
      ) {
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

      if (!this.project.category_id) {
        this.errors.category_id = true;
        this.tabs.data.error = true;
      }

      if (!this.project.category_type_id) {
        this.errors.category_type_id = true;
        this.tabs.data.error = true;
      }

      if (!this.project.status) {
        this.errors.status = true;
        this.tabs.data.error = true;
      }

      return false;
    },

    // Submit method
    submit() {
      if (!this.validate()) {
        this.validationError();
        return false;
      }

      if (this.$props.type == "edit") {
        this.update();
      }
      if (this.$props.type == "create") {
        this.store();
      }
    },

    // Add project
    store() {
      let uri = "/api/project/create";
      this.axios.post(uri, this.project).then(response => {
        this.$router.push({ name: "projects" });
      });
    },

    // Update project
    update() {
      let uri = `/api/project/update/${this.$route.params.id}`;
      this.axios.post(uri, this.project).then(response => {
        this.$router.push({ name: "projects" });
      });
    },

    // File Upload Callback
    afterFileComplete(file) {
      if (file.status == "error" && file.accepted == false) {
        this.$notify({ type: "error", text: "Ungültiges Dateiformat." });
      } else {
        let file_response = JSON.parse(file.xhr.response);
        file_response.id = null;
        file_response.caption = {de: null, en: null};
        file_response.order = -1;
        file_response.publish = 0;
        this.project.downloads.push(file_response);
      }
      this.$refs.dropzoneFiles.removeFile(file);
    },

    // Image Upload Callback
    afterImageComplete(file) {
      if (file.status == "error" && file.accepted == false) {
        this.$notify({ type: "error", text: "Ungültiges Dateiformat." });
      } else {
        let file_response = JSON.parse(file.xhr.response);
        file_response.id = null;
        file_response.caption = {de: null, en: null};
        file_response.order = -1;
        file_response.publish = 0;
        file_response.is_preview_type = null;
        file_response.is_preview_status = null;
        file_response.is_preview_year = null;
        this.project.images.push(file_response);
      }
      this.$refs.dropzoneImages.removeFile(file);
    },

    // Build media source string
    getFileUri(file) {
      return `/storage/media/downloads/${file}`;
    },

    getImageUri(file) {
      return `/media/thumbnail/${file}`;
    },

    getPreviewUri(file) {
      return `/media/${file}/sm`;
    },

    // Delete a single file by name
    deleteFile(file) {
      if(confirm('Bitte löschen bestätigen!')) {
        let uri = `/api/project/file/delete/${file}`;
        this.axios.delete(uri).then(response => {
          this.project.downloads.splice(this.project.downloads.indexOf(file), 1);
        });
      }
    },

    deleteImage(image) {
      if(confirm('Bitte löschen bestätigen!')) {
        let uri = `/api/project/image/delete/${image}`;
        this.axios.delete(uri).then(response => {
          this.project.images.splice(this.project.images.indexOf(image), 1);
        });
      }
    },

    // Update order
    updateImageOrder() { },
    updateFileOrder() { },

    toggleFile(file) {

      if (file.id === null) {
          const index = this.project.downloads.findIndex(x => x.name === file.name);
          this.project.downloads[index].publish = file.publish == 1 ? 0 : 1;
      }
      else {
        let uri = `/api/project/file/status/${file.id}`;
        this.axios.get(uri).then(response => {
          const index = this.project.downloads.findIndex(x => x.id === file.id);
          this.project.downloads[index].publish = response.data;
        });
      }
    },

    toggleImage(image) {
      if (image.id === null) {
          const index = this.project.images.findIndex(x => x.name === image.name);
          this.project.images[index].publish = image.publish == 1 ? 0 : 1;
      }
      else {
        let uri = `/api/project/image/status/${image.id}`;
        this.axios.get(uri).then(response => {
          const index = this.project.images.findIndex(x => x.id === image.id);
          this.project.images[index].publish = response.data;
        });
      }
    },

    // Events
    onChangeStatus(event) {
      this.project.status = event.target.value;
    },

    onChangeCompetition(event) {
      this.project.competition = event.target.value;
    },

    onChangeCategory(event) {
      this.project.category_id = event.target.value;

      // Reset type_id after change of parent
      this.project.category_type_id = null;

      // Update types
      let selectedId = event.target.value, types;
      this.categories.forEach(function(category, index) {
        if (category.id == selectedId) {
          types = category.types;
        }
      });
      this.types = types;
    },

    onChangeType(event) {
      this.project.category_type_id = event.target.value;
    }
  },

  computed: {
    title: function() {
      return this.$props.type == "edit"
        ? "Projekt bearbeiten"
        : "Projekt hinzufügen";
    }
  }
};
</script>