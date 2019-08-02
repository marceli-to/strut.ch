<template>
    <div>
        <figure>
            <a href="javascript:;" class="btn-trash" @click.prevent="deletePostElement(element.id, element.postmedia.post.id)">Delete</a>
            <img :src="getPreviewImage(element.postmedia.name)" height="50" width="50">
            <figcaption>
                <strong>{{element.postmedia.post.title}}</strong>
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
        console.log(this.$props.element);
    },

    methods: {
        deletePostElement(elementId, postId) {
            this.$parent.deletePostElement(elementId, postId);
        }
    }
}
</script>