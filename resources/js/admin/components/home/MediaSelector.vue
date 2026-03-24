<template>
  <div>
    <h1>Projektbild auswählen</h1>
    <div class="project-selector">
      <div v-for="project in filtered" :key="project.id">
        <div class="project-selector__item is-multi" v-if="hasMedia(project)">
          <h2>{{ project.name.de }}, {{ project.location.de }} ({{project.year}})</h2>
          <div class="project-selector__media">
            <figure v-for="image in project.images" :key="'img-' + image.id">
              <a href @click.prevent="storeMedia(image.id, 'image')">
                <img :src="getImageSource(image.name)" height="50" width="50">
              </a>
            </figure>
            <figure v-for="video in project.videos" :key="'vid-' + video.id" class="is-video">
              <a href @click.prevent="storeMedia(video.id, 'video')">
                <video :src="getVideoSource(video.name)" muted preload="metadata"></video>
              </a>
            </figure>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  
  data() {
    return {
      search: '',
    };
  },

  props: {
    projects: Array
  },

  methods: {
    storeMedia(mediaId, type) {
      this.$parent.storeMedia(mediaId, type);
    },

    hasMedia(project) {
      return project.images.length > 0 || (project.videos && project.videos.length > 0);
    },

    getImageSource(file) {
      return `/media/grid/${file}`;
    },

    getVideoSource(file) {
      return `/storage/media/${file}`;
    },
  },
  
  computed: {
    filtered() {
      let projects = this.$props.projects;
      if (projects) {
        return projects.filter(project => {
          return this.hasMedia(project);
        })
      }
    }
  }
};
</script>
