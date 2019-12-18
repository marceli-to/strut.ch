<template>
  <div>
    <page-header />
    <press-form type="edit"></press-form>
  </div>
</template>
<script>
import PageHeader from '@/layout/PageHeader.vue';
import PressForm from '@/components/press/form.vue';
export default {
  components: {
    PageHeader: PageHeader,
    PressForm: PressForm
  }
}
</script>