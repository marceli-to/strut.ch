<template>
  <div>
    <figure>
      <a
        href="javascript:;"
        class="btn-trash"
        @click.prevent="deleteMedia(element.id)"
      >Löschen</a>
      <img :src="getPreviewImage(element.image)" height="50" width="50">
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
    }
  }
};
</script>