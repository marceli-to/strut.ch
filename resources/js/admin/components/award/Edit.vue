<template>
  <div>
    <page-header />
    <award-form type="edit"></award-form>
  </div>
</template>
<script>
import PageHeader from '@/layout/PageHeader.vue';
import AwardForm from '@/components/award/form.vue';
export default {
  components: {
    PageHeader: PageHeader,
    AwardForm: AwardForm
  }
}
</script>