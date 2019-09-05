<template>
  <div>
    <page-header />
    <lecture-form type="create"></lecture-form>
  </div>
</template>
<script>
import PageHeader from '@/layout/PageHeader.vue';
import LectureForm from '@/components/lecture/form.vue';
  export default {
    components: {
      PageHeader: PageHeader,
      LectureForm: LectureForm
    }
  }
</script>