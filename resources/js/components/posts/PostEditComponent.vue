// PostEditComponent.vue
<template>
  <div>
    <page-header />
    <post-form type="edit"></post-form>
  </div>
</template>
<script>
import PageHeaderComponent from '../layout/PageHeaderComponent.vue';
import PostFormComponent from './partials/PostFormComponent.vue';
  export default {
    components: {
      pageHeader: PageHeaderComponent,
      postForm: PostFormComponent
    }
  }
</script>