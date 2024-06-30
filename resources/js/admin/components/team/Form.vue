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
            <div class="grid-team">
              <div class="span form-row" :class="errors.firstname ? 'has-error': ''">
                <label>Vorname *</label>
                <input
                  type="text"
                  @focus="removeError('firstname')"
                  name="firstname"
                  v-model="team.firstname"
                >
              </div>
              <div class="span form-row" :class="errors.name ? 'has-error': ''">
                <label>Name *</label>
                <input type="text" @focus="removeError('name')" name="name" v-model="team.name">
              </div>
              <div class="span form-row">
                <label>Funktion</label>
                <input
                  type="text"
                  name="role"
                  v-model="team.role.de"
                  placeholder="z.B. Architekt ETH"
                >
              </div>
              <div class="span form-row">
                <label>Position</label>
                <input
                  type="text"
                  name="position"
                  v-model="team.position.de"
                  placeholder="z.B. Partner"
                >
              </div>
              <div class="span form-row">
                <label>Telefon</label>
                <masked-input v-model="team.phone" mask="\0\5\2 111 11 11" type="text" placeholder="052 2xx xx xx" />
              </div>
              <div class="span form-row" :class="errors.email ? 'has-error': ''">
                <label>E-Mail *</label>
                <input type="text" @focus="removeError('email')" name="email" v-model="team.email">
              </div>
            </div>
            <div class="form-row">
              <label>Lebenslauf</label>
              <tinymce-editor
                :init="tinyConfig"
                v-model="team.cv.de"
              ></tinymce-editor>
            </div>
          </div>
          <div v-show="tabs.media.active">
            <image-upload
              :labelNew="'Bild hochladen'"
              :labelExisting="'Vorhandenes Bild'"
              :labelRestrictions="'jpg, png | max. 8 MB'"
              :maxFiles="1"
              :maxFilesize="8"
              :asset="team.media"
              :assetType="'image'"
              :acceptedFiles="'.png,.jpg'"
              :uploadUrl="'/api/media/upload'"
            ></image-upload>
          </div>
          <form-buttons :route="'team'"></form-buttons>
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
import MaskedInput from 'vue-masked-input'
import Progress from "@/mixins/progress";

export default {
  components: {
    ImageUpload: ImageUpload,
    tinymceEditor: Editor,
    FormButtons: FormButtons,
    MaskedInput
  },

  props: {
    type: String
  },

  mixins: [Helpers, Progress],

  data() {
    return {
      // fields to validate
      errors: {
        name: false,
        firstname: false,
        email: false
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
          en: null
        },
        position: {
          de: null,
          en: null
        },
        phone: null,
        email: null,
        cv: {
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
    if (this.$props.type == "edit") {
      let uri = `/api/team/edit/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.team = response.data;
      });

      // Overwrite tinymce config
      this.tinyConfig.height = "360px";
    }
  },

  methods: {
    // Validation methods
    validate() {
      if (this.team.name && this.team.firstname && this.team.email) {
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

    // Add the team
    store() {
      let uri = "/api/team/create";
      this.axios.post(uri, this.team).then(response => {
        this.$router.push({ name: "team" });
      });
    },

    // Update the team
    update() {
      let uri = `/api/team/update/${this.$route.params.id}`;
      this.axios.post(uri, this.team).then(response => {
        this.$router.push({ name: "team" });
      });
    },

    // Image Upload Callback
    afterImageUpload(file) {
      if (file.status == "error" && file.accepted == false) {
        this.$notify({ type: "error", text: "Ungültiges Dateiformat." });
      } else {
        let file_response = JSON.parse(file.xhr.response);
        this.team.media = file_response.name;
      }
    },

    // Delete a single file by name
    deleteImageUpload(file,event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/team/delete/file/${file}`;
        let el = this.progress(event.target);
        this.axios.delete(uri).then(response => {
          this.team.media = null;
          this.progress(el);
        });
      }
    }
  },

  computed: {
    title: function() {
      return this.$props.type == "edit"
        ? "Teammitglied bearbeiten"
        : "Teammitglied hinzufügen";
    }
  }
};
</script>