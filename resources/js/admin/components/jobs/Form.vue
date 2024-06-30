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
          <div class="span" v-show="tabs.data.active">
            <div class="form-row" :class="errors.title.de ? 'has-error': ''">
              <label>Titel *</label>
              <input
                type="text"
                @focus="removeError('title', 'de')"
                name="title"
                v-model="job.title.de"
              >
            </div>
            <div class="form-row" :class="errors.lead.de ? 'has-error': ''">
              <label>Lead/Beschreibung *</label>
              <textarea
                @focus="removeError('lead', 'de')"
                v-model="job.lead.de"
                :class="errors.lead.de ? 'has-error': ''"
                rows="5"
              ></textarea>
            </div>
            <div class="form-row">
              <label>Info</label>
              <tinymce-editor
                :init="tinyConfig"
                v-model="job.info.de"
              ></tinymce-editor>
            </div>
          </div>
          <div class="span" v-show="tabs.media.active">
            <file-upload
              :labelNew="'Datei hochladen'"
              :labelExisting="'Vorhandene Datei'"
              :labelRestrictions="'pdf | max. 8 MB'"
              :maxFiles="1"
              :maxFilesize="8"
              :asset="job.media"
              :assetType="'file'"
              :acceptedFiles="'.pdf'"
              :uploadUrl="'/api/media/upload/document'"
            ></file-upload>
          </div>
          <form-buttons :route="'jobs'"></form-buttons>
        </form>
      </div>
    </main>
  </div>
</template>
<script>
import PageHeader from "@/layout/PageHeader.vue";
import FormButtons from "@/components/ui/buttons/FormButtons.vue";
import FileUpload from "@/components/ui/FileUpload.vue";
import tinyConfig from "@/config/tinyconfig.js";
import Editor from "@tinymce/tinymce-vue";
import Helpers from '@/mixins/helpers';
import Progress from '@/mixins/progress';

export default {
  components: {
    FileUpload: FileUpload,
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
          //en: false,
        },
        lead: {
          de: false
          //en: false,
        }
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

      job: {
        title: {
          de: null,
          en: null
        },
        lead: {
          de: null,
          en: null
        },
        info: {
          de: null,
          en: null
        },
        media: null
      },

      // tinymce config
      tinyConfig: tinyConfig
    };
  },

  created() {
    // Get the post for update view
    if (this.$props.type == "edit") {
      let uri = `/api/job/edit/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
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

    // Add the job
    store() {
      let uri = "/api/job/create";
      this.axios.post(uri, this.job).then(response => {
        this.$router.push({ name: "jobs" });
      });
    },

    // Update the job
    update() {
      let uri = `/api/job/update/${this.$route.params.id}`;
      this.axios.post(uri, this.job).then(response => {
        this.$router.push({ name: "jobs" });
      });
    },

    // Image Upload Callback
    afterFileUpload(file) {
      if (file.status == "error" && file.accepted == false) {
        this.$notify({ type: "error", text: "Ungültiges Dateiformat." });
      } else {
        let file_response = JSON.parse(file.xhr.response);
        this.job.media = file_response.name;
      }
    },

    // Delete a single file by name
    deleteFileUpload(file,event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/job/delete/file/${file}`;
        let el = this.progress(event.target);
        this.axios.delete(uri).then(response => {
          this.job.media = null;
          this.progress(el);
        });
      }
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" ? "Job bearbeiten" : "Job hinzufügen";
    }
  }
};
</script>