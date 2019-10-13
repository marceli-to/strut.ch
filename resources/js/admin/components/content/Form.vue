<template>
  <div class="container">
    <notifications classes="notification"/>
    <main class="content" role="main">
      <div>
        <h1>{{title}}</h1>
        <nav class="tabs" v-if="content.has_media">
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
              <input type="text" @focus="removeError('title.de')" name="title" v-model="content.title.de">
            </div>
            <div class="form-row">
              <label>Text</label>
              <tinymce-editor
                api-key="vuaywur9klvlt3excnrd9xki1a5lj25v18b2j0d0nu5tbwro"
                :init="tinyConfig"
                v-model="content.text.de"
              ></tinymce-editor>
            </div>
          </div>
          <div v-show="tabs.media.active" v-if="content.has_media">
            <image-upload
              :labelNew="'Bild hochladen'"
              :labelExisting="'Vorhandenes Bild'"
              :labelRestrictions="'jpg, png | max. 8 MB'"
              :maxFiles="1"
              :maxFilesize="8"
              :assets="content.images"
              :assetType="'image'"
              :acceptedFiles="'.png,.jpg'"
              :uploadUrl="'/api/media/upload'"
            ></image-upload>
          </div>
          <form-buttons :route="'contents'"></form-buttons>
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
        },
        text: {
          de: false
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

      content: {
        title: {
          de: null,
          en: null
        },
        text: {
          de: null,
          en: null
        },
        images: null
      },

      // tinymce config
      tinyConfig: tinyConfig
    };
  },

  created() {
    if (this.$props.type == "edit") {
      let uri = `/api/content/edit/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.content = response.data;
      });
    }

    // Overwrite tinymce config
    this.tinyConfig.height = "360px";
  },

  methods: {

    // Validation methods
    validate() {
      if (this.content.title.de && this.content.text.de) {
        return true;
      }

      if (!this.content.title.de) {
        this.errors.title.de = true;
        this.tabs.data.error = true;
      }

      if (!this.content.text.de) {
        this.errors.text.de = true;
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

    // Add the content
    store() {
      let uri = "/api/content/create";
      this.axios.post(uri, this.content).then(response => {
        this.$router.push({ name: "contents" });
      });
    },

    // Update the content
    update() {
      let uri = `/api/content/update/${this.$route.params.id}`;
      this.axios.post(uri, this.content).then(response => {
        this.$router.push({ name: "contents" });
      });
    },

    // Image Upload Callback
    afterImageUpload(file) {
      if (file.status == "error" && file.accepted == false) {
        this.$notify({ type: "error", text: "Ungültiges Dateiformat." });
      } else {
        let file_response = JSON.parse(file.xhr.response);
        file_response.id = null;
        file_response.caption = null;
        file_response.order = -1;
        file_response.publish = 1;
        this.content.images.push(file_response);
      }
    },

    // Delete a single file by name
    deleteImageUpload(image,event) {
      if(confirm('Bitte löschen bestätigen!')) {
        let uri = `/api/content/delete/file/${image.name}`, self = this;
        let el = this.progress(event.target);
        const index = this.content.images.findIndex(x => x.name === image);
        this.axios.delete(uri)
        .then(response => {
          self.content.images.splice(index, 1);
        })
        .catch(function(error) {
          self.$notify({type: 'error', text: error.response.data});
          self.progress(el);
        });
      }
    },
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" ? "Inhalt bearbeiten" : "Inhalt hinzufügen";
    }
  }
};
</script>