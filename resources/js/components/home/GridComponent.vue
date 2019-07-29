<template>
    <div>
        <loading :active.sync="isLoading" :is-full-page="fullPage" :height="30" :width="30"></loading>
        <div class="grids">
            <div v-if="layout == '1fr'">
                <div class="grid-1fr">
                    <div class="span">
                        <div v-if="gridElements[0] && gridElements[0].position == '0'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(gridElements[0].id)">Delete item</a>
                                <img :src="getPreviewImage(gridElements[0].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{gridElements[0].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(gridId,0);">Add teaser</a>&nbsp;
                            <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(gridId,0);">Add post</a>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="layout == '2fr'">
                <div class="grid-2fr">
                    <div class="span">
                        <div v-if="gridElements[0] && gridElements[0].position == '0'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(gridElements[0].id)">Delete item</a>
                                <img :src="getPreviewImage(gridElements[0].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{gridElements[0].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(gridId,0);">Add teaser</a>&nbsp;
                            <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(gridId,0);">Add post</a>
                        </div>
                    </div>
                    <div class="span">
                        <div v-if="gridElements[1] && gridElements[1].position == '1'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(gridElements[1].id)">Delete item</a>
                                <img :src="getPreviewImage(gridElements[1].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{gridElements[1].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(gridId,1);">Add teaser</a>&nbsp;
                            <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(gridId,1);">Add post</a>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="layout == '3fr'">
                <div class="grid-3fr">
                    <div class="span">
                        <div v-if="gridElements[0] && gridElements[0].position == '0'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(gridElements[0].id)">Delete item</a>
                                <img :src="getPreviewImage(gridElements[0].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{gridElements[0].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(gridId,0);">Add teaser</a>&nbsp;
                            <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(gridId,0);">Add post</a>
                        </div>
                    </div>
                    <div class="span">
                        <div v-if="gridElements[1] && gridElements[1].position == '1'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(gridElements[1].id)">Delete item</a>
                                <img :src="getPreviewImage(gridElements[1].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{gridElements[1].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(gridId,1);">Add teaser</a>&nbsp;
                            <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(gridId,1);">Add post</a>
                        </div>
                    </div>
                    <div class="span">
                        <div v-if="gridElements[2] && gridElements[2].position == '2'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(gridElements[2].id)">Delete item</a>
                                <img :src="getPreviewImage(gridElements[2].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{gridElements[2].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(gridId,2);">Add teaser</a>&nbsp;
                            <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(gridId,2);">Add post</a>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="layout == '2fr1fr'">
                <div class="grid-2fr1fr">
                    <div class="span">
                        <div v-if="gridElements[0] && gridElements[0].position == '0'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(gridElements[0].id)">Delete item</a>
                                <img :src="getPreviewImage(gridElements[0].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{gridElements[0].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(gridId,0);">Add teaser</a>&nbsp;
                            <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(gridId,0);">Add post</a>
                        </div>
                    </div>
                    <div class="span">
                        <div v-if="gridElements[1] && gridElements[1].position == '1'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(gridElements[1].id)">Delete item</a>
                                <img :src="getPreviewImage(gridElements[1].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{gridElements[1].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(gridId,1);">Add teaser</a>&nbsp;
                            <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(gridId,1);">Add post</a>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="layout == '2fr1fr-stacked'">
                <div class="grid-2fr1fr-stacked">
                    <div class="span">
                        <div v-if="gridElements[0] && gridElements[0].position == '0'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(gridElements[0].id)">Delete item</a>
                                <img :src="getPreviewImage(gridElements[0].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{gridElements[0].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(gridId,0);">Add teaser</a>&nbsp;
                            <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(gridId,0);">Add post</a>
                        </div>
                    </div>
                    <div class="span grid-stacked">
                        <div class="span">
                            <div v-if="gridElements[1] && gridElements[1].position == '1'">
                                <figure>
                                    <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(gridElements[1].id)">Delete item</a>
                                    <img :src="getPreviewImage(gridElements[1].postmedia.name)" height="50" width="50">
                                    <figcaption>
                                        <strong>{{gridElements[1].postmedia.post.title}}</strong>
                                    </figcaption>
                                </figure>
                            </div>
                            <div v-else>
                                <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(gridId,1);">Add teaser</a>&nbsp;
                                <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(gridId,1);">Add post</a>
                            </div>
                        </div>
                        <div class="span">
                            <div v-if="gridElements[2] && gridElements[2].position == '2'">
                                <figure>
                                    <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(gridElements[2].id)">Delete item</a>
                                    <img :src="getPreviewImage(gridElements[2].postmedia.name)" height="50" width="50">
                                    <figcaption>
                                        <strong>{{gridElements[2].postmedia.post.title}}</strong>
                                    </figcaption>
                                </figure>
                            </div>
                            <div v-else>
                                <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(gridId,2);">Add teaser</a>&nbsp;
                                <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(gridId,2);">Add post</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div :class="[hasOverlay ? 'is-visible': '', 'overlay']">
            <div>
                <a href="javascript:;" @click.prevent="toggleOverlay()" class="icon-close icon-close-overlay"></a>
                <div v-show="displayPosts">
                    <grid-post></grid-post>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import grid from '@/mixins/grid';
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

            isLoading: false,
            fullPage: false,
            hasOverlay: false,
            displayPosts: false,
            tmpGridId: 0,
            tmpPosition: 0
        }
    },

    props: {
        layout: String,
        gridId: Number,
    },

    mixins: [grid],

    created() {
        this.fetchElements();
    },

    methods: {

        fetchElements() {
            let uri = `/api/gridelement/get/${this.$props.gridId}`;
            this.isLoading = true;
            this.axios.get(uri).then(response => {
                let els = [];
                if (response.data.data) {
                    response.data.data.forEach(e => {
                        els[e.position] = e;
                    });
                    this.gridElements = els;
                }
                this.isLoading = false;
            });
        },
        
        addArticle(gridId, position) {},

        addPost(gridId, position) {
            this.toggleOverlay();
            this.displayPosts = true;
            this.tmpGridId = gridId;
            this.tmpPosition = position;
        },

        insertPost(postMediaId) {

            let data = {
                'grid_id': this.tmpGridId,
                'position': this.tmpPosition,
                'post_media_id': postMediaId
            };

            let uri = '/api/gridelement/store';
            this.isLoading = true;
            this.axios.post(uri, data).then((response) => {
                this.toggleOverlay();
                this.$notify({type: 'success', title: 'Success!', text: 'A new element was added successfully!'});
                this.fetchElements();
            });
        },

        deleteElement(id) {
            let uri = `/api/gridelement/delete/${id}`;
            this.isLoading = true;
            this.axios.delete(uri).then(response => {
                this.$notify({type: 'success', title: 'Success!', text: 'The grid element was deleted successfully!'});
                this.fetchElements();
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
}
</script>