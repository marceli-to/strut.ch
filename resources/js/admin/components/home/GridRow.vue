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
                            <div v-if="elements[0].isMedia">
                                <grid-media :element="elements[0]"></grid-media>
                            </div>
                        </div>
                        <div v-else>
                            <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="false"></buttons-create>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="layout == '2fr'">
                <div class="grid-2fr">
                    <div class="span">
                        <div v-if="elements[0] && elements[0].position == '0'">
                            <grid-media :element="elements[0]"></grid-media>
                        </div>
                        <div v-else>
                            <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="false"></buttons-create>
                        </div>
                    </div>
                    <div class="span">
                        <div v-if="elements[1] && elements[1].position == '1'">
                            <grid-media :element="elements[1]"></grid-media>
                        </div>
                        <div v-else>
                            <buttons-create :gridId="gridId" :gridPosition="1" :showArticle="false"></buttons-create>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="layout == '3fr'">
                <div class="grid-3fr">
                    <div class="span">
                        <div v-if="elements[0] && elements[0].position == '0'">
                            <div v-if="elements[0].isMedia">
                                <grid-media :element="elements[0]"></grid-media>
                            </div>
                            <div v-if="elements[0].isArticle">
                                <grid-article :element="elements[0]"></grid-article>
                            </div>
                        </div>
                        <div v-else>
                            <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="true"></buttons-create>
                        </div>
                    </div>
                    <div class="span">
                        <div v-if="elements[1] && elements[1].position == '1'">
                            <div v-if="elements[1].isMedia">
                                <grid-media :element="elements[1]"></grid-media>
                            </div>
                            <div v-if="elements[1].isArticle">
                                <grid-article :element="elements[1]"></grid-article>
                            </div>
                        </div>
                        <div v-else>
                            <buttons-create :gridId="gridId" :gridPosition="1" :showArticle="true"></buttons-create>
                        </div>
                    </div>
                    <div class="span">
                        <div v-if="elements[2] && elements[2].position == '2'">
                            <div v-if="elements[2].isMedia">
                                <grid-media :element="elements[2]"></grid-media>
                            </div>
                            <div v-if="elements[2].isArticle">
                                <grid-article :element="elements[2]"></grid-article>
                            </div>
                        </div>
                        <div v-else>
                            <buttons-create :gridId="gridId" :gridPosition="2" :showArticle="true"></buttons-create>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="layout == '2fr1fr'">
                <div class="grid-2fr1fr">
                    <div class="span">
                        <div v-if="elements[0] && elements[0].position == '0'">
                            <grid-media :element="elements[0]"></grid-media>
                        </div>
                        <div v-else>
                            <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="false"></buttons-create>
                        </div>
                    </div>
                    <div class="span">
                        <div v-if="elements[1] && elements[1].position == '1'">
                            <div v-if="elements[1].isMedia">
                                <grid-media :element="elements[1]"></grid-media>
                            </div>
                            <div v-if="elements[1].isArticle">
                                <grid-article :element="elements[1]"></grid-article>
                            </div>
                        </div>
                        <div v-else>
                            <buttons-create :gridId="gridId" :gridPosition="1" :showArticle="true"></buttons-create>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="layout == '2fr1fr-stacked'">
                <div class="grid-2fr1fr-stacked">
                    <div class="span">
                        <div v-if="elements[0] && elements[0].position == '0'">
                            <grid-media :element="elements[0]"></grid-media>
                        </div>
                        <div v-else>
                            <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="false"></buttons-create>
                        </div>
                    </div>
                    <div class="span grid-stacked">
                        <div class="span">
                            <div v-if="elements[1] && elements[1].position == '1'">
                                <div v-if="elements[1].isMedia">
                                    <grid-media :element="elements[1]"></grid-media>
                                </div>
                                <div v-if="elements[1].isArticle">
                                    <grid-article :element="elements[1]"></grid-article>
                                </div>
                            </div>
                            <div v-else>
                                <buttons-create :gridId="gridId" :gridPosition="1" :showArticle="true"></buttons-create>
                            </div>
                        </div>
                        <div class="span">
                            <div v-if="elements[2] && elements[2].position == '2'">
                                <div v-if="elements[2].isMedia">
                                    <grid-media :element="elements[2]"></grid-media>
                                </div>
                                <div v-if="elements[2].isArticle">
                                    <grid-article :element="elements[2]"></grid-article>
                                </div>
                            </div>
                            <div v-else>
                                <buttons-create :gridId="gridId" :gridPosition="2" :showArticle="true"></buttons-create>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div :class="[hasOverlay ? 'is-visible': '', 'overlay']">
            <div>
                <a href="javascript:;" @click.prevent="toggleOverlay()" class="icon-close icon-close-overlay"></a>
                <div v-show="showMedia">
                    <grid-media-selector :posts="posts"></grid-media-selector>
                </div>
                <div v-show="showForm">
                    <grid-article-form></grid-article-form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import grid from '@/mixins/grid';
import GridMedia from '@/components/home/GridMedia.vue';
import GridArticle from '@/components/home/GridArticle.vue';
import ButtonsCreate from '@/components/ui/buttons/CreateGridItem.vue';

export default {

    components: {
        GridMedia: GridMedia,
        GridArticle: GridArticle,
        ButtonsCreate: ButtonsCreate
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
                                isArticle: true,
                                articleId: e.news.id,
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
                                isMedia: true,
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