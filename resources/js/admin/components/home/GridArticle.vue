<template>
    <div>
        <a href="javascript:;" class="btn-trash" @click.prevent="deleteArticle(element.id, element.articleId)">Delete</a>
        <div>{{element.date}}</div>
        <div><strong>{{element.title}}</strong></div>
        <div>{{element.text}}</div>
    </div>
</template>
<script>
import grid from '@/mixins/grid';

export default {

    props: {
        element: Object,
    },

    mixins: [grid],

    methods: {
        deleteArticle(elementId, articleId) {
            this.$parent.deleteArticle(elementId, articleId);
        }
    }
}
</script>