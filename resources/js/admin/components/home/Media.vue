<template>
  <div>
    <figure>
      <a
        href="javascript:;"
        class="btn-trash"
        @click.prevent="deleteMedia(element.id)"
      >Löschen</a>
      <video
        v-if="isVideo(element.image)"
        :src="getVideoSource(element.image)"
        class="media-preview"
        :style="mediaPreviewStyle"
        muted
        preload="metadata"
      ></video>
      <img v-else :src="getPreviewImage(element.image)" class="media-preview" :style="mediaPreviewStyle">
      <figcaption>
        <strong>{{element.caption}}</strong>
      </figcaption>
    </figure>
  </div>
</template>
<script>
import grid from "@/mixins/grid";

export default {
  props: {
    element: Object,
    previewAspectRatio: {
      type: String,
      default: null
    }
  },

  mixins: [grid],

  computed: {
    mediaPreviewStyle() {
      if (!this.previewAspectRatio) {
        return {};
      }

      return {
        aspectRatio: this.previewAspectRatio,
        objectFit: "cover"
      };
    }
  },

  methods: {
    deleteMedia(elementId) {
      if (confirm("Bitte löschen bestätigen!")) {
        this.$parent.deleteMedia(elementId);
      }
    },

    isVideo(file) {
      const ext = file.split('.').pop().toLowerCase();
      return ['mp4', 'webm', 'mov'].includes(ext);
    },

    getVideoSource(file) {
      return `/storage/media/${file}`;
    }
  }
};
</script>

<style scoped>
img.media-preview,
video.media-preview {
  display: block;
  width: 100%;
}
</style>
