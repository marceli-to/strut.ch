<template>
  <div>
    <figure>
      <a
        href="javascript:;"
        class="btn-trash"
        @click.prevent="deleteMedia(element.id)"
      >Löschen</a>
      <video v-if="isVideo(element.image)" :src="getVideoSource(element.image)" height="50" width="50" muted></video>
      <img v-else :src="getPreviewImage(element.image)" height="50" width="50">
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
    element: Object
  },

  mixins: [grid],

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