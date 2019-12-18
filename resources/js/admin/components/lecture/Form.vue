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
            <div class="form-row" :class="errors.title.de ? 'has-error': ''">
              <label>Titel *</label>
              <input
                type="text"
                @focus="removeError('title', 'de')"
                name="title"
                v-model="lecture.title.de"
              >
            </div>
            <div class="form-row" :class="errors.description.de ? 'has-error': ''">
              <label>Beschreibung</label>
              <textarea
                @focus="removeError('description', 'de')"
                v-model="lecture.description.de"
                :class="errors.description.de ? 'has-error': ''"
                rows="5"
              ></textarea>
            </div>
            <div class="form-row" :class="errors.year ? 'has-error': ''">
              <label>Jahr *</label>
              <div class="select-wrapper">
                <select
                  class="is-md"
                  v-model="lecture.year"
                  name="year"
                  @focus="removeError('year')"
                >
                  <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                </select>
              </div>
            </div>
          </div>
          <div v-show="tabs.media.active">
            <image-upload
              :labelNew="'Bild hochladen'"
              :labelExisting="'Vorhandenes Bild'"
              :labelRestrictions="'jpg, png | max. 8 MB'"
              :maxFiles="1"
              :maxFilesize="8"
              :asset="lecture.media"
              :assetType="'image'"
              :acceptedFiles="'.png,.jpg'"
              :uploadUrl="'/api/media/upload'"
            ></image-upload>
          </div>
          <form-buttons :route="'lectures'"></form-buttons>
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
import years from "@/config/years.js";
import Editor from "@tinymce/tinymce-vue";
import Helpers from "@/mixins/helpers";
import Progress from "@/mixins/progress";

export default {
  components: {
    ImageUpload: ImageUpload,
    tinymceEditor: Editor,
    FormButtons: FormButtons
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
          de: false
          //en: false,
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
        }
      },

      lecture: {
        title: {
          de: null,
          en: null
        },
        description: {
          de: null,
          en: null
        },
        year: null,
        media: null
      },

      // years
      years: years,

      // tinymce config
      tinyConfig: tinyConfig
    };
  },

  created() {
    if (this.$props.type == "edit") {
      let uri = `/api/lecture/edit/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
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

    // Add the lecture
    store() {
      let uri = "/api/lecture/create";
      this.axios.post(uri, this.lecture).then(response => {
        this.$router.push({ name: "lectures" });
      });
    },

    // Update the lecture
    update() {
      let uri = `/api/lecture/update/${this.$route.params.id}`;
      this.axios.post(uri, this.lecture).then(response => {
        this.$router.push({ name: "lectures" });
      });
    },

    // Image Upload Callback
    afterImageUpload(file) {
      if (file.status == "error" && file.accepted == false) {
        this.$notify({ type: "error", text: "Ungültiges Dateiformat." });
      } else {
        let file_response = JSON.parse(file.xhr.response);
        this.lecture.media = file_response.name;
      }
    },

    // Delete a single file by name
    deleteImageUpload(file,event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/lecture/delete/file/${file}`;
        let el = this.progress(event.target);
        this.axios.delete(uri).then(response => {
          this.lecture.media = null;
          this.progress(el);
        });
      }
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit"
        ? "Vortrag bearbeiten"
        : "Vortrag hinzufügen";
    }
  }
};
</script>