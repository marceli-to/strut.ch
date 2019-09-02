<template>
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Create a post</h1>
          <nav class="tabs">
            <ul>
              <li>
                <a href="javascript:;" @click="changeTab('data')" :class="[tabs.data.active ? 'is-active' : '', tabs.data.error ? 'has-error' : '']">Daten</a>
              </li>
              <li>
                <a href="javascript:;" @click="changeTab('images')" :class="tabs.images.active ? 'is-active' : ''">Bilder</a>
              </li>
            </ul>
          </nav>
          <form @submit.prevent="submitPost">
            <div class="span" v-show="tabs.data.active">
              <div class="form-row" :class="errors.title ? 'has-error': ''">
                <label>Titel *</label>
                <input type="text" @focus="removeError('title')" name="title" v-model="post.title">
              </div>
              <div class="form-row" :class="errors.body ? 'has-error': ''">
                  <label>Body</label>
                  <tinymce-editor api-key="vuaywur9klvlt3excnrd9xki1a5lj25v18b2j0d0nu5tbwro" :init="tinyConfig" v-model="post.body"></tinymce-editor>
              </div>
            </div>
            <div class="span" v-show="tabs.images.active">
              <div class="form-row">
                <label for="document">Bilder hochladen</label>
                <vue-dropzone ref="dropzone" id="dropzone" :options="dropzoneOptions" @vdropzone-complete="afterComplete"></vue-dropzone>
              </div>
              <div class="form-row" v-if="post.media.length">
                <label>Vorhandene Bilder</label>
                <div class="dropzone-existing-images">
                  <draggable 
                    v-model="post.media" 
                    @end="updateOrder"
                    ghost-class="ghost"
                    tag="div">
                    <figure class="dz-existing-image" v-for="media in post.media" :key="media.id">
                      <img :src="getMediaSource(media.name)" height="300" width="300">
                      <input type="text" v-model="media.caption" class="is-caption" placeholder="Caption">
                      <a href="javascript:;" class="dz-remove" @click.prevent="deleteMedia(media)">Delete</a>
                    </figure>
                  </draggable> 
                </div>
              </div>
            </div>
            <div class="form-row form-buttons">
              <button type="submit">Speichern</button>
              <router-link :to="{name: 'posts'}">Zurück</router-link>
            </div>
          </form>
        </div>
      </main>
    </div>
</template>
<script>
import vue2Dropzone from 'vue2-dropzone';
import draggable from 'vuedraggable';
import Editor from '@tinymce/tinymce-vue';

import tinyConfig from '@/config/tinyconfig.js'
import PageHeader from '@/layout/PageHeader.vue';

export default {

  components: {
    vueDropzone: vue2Dropzone,
    draggable,
    tinymceEditor: Editor
  },

  props: {
    type: String,
  },
  
  data() {
    return {

      // fields to validate
      errors: {
        title: false,
        body: false
      },

      // tabs
      tabs: {
        data: {
          active: true,
          error: false
        },
        images: {
          active: false,
          error: false
        }
      },

      // model
      post: {
        media: []
      },

      // tinymce config
      tinyConfig: tinyConfig,

      // dropzone options
      dropzoneOptions: {
        url: "/api/media/upload",
        method: 'post',
        thumbnailWidth: 150,
        maxFilesize: 8,
        maxFiles: 4,
        createImageThumbnails: false,
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
      }
    }
  },
  
  mounted() {

  },

  created() {

    // Get the post for update view
    if (this.$props.type == 'edit') {
      let uri = `/api/post/edit/${this.$route.params.id}`;
      this.axios.get(uri).then((response) => {
        this.post = response.data;
      });
    }
  },
  
  methods: {

    // Validation methods
    validate() {

      if (this.post.title && this.post.body) {
          return true;
      }

      if (!this.post.title) {
          this.errors.title = true;
          this.tabs.data.error = true;
      }

      if (!this.post.body) {
          this.errors.body = true;
          this.tabs.data.error = true;
      }

      return false;
    },

    removeError(el) {
      this.errors[el] = false;
    },

    // Submit method
    submitPost() {
      if (this.$props.type == 'edit') {
        this.updatePost();
      }

      if (this.$props.type == 'create') {
        this.addPost();
      }
    },

    // Add the post
    addPost() {
      if (this.validate()) {
        let uri = '/api/post/create';
        this.axios.post(uri, this.post).then((response) => {
          this.$router.push({name: 'posts'});
        });
      }
    },

    // Update the post
    updatePost() {
      if (this.validate()) {
        let uri = `/api/post/update/${this.$route.params.id}`;
        this.axios.post(uri, this.post).then((response) => {
          this.$router.push({name: 'posts'});
        });
      }
    },

    // FileUpload Callback - Add file to post model
    afterComplete(file) {
        let file_response = JSON.parse(file.xhr.response);
            file_response.id = null;
            file_response.caption = null;
        this.post.media.push(file_response);
        this.$refs.dropzone.removeFile(file);
    },
    
    // Computed property - Build media source string 
    getMediaSource(file) {
      return `/media/thumbnail/${file}`;
    },

    // Delete a single file by its name
    deleteMedia(file) {
      let uri = `/api/postmedia/delete/${file.name}`;
      this.axios.delete(uri).then((response) => {
        this.post.media.splice(this.post.media.indexOf(file), 1);
      });
    },

    // Update order
    updateOrder() {
      this.post.media.map(function(post, index) {
          post.order = index;
          return post;
      });
    },

    changeTab(tab) {
      // set all tabs inactive
      // remove errors if any
      for (let prop in this.tabs) {
        this.tabs[prop].active = false;
        this.tabs[prop].error = false;
      };
      // set active tab
      this.tabs[tab].active = true;
    },     
  }
}
</script>