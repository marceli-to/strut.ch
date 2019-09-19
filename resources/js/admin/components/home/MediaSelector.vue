<template>
  <div>
    <h3>Projektbild auswählen</h3>
    <div class="posts">
      <div class="post" v-for="project in projects" :key="project.id">
        <div class="post-text">
          <strong>{{ project.name.de }}</strong>
        </div>
        <div class="post-media">
          <figure v-for="image in project.images" :key="image.id">
            <a href @click.prevent="storeMedia(image.id, project.id)">
              <img :src="getImageSource(image.name)" height="50" width="50">
            </a>
          </figure>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  
  props: {
    projects: Array
  },

  methods: {
    storeMedia(projectImageId, postId) {
      this.$parent.storeMedia(projectImageId, postId);
    },

    getImageSource(file) {
      return `/media/${file}/xs`;
    }
  }
};
</script>