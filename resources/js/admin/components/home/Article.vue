<template>
  <div>
    <article>
        <a
          href="javascript:;"
          class="btn-trash"
          @click.prevent="deleteArticle(element.id, element.articleId)"
        >Löschen</a>
      <div v-if="element.date">{{element.date}}</div>
      <div v-if="element.title"><strong>{{element.title}}</strong></div>
      <div v-if="element.subtitle">{{element.subtitle}}</div>
      <div v-if="element.text">{{ element.text | truncate(25, '...') }}</div>
      <figure v-if="element.media">
          <img :src="getImageSource(element.media)" height="50" width="50">
      </figure>
    </article>
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
    deleteArticle(elementId) {
      if (confirm("Bitte löschen bestätigen!")) {
        this.$parent.deleteArticle(elementId);
      }
    },
    getImageSource(file) {
      return `/media/${file}/sm`;
    }
  }
};
</script>