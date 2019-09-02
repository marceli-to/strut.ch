<template>
  <div>
    <page-header />
    <job-form type="edit"></job-form>
  </div>
</template>
<script>
import PageHeader from '@/layout/PageHeader.vue';
import TeamForm from '@/components/team/form.vue';
export default {
  components: {
    PageHeader: PageHeader,
    TeamForm: TeamForm
  }
}
</script>