<template>
  <div>
    <page-header />
    <book-form type="create"></book-form>
  </div>
</template>
<script>
import PageHeader from '@/layout/PageHeader.vue';
import BookForm from '@/components/books/form.vue';
  export default {
    components: {
      PageHeader: PageHeader,
      BookForm: BookForm
    }
  }
</script>