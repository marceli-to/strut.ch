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
                    <masonry-layout-selector></masonry-layout-selector>
                    
                    <div class="masonry-rows">
                        <div class="masonry-row" v-for="grid in grids" :key="grid.id">
                            <a href="javascript:;" class="btn-trash" @click.prevent="deleteGrid(grid.id)">Delete row</a>
                            <masonry-layout :layout="grid.layout.key" :rowId="grid.id"></masonry-layout>
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
                                                <a href="" @click.prevent="insertPost(post.id, media.id)">
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
import PageHeaderComponent from '../layout/PageHeaderComponent.vue';
import MasonryLayout from './layouts/masonryLayout.vue';
import MasonryLayoutSelector from './layouts/masonryLayoutSelector.vue';
import Loading from 'vue-loading-overlay';

export default {
    components: {
        pageHeader: PageHeaderComponent,
        masonryLayout: MasonryLayout,
        MasonryLayoutSelector: MasonryLayoutSelector,
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

            tmpRowId: 0,
            tmpPosition: 0
        }
    },

    created() {
        this.axios.get('/api/grid').then(response => {
            this.grids = response.data.data;
        });
    },

    methods: {
        addGrid(gridId) {
            let uri = `/api/grid/store/${gridId}`;
            this.axios.get(uri).then((response) => {
                this.grids = response.data.data;
                this.$notify({type: 'success', title: 'Success!', text: 'The new grid was added successfully!'});
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

        addPost(rowId, position) {
            this.isLoading = true;
            this.axios.get('/api/posts').then(response => {
                this.isLoading = false;
                this.toggleOverlay();
                this.posts = response.data.data;
                this.selectPost = true;
                this.tmpRowId = rowId;
                this.tmpPosition = position;
            });
        },

        insertPost(postId, postMediaId) {
            console.log(postId);
            console.log(postMediaId);
            this.toggleOverlay();
        }
    }
}
</script>

