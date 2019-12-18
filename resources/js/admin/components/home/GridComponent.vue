<template>
    <div>
        <loading :active.sync="isLoading" 
                 :is-full-page="fullPage" 
                 :height="30" 
                 :width="30">
        </loading>
        <div class="grids">
            <div v-if="layout == '1fr'">
                <div class="grid-1fr">
                    <div class="span">
                        <div v-if="elements[0] && elements[0].position == '0'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(elements[0].id, elements[0].postmedia.post.id)">Delete</a>
                                <img :src="getPreviewImage(elements[0].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{elements[0].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addNews(gridId,0);">Add news</a>&nbsp;
                            <a href="javascript:;" class="btn-add-media" @click.prevent="addPost(gridId,0);">Add post</a>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="layout == '2fr'">
                <div class="grid-2fr">
                    <div class="span">
                        <div v-if="elements[0] && elements[0].position == '0'">
                            <grid-post-item :element="elements[0]"></grid-post-item>
                        </div>
                        <!-- <div v-if="elements[0] && elements[0].position == '0'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(elements[0].id, elements[0].postmedia.post.id)">Delete</a>
                                <img :src="getPreviewImage(elements[0].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{elements[0].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div> -->
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addNews(gridId,0);">Add news</a>&nbsp;
                            <a href="javascript:;" class="btn-add-media" @click.prevent="addPost(gridId,0);">Add post</a>
                        </div>
                    </div>
                    <div class="span">
                        <div v-if="elements[1] && elements[1].position == '1'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(elements[1].id, elements[1].postmedia.post.id)">Delete</a>
                                <img :src="getPreviewImage(elements[1].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{elements[1].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addNews(gridId,1);">Add news</a>&nbsp;
                            <a href="javascript:;" class="btn-add-media" @click.prevent="addPost(gridId,1);">Add post</a>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="layout == '3fr'">
                <div class="grid-3fr">
                    <div class="span">
                        <div v-if="elements[0] && elements[0].position == '0'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(elements[0].id, elements[0].postmedia.post.id)">Delete</a>
                                <img :src="getPreviewImage(elements[0].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{elements[0].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addNews(gridId,0);">Add news</a>&nbsp;
                            <a href="javascript:;" class="btn-add-media" @click.prevent="addPost(gridId,0);">Add post</a>
                        </div>
                    </div>
                    <div class="span">
                        <div v-if="elements[1] && elements[1].position == '1'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(elements[1].id, elements[1].postmedia.post.id)">Delete</a>
                                <img :src="getPreviewImage(elements[1].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{elements[1].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addNews(gridId,1);">Add news</a>&nbsp;
                            <a href="javascript:;" class="btn-add-media" @click.prevent="addPost(gridId,1);">Add post</a>
                        </div>
                    </div>
                    <div class="span">
                        <div v-if="elements[2] && elements[2].position == '2'">
                            <figure>
                                <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(elements[2].id, elements[2].postmedia.post.id)">Delete</a>
                                <img :src="getPreviewImage(elements[2].postmedia.name)" height="50" width="50">
                                <figcaption>
                                   <strong>{{elements[2].postmedia.post.title}}</strong>
                                </figcaption>
                            </figure>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addNews(gridId,2);">Add news</a>&nbsp;
                            <a href="javascript:;" class="btn-add-media" @click.prevent="addPost(gridId,2);">Add post</a>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="layout == '2fr1fr'">
                <div class="grid-2fr1fr">
                    <div class="span">
                        <div v-if="elements[0] && elements[0].position == '0'">
                            <div v-if="elements[0].post_media_id">
                                <figure>
                                    <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(elements[0].id, elements[0].postmedia.post.id)">Delete</a>
                                    <img :src="getPreviewImage(elements[0].postmedia.name)" height="50" width="50">
                                    <figcaption>
                                    <strong>{{elements[0].postmedia.post.title}}</strong>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addNews(gridId,0);">Add news</a>&nbsp;
                            <a href="javascript:;" class="btn-add-media" @click.prevent="addPost(gridId,0);">Add post</a>
                        </div>
                    </div>
                    <div class="span">
                        <div v-if="elements[1] && elements[1].position == '1'">
                            <div v-if="elements[1].post_media_id">
                                <figure>
                                    <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(elements[1].id, elements[1].postmedia.post.id)">Delete</a>
                                    <img :src="getPreviewImage(elements[1].postmedia.name)" height="50" width="50">
                                    <figcaption>
                                    <strong>{{elements[1].postmedia.post.title}}</strong>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addNews(gridId,1);">Add news</a>&nbsp;
                            <a href="javascript:;" class="btn-add-media" @click.prevent="addPost(gridId,1);">Add post</a>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="layout == '2fr1fr-stacked'">
                <div class="grid-2fr1fr-stacked">
                    <div class="span">
                        <div v-if="elements[0] && elements[0].position == '0'">
                            <div v-if="elements[0].isPost">
                                <grid-post-item :element="elements[0]"></grid-post-item>
                            </div>
                        </div>
                        <div v-else>
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addNews(gridId,0);">Add news</a>&nbsp;
                            <a href="javascript:;" class="btn-add-media" @click.prevent="addPost(gridId,0);">Add post</a>
                        </div>
                    </div>
                    <div class="span grid-stacked">
                        <div class="span">
                            <div v-if="elements[1] && elements[1].position == '1'">
                                <div v-if="elements[1].isPost">
                                    <grid-post-item :element="elements[1]"></grid-post-item>
                                </div>
                                <div v-if="elements[1].isNews">
                                    <div>{{elements[1].date}}</div>
                                    <div><strong>{{elements[1].title}}</strong></div>
                                    <div>{{elements[1].text}}</div>
                                </div>
                            </div>
                            <div v-else>
                                <a href="javascript:;" class="btn-add-article" @click.prevent="addNews(gridId,1);">Add news</a>&nbsp;
                                <a href="javascript:;" class="btn-add-media" @click.prevent="addPost(gridId,1);">Add post</a>
                            </div>
                        </div>
                        <div class="span">
                            <div v-if="elements[2] && elements[2].position == '2'">
                                <div v-if="elements[2].isPost">
                                    <grid-post-item :element="elements[2]"></grid-post-item>
                                </div>
                                <div v-if="elements[2].isNews">
                                    <div>{{elements[2].date}}</div>
                                    <div><strong>{{elements[2].title}}</strong></div>
                                    <div>{{elements[2].text}}</div>
                                </div>
                            </div>
                            <div v-else>
                                <a href="javascript:;" class="btn-add-article" @click.prevent="addNews(gridId,2);">Add news</a>&nbsp;
                                <a href="javascript:;" class="btn-add-media" @click.prevent="addPost(gridId,2);">Add post</a>
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
                    <grid-post :posts="posts"></grid-post>
                </div>
                <div v-show="displayNewsForm">
                    <grid-news></grid-news>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import grid from '@/mixins/grid';
import GridPostItemComponent from '@/components/home/GridPostItemComponent.vue';

export default {

    components: {
        gridPostItem: GridPostItemComponent,
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

                        if (e.news_id) {
                            let el = {
                                id: e.id,
                                position: e.position,
                                isNews: true,
                                date: e.news.date.de,
                                title: e.news.title.de,
                                text: e.news.text.de,
                                image: null
                            };
                            els[e.position] = el;
                        }
        
                        if (e.post_media_id) {
                            let el = {
                                id: e.id,
                                position: e.position,
                                isPost: true,
                                postId: e.postmedia.post.id,
                                image: e.postmedia.name,
                                title: e.postmedia.post.title
                            }
                            els[e.position] = el;
                        }
                    });
                    
                    this.elements = els;
                }
                this.isLoading = false;
            });
        },
    }
}
</script>