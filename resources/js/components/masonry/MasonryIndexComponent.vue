// IndexComponent.vue
<template>
    <div>
        <page-header />
        <div class="container">
            <main class="content" role="main">
                <div>
                    <h1>Masonry</h1>
                    <div class="select-wrapper">
                        <select @change="addRow($event)">
                            <option value="null">Choose layout...</option>
                            <option value="1">1fr</option>
                            <option value="2">2fr</option>
                            <option value="3">3fr</option>
                            <option value="4">1fr2fr</option>
                            <option value="5">1fr2fr-stacked</option>
                        </select>
                    </div>
                    <div class="masonry-rows">
                        <div class="masonry-row" v-for="row in masonryRows" :key="row.id">
                            <p><a href="javascript:;" @click.prevent="deleteRow(row.id)">Delete row</a></p>
                            <masonry :layout="row.layout.key" :rowId="row.id" />
                        </div>
                    </div>

                    <br><br>

                    <div>
                        <div>
                            Post<br>Article
                        </div>
                        <div>
                            <div v-for="post in posts" :key="post.id">
                                <strong>{{ post.title }}</strong>&nbsp;&nbsp;<a href="javascript:;" @click.prevent="selectPost(post.id)">Select</a>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</template>

<script>
import PageHeaderComponent from '../layout/PageHeaderComponent.vue';
import Masonry from './layouts/masonry.vue';
export default {
    components: {
        pageHeader: PageHeaderComponent,
        masonry: Masonry
    },

    data() {
        return {
            masonryRows: [],
            posts: [],
        }
    },

    created() {
        this.axios.get('/api/masonry').then(response => {
            this.masonryRows = response.data.data;
        });

        this.axios.get('/api/posts').then(response => {
          this.posts = response.data.data;
        });
    },

    methods: {
        addRow(event) {
            if (event.target.value != 'null') {
                let uri = `/api/masonry/addRow/${event.target.value}`;
                this.axios.get(uri).then((response) => {
                    this.masonryRows = response.data.data;
                });
            }
        },

        deleteRow(id) {
            let uri = `/api/masonry/deleteRow/${id}`;
            this.axios.delete(uri).then(response => {
                const index = this.masonryRows.findIndex(x => x.id === id);
                this.masonryRows.splice(index, 1);
            });
        },

        addContent(rowId, position) {
            console.log(rowId);
            console.log(position);
        }
    }
}
</script>
<style scoped>
.select-wrapper {
    margin-bottom: 20px;
    max-width: 200px;
}

p {
    margin: 0 0 10px 0;
}
</style>

