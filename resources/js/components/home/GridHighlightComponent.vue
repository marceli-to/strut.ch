<template>
    <div>
        <loading :active.sync="isLoading" :is-full-page="fullPage" :height="30" :width="30"></loading>
        <div class="grids">
            <a href="javascript:;" class="btn-add-media-highlight" @click.prevent="addPost(gridId,0);">Add highlight</a>
            <div class="grid-1fr">
                <div class="span">
                    <div class="grid-1fr-highlight">
                        <figure class="span" v-for="element in gridElements" :key="element.id">
                            <a href="javascript:;" class="btn-trash" @click.prevent="deleteElement(element.id, element.postmedia.post.id)">Delete</a>
                            <img :src="getPreviewImage(element.postmedia.name)" height="50" width="50">
                            <figcaption>
                                <strong>{{element.postmedia.post.title}}</strong>
                            </figcaption>
                        </figure>
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
            </div>
        </div>
    </div>
</template>
<script>
import grid from '@/mixins/grid';

export default {

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
                this.gridElements = response.data.data;
                this.isLoading = false;
            });
        },
    }
}
</script>