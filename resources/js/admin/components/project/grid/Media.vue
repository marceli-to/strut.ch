<template>
  <div>
    <figure>
      <a
        href="javascript:;"
        class="btn-trash"
        @click.prevent="deleteImage(element.id)"
      >Löschen</a>
      <video
        v-if="element.type === 'video'"
        :src="getVideoSource(element.image)"
        muted
        preload="metadata"
      ></video>
      <img v-else :src="getPreviewImage(element.image)">
      <figcaption v-if="element.caption">
        <strong>{{element.caption}}</strong>
      </figcaption>
    </figure>
  </div>
</template>
<script>
export default {
  props: {
    element: Object
  },

  methods: {

    deleteImage(id) {
      if (confirm("Bitte löschen bestätigen!")) {
        this.$parent.deleteImage(id);
      }
    },

    getPreviewImage(image) {
      return `/media/${image}/sm`;
    },

    getVideoSource(file) {
      return `/storage/media/${file}#t=0.1`;
    },
  }
};
</script>
