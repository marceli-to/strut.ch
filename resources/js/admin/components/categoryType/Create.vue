<template>
  <div>
    <page-header />
    <category-type-form type="create"></category-type-form>
  </div>
</template>
<script>
import PageHeader from '@/layout/PageHeader.vue';
import CategoryTypeForm from '@/components/categoryType/form.vue';
  export default {
    components: {
      PageHeader: PageHeader,
      CategoryTypeForm: CategoryTypeForm
    }
  }
</script>