<template>
  <div>
    <page-header />
    <category-form type="edit"></category-form>
  </div>
</template>
<script>
import PageHeader from '@/layout/PageHeader.vue';
import CategoryForm from '@/components/category/form.vue';
  export default {
    components: {
      PageHeader: PageHeader,
      CategoryForm: CategoryForm
    }
  }
</script>