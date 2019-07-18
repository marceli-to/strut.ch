<template>
    <div>
        <div>
            <div v-if="layout == '1fr'">
                <div class="masonry-grid-1fr">
                    <div class="span">
                        <a href="javascript:;" @click.prevent="addContent(rowId, 1);">Add content</a>
                    </div>
                </div>
            </div>
            <div v-if="layout == '2fr'">
                <div class="masonry-grid-2fr">
                    <div class="span">
                        <a href="javascript:;" @click.prevent="addContent(rowId, 1);">Add content</a>
                    </div>
                    <div class="span">
                        <a href="javascript:;" @click.prevent="addContent(rowId, 2);">Add content</a>
                    </div>
                </div>
            </div>
            <div v-if="layout == '3fr'">
                <div class="masonry-grid-3fr">
                    <div class="span">
                        <a href="javascript:;" @click.prevent="addContent(rowId, 1);">Add content</a>
                    </div>
                    <div class="span">
                        <a href="javascript:;" @click.prevent="addContent(rowId, 2);">Add content</a>
                    </div>
                    <div class="span">
                        <a href="javascript:;" @click.prevent="addContent(rowId, 3);">Add content</a>
                    </div>
                </div>
            </div>
            <div v-if="layout == '1fr2fr'">
                <div class="masonry-grid-1fr2fr">
                    <div class="span">
                        <a href="javascript:;" @click.prevent="addContent(rowId, 1);">Add content</a>
                    </div>
                    <div class="span">
                        <a href="javascript:;" @click.prevent="addContent(rowId, 2);">Add content</a>
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
        addContent(rowId, position){
            this.$parent.addContent(rowId, position);
        }
    }
}
</script>
<style scoped>
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

.masonry-grid-1fr2fr {
    display: grid;
    grid-template-columns: 1fr 2fr;
    grid-gap: 20px;
}

.span {
    border: 2px dashed #999;
    display: flex;
    align-items: center;
    justify-content:center;
    min-height: 100px;
}
</style>
