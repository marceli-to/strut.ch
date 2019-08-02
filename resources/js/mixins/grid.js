import Loading from 'vue-loading-overlay';
import GridPostComponent from '@/components/home/GridPostComponent.vue';
import GridNewsComponent from '@/components/home/GridNewsComponent.vue';

export default {

    components: {
        loading: Loading,
        gridPost: GridPostComponent,
        //gridPostItem: GridPostItemComponent,
        gridNews: GridNewsComponent
    },

    data() {
        return {
            // grid data
            gridElements: [],
            posts: [],

            // loading
            isLoading: false,
            fullPage: false,

            // overlay
            hasOverlay: false,
            displayPosts: false,
            displayNewsForm: false,

            // temp. data
            tmpGridId: 0,
            tmpPosition: 0
        }
    },

    methods: {

        addNews(gridId, position) {
            this.toggleOverlay();
            this.displayNewsForm = true;
            this.tmpGridId = gridId;
            this.tmpPosition = position;
        },

        createNews(data) {
        
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

                let uri = '/api/gridelement/store';
                this.axios.post(uri, data).then((response) => {
                    this.toggleOverlay();
                    this.$notify({type: 'success', title: 'Success!', text: 'A new element was added successfully!'});
                    this.fetchElements();
                });
            });
        },

        addPost(gridId, position) {
            this.isLoading = true;
            this.axios.get('/api/posts/grid').then(response => {
                this.posts = response.data.data;
                this.toggleOverlay();
                this.isLoading = false;
                this.displayPosts = true;
                this.tmpGridId = gridId;
                this.tmpPosition = position;
            });
        },

        createPost(postMediaId, postId) {

            let data = {
                'grid_id': this.tmpGridId,
                'position': this.tmpPosition,
                'post_media_id': postMediaId
            };

            let uri = '/api/gridelement/store';
            this.isLoading = true;
            this.axios.post(uri, data).then((response) => {
                this.axios.post(`/api/post/update/${postId}`, {'isGridElement': true}).then((response) => {
                    this.toggleOverlay();
                    this.$notify({type: 'success', title: 'Success!', text: 'A new element was added successfully!'});
                    this.fetchElements();
                });
            });
        },

        deletePostElement(gridElementId, postId) {
            let uri = `/api/gridelement/delete/${gridElementId}`;
            this.isLoading = true;
            this.axios.delete(uri).then(response => {
                this.axios.post(`/api/post/update/${postId}`, {'isGridElement': false}).then((response) => {
                    this.$notify({type: 'success', title: 'Success!', text: 'The grid element was deleted successfully!'});
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
            
            // reset news/posts
            if (!this.hasOverlay) {
                this.displayNewsForm = false;
                this.displayPosts = false;
            }
        },
    }
};