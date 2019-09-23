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
          </ul>
        </nav>
        <form @submit.prevent="submit">
          <div v-show="tabs.data.active">
            <div class="form-row">
              <label>Datum</label>
              <input type="text" v-model="news.date.de">
            </div>
            <div class="form-row" :class="errors.title.de ? 'has-error': ''">
              <label>Titel *</label>
              <input type="text" @focus="removeError('title', 'de')" v-model="news.title.de">
            </div>
            <div class="form-row">
              <label>Text</label>
              <textarea v-model="news.text.de" rows="5"></textarea>
            </div>
            <div class="form-row">
              <label>
                Link / E-Mail
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
                v-model="news.link.de"
                placeholder="https://test.ch/"
                @blur="fixUri()"
              >
            </div>
            <div class="form-row">
              <label>Link Text</label>
              <input type="text" v-model="news.linkText.de">
            </div>
          </div>
          <div v-show="tabs.media.active">
            <image-upload
              :labelNew="'Bild hochladen'"
              :labelExisting="'Vorhandenes Bild'"
              :labelRestrictions="'jpg, png | max. 8 MB'"
              :maxFiles="1"
              :maxFilesize="8"
              :asset="news.media"
              :assetType="'image'"
              :acceptedFiles="'.png,.jpg'"
              :uploadUrl="'/api/media/upload'"
            ></image-upload>
          </div>
          <form-buttons :route="'news'"></form-buttons>
        </form>
      </div>
    </main>
  </div>
</template>
<script>
import PageHeader from "@/layout/PageHeader.vue";
import FormButtons from "@/components/ui/buttons/FormButtons.vue";
import ImageUpload from "@/components/ui/ImageUpload.vue";
import Helpers from "@/mixins/helpers";

export default {
  components: {
    ImageUpload: ImageUpload,
    FormButtons: FormButtons
  },

  props: {
    type: String
  },

  mixins: [Helpers],

  data() {
    return {
      // fields to validate
      errors: {
        title: {
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

      // model
      news: {
        date: {
          de: null,
        },
        title: {
          de: null,
        },
        text: {
          de: null,
        },
        link: {
          de: null,
        },
        linkText: {
          de: null,
        },
        media: null
      },

      previewLink: null,

    };
  },

  created() {
    if (this.$props.type == "edit") {
      let uri = `/api/news/edit/${this.$route.params.id}`;
      this.axios.get(uri).then(response => {
        this.news = response.data;
        if (this.news.link.de) {
          this.fixUri(this.news.link.de);
        }
      });
    }
  },

  methods: {
    // Validation methods
    validate() {
      if (this.news.title.de) {
        return true;
      }

      if (!this.news.title.de) {
        this.errors.title.de = true;
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

    // Add the news
    store() {
      let uri = "/api/news/create";
      this.axios.post(uri, this.news).then(response => {
        this.$router.push({ name: "news" });
      });
    },

    // Update the news
    update() {
      let uri = `/api/news/update/${this.$route.params.id}`;
      this.axios.post(uri, this.news).then(response => {
        this.$router.push({ name: "news" });
      });
    },

    // Image Upload Callback
    afterImageUpload(file) {
      if (file.status == "error" && file.accepted == false) {
        this.$notify({ type: "error", text: "Ungültiges Dateiformat." });
      } else {
        let file_response = JSON.parse(file.xhr.response);
        this.news.media = file_response.name;
      }
    },

    // Delete a single file by name
    deleteImageUpload(file) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/news/delete/file/${file}`;
        this.axios.delete(uri).then(response => {
          this.news.media = null;
        });
      }
    },

    fixUri() {
      // check for '@'
      let index = 0,
        pattern = /^((http|https|ftp):\/\/)/;

      if (this.news.link.de.length < 1) {
        this.news.link.de = null;
        this.previewLink = null;
        return;
      }

      if ((index = this.news.link.de.indexOf("@")) !== -1) {
        this.previewLink = "mailto:" + this.news.link.de;
      } else {
        if (!pattern.test(this.news.link.de)) {
          this.previewLink = "http://" + this.news.link.de;
          this.news.link.de = "http://" + this.news.link.de;
        } else {
          this.previewLink = this.news.link.de;
          this.news.link.de = this.news.link.de;
        }
      }
    }
  },

  computed: {
    title: function() {
      return this.$props.type == "edit" 
      ? "News bearbeiten" 
      : "News hinzufügen";
    }
  }
};
</script>