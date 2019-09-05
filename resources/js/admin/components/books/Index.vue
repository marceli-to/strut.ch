<template>
  <div>
    <page-header />
    <notifications classes="notification" />
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Bücher</h1>
          <router-link :to="{ name: 'book-create' }" class="btn-add"><span>Hinzufügen</span></router-link>
          <div class="list-items" v-if="books.length">
            <draggable 
              v-model="books" 
              @end="updateOrder"
              ghost-class="draggable-ghost"
              tag="div">
              <div :class="[book.publish == 0 ? 'is-disabled' : '', 'list-item', 'list-item--sortable']" v-for="book in books" :key="book.id">
                <div class="list-item-body">
                  <h3>{{ book.title }}</h3>
                </div>
                <div class="list-item-action">
                  <a href="javascript:;" :class="[book.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']" @click.prevent="toggleStatus(book.id)"></a>
                  <router-link :to="{name: 'book-edit', params: { id: book.id }}" class="icon-edit icon-mini"></router-link>
                  <a href="javascript:;" class="icon-copy icon-mini" @click.prevent="clone(book.id)"></a>
                  <a href="javascript:;" class="icon-trash icon-mini" @click.prevent="destroy(book.id)"></a>
                </div>
              </div>
            </draggable>
          </div>
          <div v-else>
            <p>Es sind keine Bücher vorhanden...</p>
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
        books: [],
        debounce: false,
      }
    },

    created() {
        let uri = '/api/books/get';
        this.axios.get(uri).then(response => {
          this.books = response.data.data;
        });
    },

    methods: {

      destroy(id) {
        let uri = `/api/book/destroy/${id}`;
        this.axios.delete(uri).then(response => {
          this.books.splice(this.books.indexOf(id), 1);
          this.$notify({type: 'success', text: 'Eintrag gelöscht'});
        });
      },
      
      clone(id) {
        let uri = `/api/book/clone/${id}`;
        this.axios.get(uri).then(response => {
          this.books.push(response.data);
          this.$notify({type: 'success', text: 'Eintrag kopiert'});
        });        
      },

      toggleStatus(id) {
        let uri = `/api/book/status/${id}`;
        this.axios.get(uri).then(response => {
          const index = this.books.findIndex(x => x.id === id);
          this.books[index].publish = response.data;
          this.$notify({type: 'success', text: 'Status angepasst'});
        });
      },
      
      updateOrder() {
        let books = this.books.map(function(book, index) {
            book.order = index;
            return book;
        });

        if (this.debounce) return;

        this.debounce = setTimeout(function(books) {
          this.debounce = false 
          let uri = `/api/book/order`;
          this.axios.post(uri, {books: books}).then((response) => {
            this.$router.push({name: 'books'});
          });
        }.bind(this, books), 1000);
        this.$notify({type: 'success', text: 'Reihenfolge angepasst'});
      }
    }
  }
</script>