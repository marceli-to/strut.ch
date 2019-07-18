// PostCreateComponent.vue
<template>
  <div>
    <page-header />
    <post-form type="create"></post-form>
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