<template>
    <div>
        <div>
            <div v-if="layout == '1fr'">
                <div class="masonry-grid-1fr">
                    <div class="span">
                        <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(rowId, 1);">Add teaser</a>&nbsp;
                        <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(rowId, 1);">Add post</a>
                    </div>
                </div>
            </div>
            <div v-if="layout == '2fr'">
                <div class="masonry-grid-2fr">
                    <div class="span">
                        <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(rowId, 1);">Add teaser</a>&nbsp;
                        <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(rowId, 1);">Add post</a>
                    </div>
                    <div class="span">
                        <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(rowId, 2);">Add teaser</a>&nbsp;
                        <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(rowId, 2);">Add post</a>
                    </div>
                </div>
            </div>
            <div v-if="layout == '3fr'">
                <div class="masonry-grid-3fr">
                    <div class="span">
                        <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(rowId, 1);">Add teaser</a>&nbsp;
                        <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(rowId, 1);">Add post</a>
                    </div>
                    <div class="span">
                        <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(rowId, 2);">Add teaser</a>&nbsp;
                        <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(rowId, 2);">Add post</a>
                    </div>
                    <div class="span">
                        <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(rowId, 3);">Add teaser</a>&nbsp;
                        <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(rowId, 3);">Add post</a>
                    </div>
                </div>
            </div>
            <div v-if="layout == '2fr1fr'">
                <div class="masonry-grid-2fr1fr">
                    <div class="span">
                        <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(rowId, 1);">Add teaser</a>&nbsp;
                        <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(rowId, 1);">Add post</a>
                    </div>
                    <div class="span">
                        <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(rowId, 2);">Add teaser</a>&nbsp;
                        <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(rowId, 2);">Add post</a>
                    </div>
                </div>
            </div>
            <div v-if="layout == '2fr1fr-stacked'">
                <div class="masonry-grid-2fr1fr-stacked">
                    <div class="span">
                        <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(rowId, 1);">Add teaser</a>&nbsp;
                        <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(rowId, 1);">Add post</a>
                    </div>
                    <div class="span masonry-grid-stacked">
                        <div class="span">
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(rowId, 2);">Add teaser</a>&nbsp;
                            <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(rowId, 2);">Add post</a>
                        </div>
                        <div class="span">
                            <a href="javascript:;" class="btn-add-article" @click.prevent="addArticle(rowId, 3);">Add teaser</a>&nbsp;
                            <a href="javascript:;" class="btn-add-post" @click.prevent="addPost(rowId, 3);">Add post</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        layout: String,
        rowId: Number
    },
    methods: {
        addPost(rowId, position) {
            this.$parent.addPost(rowId, position);
        },
        addArticle(rowId, position) {
            this.$parent.addArticle(rowId, position);
        }
    }
}
</script>
<style scoped>

.span {
    border: 2px dashed #999;
    display: flex;
    align-items: center;
    justify-content:center;
    min-height: 200px;
}

.masonry-grid-1fr {
    display: grid;
    grid-template-columns: 1fr;
}

.masonry-grid-2fr {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 20px;
}

.masonry-grid-3fr {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-gap: 20px;
}

.masonry-grid-2fr1fr {
    display: grid;
    grid-template-columns: 2fr 1fr;
    grid-gap: 20px;
}

.masonry-grid-2fr1fr-stacked {
    display: grid;
    grid-template-columns: 2fr 1fr;
    grid-gap: 20px;
}

.masonry-grid-2fr1fr-stacked .span {
    min-height: 200px;
}

.masonry-grid-stacked {
    display: grid;
    grid-gap: 10px;
    grid-template-columns: 1fr;
    padding: 10px;
}

.masonry-grid-stacked .span {
    min-height: 100px;
    width: 100%;
}
</style>
