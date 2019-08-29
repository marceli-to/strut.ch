<template>
  <div>
    <page-header />
    <post-form type="create"></post-form>
  </div>
</template>
<script>
import PageHeader from '@/layout/PageHeader.vue';
import PostForm from '@/components/posts/form.vue';
  export default {
    components: {
      PageHeader: PageHeader,
      PostForm: PostForm
    }
  }
</script>