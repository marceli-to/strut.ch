<template>
    <div>
        <figure>
            <a href="javascript:;" class="btn-trash" @click.prevent="deletePostElement(element.id, element.postId)">Delete</a>
            <img :src="getPreviewImage(element.image)" height="50" width="50">
            <figcaption>
                <strong>{{element.title}}</strong>
            </figcaption>
        </figure>
    </div>
</template>
<script>
import grid from '@/mixins/grid';

export default {

    props: {
        element: Object,
    },

    mixins: [grid],

    created() {
    },

    methods: {
        deletePostElement(elementId, postId) {
            this.$parent.deletePostElement(elementId, postId);
        }
    }
}
</script>