import Loading from 'vue-loading-overlay';
import GridMediaSelector from '@/components/home/MediaSelector.vue';
import GridArticleForm from '@/components/home/ArticleForm.vue';

export default {

  components: {
    loading: Loading,
    GridMediaSelector: GridMediaSelector,
    GridArticleForm: GridArticleForm
  },

  data() {
    return {
      // grid data
      elements: [],
      projects: [],

      // loading
      isLoading: false,
      fullPage: false,

      // overlay
      hasOverlay: false,
      showMedia: false,
      showForm: false,

      // temp. data
      tmpGridId: 0,
      tmpPosition: 0
    }
  },

    methods: {

      createArticle(gridId, position) {
        this.toggleOverlay();
        this.showForm = true;
        this.tmpGridId = gridId;
        this.tmpPosition = position;
      },

      storeArticle(data) {

        // store the news entry
        let uri = '/api/news/create';
        this.isLoading = true;
        this.axios.post(uri, data).then((response) => {

          // store the grid element
          let data = {
            'grid_id': this.tmpGridId,
            'position': this.tmpPosition,
            'news_id': response.data.newsId
          };

          let uri = '/api/home/grid/element/store';
          this.axios.post(uri, data).then((response) => {
              this.toggleOverlay();
              this.$notify({type: 'success', text: 'A new element was added successfully!' });
              this.fetchElements();
          });
        });
      },

      deleteArticle(gridElementId, articleId) {
        let uri = `/api/home/grid/element/delete/${gridElementId}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.axios.post(`/api/news/delete/${articleId}`).then((response) => {
            this.$notify({type: 'success', text: 'The grid element was deleted successfully!'});
            this.fetchElements();
          });
        });
      },

      createMedia(gridId, position) {
        this.isLoading = true;
        this.axios.get('/api/projects/fetch/1/asc').then(response => {
          this.projects = response.data.data;
          this.toggleOverlay();
          this.isLoading = false;
          this.showMedia = true;
          this.tmpGridId = gridId;
          this.tmpPosition = position;
        });
      },

      storeMedia(projectImageId, postId) {

        let data = {
          'grid_id': this.tmpGridId,
          'position': this.tmpPosition,
          'project_image_id': projectImageId
        };

        let uri = '/api/home/grid/element/store';
        this.isLoading = true;
        this.axios.post(uri, data).then((response) => {
          this.axios.post(`/api/post/update/${postId}`, {
            'isGridElement': true
          }).then((response) => {
            this.toggleOverlay();
            this.$notify({type: 'success', text: 'A new element was added successfully!'});
            this.fetchElements();
          });
        });
      },

      deleteMedia(gridElementId, postId) {
        let uri = `/api/home/grid/element/delete/${gridElementId}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          this.axios.post(`/api/post/update/${postId}`, {
            'isGridElement': false
          }).then((response) => {
            this.$notify({type: 'success', text: 'The grid element was deleted successfully!'});
            this.fetchElements();
          });
        });
      },

      // Helper methods
      getPreviewImage(file) {
        return `/media/${file}/sm`;
      },

      toggleOverlay() {

        // toggle class on html to prevent double scrollbars
        let html = document.querySelector('html');
        html.classList.toggle('has-overlay');

        // toggle the overlay itself
        this.hasOverlay = this.hasOverlay ? false : true;

        // reset news/projects
        if (!this.hasOverlay) {
            this.showForm = false;
            this.showMedia = false;
        }
      },
    }
};
