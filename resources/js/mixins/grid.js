import Loading from 'vue-loading-overlay';
import GridPostComponent from '@/components/home/GridPostComponent.vue';

export default {

    components: {
        loading: Loading,
        gridPost: GridPostComponent,
    },

    data() {
        return {
            gridElements: [],
            posts: [],
            isLoading: false,
            fullPage: false,
            hasOverlay: false,
            displayPosts: false,
            tmpGridId: 0,
            tmpPosition: 0
        }
    },

    methods: {

        addArticle(gridId, position) {
            
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

        insertPost(postMediaId, postId) {

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

        deleteElement(gridElementId, postId) {
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
            this.hasOverlay = this.hasOverlay ? false : true;
        },
    }
};