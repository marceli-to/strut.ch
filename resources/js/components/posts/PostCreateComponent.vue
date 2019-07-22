// PostCreateComponent.vue
<template>
  <div>
    <page-header />
    <post-form type="create"></post-form>
  </div>
</template>
<script>
import PageHeaderComponent from '@/components/layout/PageHeaderComponent.vue';
import PostFormComponent from '@/components/posts/partials/PostFormComponent.vue';
  export default {
    components: {
      pageHeader: PageHeaderComponent,
      postForm: PostFormComponent
    }
  }
</script>