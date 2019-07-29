<template>
    <div>
        <h2>Select a post</h2>
        <div class="posts">
            <div class="post" v-for="post in posts" :key="post.id">
                <div class="post-text">
                    <strong>{{ post.title }}</strong><br>{{ post.body | truncate(20, '...') }}
                </div>
                <div class="post-media">
                    <figure v-for="media in post.media" :key="media.id">
                        <a href="" @click.prevent="insertPost(media.id)">
                            <img :src="getThumbnailImage(media.name)" height="50" width="50">
                        </a>
                    </figure>
                </div>
            </div>
        </div>        
    </div>
</template>
<script>
export default {
    components: {
    },

    data() {
        return {
            posts: [],
        }
    },

    created() {
        this.axios.get('/api/posts').then(response => {
            this.posts = response.data.data;
        });
    },

    methods: {

        insertPost(id) {
            this.$parent.insertPost(id)
        },

        getThumbnailImage(file) {
            return `/media/thumbnail/${file}`;
        },
    }
}
</script>