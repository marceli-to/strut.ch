<template>
    <div>
        <loading :active.sync="isLoading" :is-full-page="fullPage" :height="30" :width="30"></loading>
        <div class="grids">
            <button-create :gridId="gridId" :gridPosition="0"></button-create>
            <div class="grid-1fr">
                <div class="span">
                    <div class="grid-1fr-highlight">
                        <div class="span" v-for="element in elements" :key="element.id">
                            <grid-media :element="element"></grid-media>
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
            </div>
        </div>
    </div>
</template>
<script>
import grid from '@/mixins/grid';
import GridMedia from '@/components/home/GridMedia.vue';
import ButtonCreate from '@/components/ui/buttons/CreateHighlightGridItem.vue';

export default {
    components: {
        GridMedia: GridMedia,
        ButtonCreate: ButtonCreate
    },

    props: {
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
                response.data.data.forEach(e => {
                    let el = {
                        id: e.id,
                        position: e.position,
                        isMedia: true,
                        postId: e.postmedia.post.id,
                        image: e.postmedia.name,
                        title: e.postmedia.post.title
                    }
                    els.push(el);
                });
                    
                this.elements = els;
                this.isLoading = false;
            });
        },
    }
}
</script>