<template>
  <div>
    <h1>News auswählen</h1>
    <div class="article-selector">
      <div v-for="n in news" :key="n.id" @click.prevent="storeArticle(n.id)">
        <div class="article-selector__item" :class="[n.media ? 'has-image' : '']">
          <div class="article-selector__media">
            <figure v-if="n.media">
                <img :src="getImageSource(n.media)" height="50" width="50">
            </figure>
          </div>
          <div class="article-selector__text">
              <div class="item-date">{{ n.date.de }}</div>
              <h2>{{ n.title.de }}</h2>
              <div class="item-text">
                <strong>{{ n.subtitle.de }}</strong><br>
                {{ n.text.de }}
              </div>
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
    }
  },

  props: {
    news: Array
  },

  methods: {
    storeArticle(newsId) {
      this.$parent.storeArticle(newsId);
    },

    getImageSource(file) {
      return `/media/${file}/sm`;
    }
  },
  
  computed: {
    filtered() {
      return this.$props.news.filter(n => {
        return n;
      })
    }
  }
};
</script>