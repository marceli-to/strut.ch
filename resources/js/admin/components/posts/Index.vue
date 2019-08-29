<template>
  <div>
    <page-header />
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Posts</h1>
          <router-link :to="{ name: 'post-create' }" class="btn-add"><span>Create post</span></router-link>
          <div class="list-items">
            <draggable 
              v-model="posts" 
              @end="updateOrder"
              ghost-class="ghost"
              tag="div">
              <div class="list-item list-item--sortable" v-for="post in posts" :key="post.id">
                <div class="list-item-body">
                  <h3>{{ post.title }}</h3>
                  {{ post.body }}
                </div>
                <div class="list-item-action">
                  <router-link :to="{name: 'post-edit', params: { id: post.id }}" class="icon-edit icon-mini"></router-link>
                  <a href="javascript:;" class="icon-trash icon-mini" @click.prevent="deletePost(post.id)"></a>
                  <a href="javascript:;" :class="[post.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']" @click.prevent="toggleStatus(post.id)"></a>
                </div>
              </div>
            </draggable>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
  import PageHeader from '@/layout/PageHeader.vue';
  import draggable from 'vuedraggable';
  export default {
    components: {
      draggable,
      PageHeader: PageHeader,
    },

    data() {
      return {
        posts: [],
        debounce: false,
      }
    },

    created() {
        let uri = '/api/posts/get';
        this.axios.get(uri).then(response => {
          this.posts = response.data.data;
        });
    },

    methods: {

      deletePost(id) {
        let uri = `/api/post/delete/${id}`;
        this.axios.delete(uri).then(response => {
          this.posts.splice(this.posts.indexOf(id), 1);
        });
      },

      toggleStatus(id) {
        let uri = `/api/post/status/${id}`;
        this.axios.get(uri).then(response => {
          const index = this.posts.findIndex(x => x.id === id);
          this.posts[index].publish = response.data;
        });
      },
      
      updateOrder() {
        let posts = this.posts.map(function(post, index) {
            post.order = index;
            return post;
        });

        if (this.debounce) return;

        this.debounce = setTimeout(function(posts) {
          this.debounce = false 
          let uri = `/api/post/order`;
          this.axios.post(uri, {posts: posts}).then((response) => {
            this.$router.push({name: 'posts'});
          });
        }.bind(this, posts), 1000)
      }
    }
  }
</script>
<style scoped>
.ghost {
  opacity: .6;
  background: #f9f9f9;
  border: 2px dashed #222222;
  padding: 5px;
}
</style>