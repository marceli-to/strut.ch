// IndexComponent.vue
<template>
    <div>
        <page-header />
        
        <notifications classes="notification" />
        
        <loading :active.sync="isLoading" :is-full-page="fullPage" :height="30" :width="30"></loading>
        
        <div class="container">
            <main class="content" role="main">
                <div>
                    <h1>Masonry</h1>
                    
                    <grid-selector></grid-selector>
                    
                    <div class="grid-rows">
                        <div class="grid-row" v-for="grid in grids" :key="grid.id">
                            <a href="javascript:;" class="btn-trash" @click.prevent="deleteGrid(grid.id)">Delete grid</a>
                            <grid :layout="grid.layout.key" :gridId="grid.id" :elements="grid.elements"></grid>
                        </div>
                    </div>

                    <div :class="[hasOverlay ? 'is-visible': '', 'overlay']">
                        <div>
                            <a href="javascript:;" @click.prevent="toggleOverlay()" class="icon-close icon-close-overlay"></a>
                            <div v-show="selectPost">
                                <h2>Select a post</h2>
                                <div class="posts">
                                    <div class="post" v-for="post in posts" :key="post.id">
                                        <div class="post-text">
                                            <strong>{{ post.title }}</strong><br>{{ post.body | truncate(20, '...') }}
                                        </div>
                                        <div class="post-media">
                                            <figure v-for="media in post.media" :key="media.id">
                                                <a href="" @click.prevent="insertPost(media.id)">
                                                    <img :src="getMediaSource(media.name)" height="50" width="50">
                                                </a>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import PageHeaderComponent from '@/components/layout/PageHeaderComponent.vue';
import GridComponent from '@/components/home/GridComponent.vue';
import GridSelectorComponent from '@/components/home/GridSelectorComponent.vue';
import Loading from 'vue-loading-overlay';

export default {
    components: {
        pageHeader: PageHeaderComponent,
        grid: GridComponent,
        gridSelector: GridSelectorComponent,
        loading: Loading
    },

    data() {
        return {
            grids: [],
            posts: [],

            isLoading: false,
            fullPage: false,
            hasOverlay: false,
            selectPost: false,

            tmpGridId: 0,
            tmpPosition: 0
        }
    },

    created() {
        this.axios.get('/api/grid').then(response => {
            this.grids = response.data.data;
        });
    },

    methods: {

        fetchGrids() {
            this.axios.get('/api/grid').then(response => {
                this.grids = response.data.data;
                this.grids.forEach(g => {
                    if (g.length > 0) {
                        this.$emit.g.elements;
                    }
                });
            });
        },

        addGrid(gridId) {
            let uri = `/api/grid/store/${gridId}`;
            this.axios.get(uri).then((response) => {
                this.grids = response.data.data;
                this.$notify({type: 'success', title: 'Success!', text: 'A new grid was added successfully!'});
                this.fetchGrids();
            });
        },

        deleteGrid(id) {
            let uri = `/api/grid/delete/${id}`;
            this.axios.delete(uri).then(response => {
                const index = this.grids.findIndex(x => x.id === id);
                this.grids.splice(index, 1);
                this.$notify({type: 'success', title: 'Success!', text: 'The grid was deleted successfully!'});
            });
        },

        // Computed property - Build media source string 
        getMediaSource(file) {
            return `/media/thumbnail/${file}`;
        },

        toggleOverlay() {
            this.hasOverlay = this.hasOverlay ? false : true;
        },

        addPost(gridId, position) {
            this.isLoading = true;
            this.axios.get('/api/posts').then(response => {
                this.isLoading = false;
                this.toggleOverlay();
                this.posts = response.data.data;
                this.selectPost = true;
                this.tmpGridId = gridId;
                this.tmpPosition = position;
            });
        },

        insertPost(postMediaId) {

            let data = {
                'grid_id': this.tmpGridId,
                'position': this.tmpPosition,
                'post_media_id': postMediaId
            };

            let uri = '/api/gridelement/store';
            this.axios.post(uri, data).then((response) => {
                this.toggleOverlay();
                this.$notify({type: 'success', title: 'Success!', text: 'A new element was added successfully!'});
                this.fetchGrids();
            });
        },

        deleteItem(id) {
            let uri = `/api/gridelement/delete/${id}`;
            this.axios.delete(uri).then(response => {
                this.$notify({type: 'success', title: 'Success!', text: 'The grid element was deleted successfully!'});
                this.fetchGrids();
            });
        }
    }
}
</script>

