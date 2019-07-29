<template>
    <div>
        <div class="grids">
            <div v-if="layout == '1fr'">
                <div class="grid-1fr">
                    <div class="span">
                        <div v-if="gridElements[0] && gridElements[0].position == '0'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteItem(gridElements[0].id)">Delete item</a>
                                <img :src="getMediaSource(gridElements[0].postmedia.name)" height="50" width="50">
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
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteItem(gridElements[0].id)">Delete item</a>
                                <img :src="getMediaSource(gridElements[0].postmedia.name)" height="50" width="50">
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
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteItem(gridElements[1].id)">Delete item</a>
                                <img :src="getMediaSource(gridElements[1].postmedia.name)" height="50" width="50">
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
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteItem(gridElements[0].id)">Delete item</a>
                                <img :src="getMediaSource(gridElements[0].postmedia.name)" height="50" width="50">
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
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteItem(gridElements[1].id)">Delete item</a>
                                <img :src="getMediaSource(gridElements[1].postmedia.name)" height="50" width="50">
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
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteItem(gridElements[2].id)">Delete item</a>
                                <img :src="getMediaSource(gridElements[2].postmedia.name)" height="50" width="50">
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
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteItem(gridElements[0].id)">Delete item</a>
                                <img :src="getMediaSource(gridElements[0].postmedia.name)" height="50" width="50">
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
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteItem(gridElements[1].id)">Delete item</a>
                                <img :src="getMediaSource(gridElements[1].postmedia.name)" height="50" width="50">
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
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteItem(gridElements[0].id)">Delete item</a>
                                <img :src="getMediaSource(gridElements[0].postmedia.name)" height="50" width="50">
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
                                    <a href="javascript:;" class="btn-trash" @click.prevent="deleteItem(gridElements[1].id)">Delete item</a>
                                    <img :src="getMediaSource(gridElements[1].postmedia.name)" height="50" width="50">
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
                                    <a href="javascript:;" class="btn-trash" @click.prevent="deleteItem(gridElements[2].id)">Delete item</a>
                                    <img :src="getMediaSource(gridElements[2].postmedia.name)" height="50" width="50">
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
    </div>
</template>
<script>
import grid from '@/mixins/grid';

export default {

    data() {
        return {
            gridElements: []
        }
    },

    props: {
        layout: String,
        gridId: Number,
        elements: Array
    },

    mixins: [grid],

    created() {
        let els = [];
        this.$props.elements.forEach(e => {
            els[e.position] = e;
        });

        this.gridElements = els;
    },

    updated() {
        console.log(this.$props);
    },

    methods: {

        addPost(rowId, position) {
            this.$parent.addPost(rowId, position);
        },
        
        addArticle(rowId, position) {
            this.$parent.addArticle(rowId, position);
        },

        deleteItem(id) {
            this.$parent.deleteItem(id);
            // const index = this.gridElements.findIndex(x => x.id === id);            
            // this.gridElements.splice(index, 1);
        },

        getMediaSource(file) {
            return `/media/${file}/sm`;
        },
    }
}
</script>