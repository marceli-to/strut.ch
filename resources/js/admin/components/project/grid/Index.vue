<template>
  <div>
    <page-header/>
    <notifications classes="notification"/>
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Projekt Layout</h1>
          <grid-selector></grid-selector>
          <div class="grid-rows">
            <div class="grid-row" v-for="grid in grids" :key="grid.id">
              <a
                href="javascript:;"
                class="btn-trash"
                @click.prevent="destroy(grid.id)"
              >Zeile löschen</a>
              <grid-row :layout="grid.layout.key" :gridId="grid.id" :projectId="projectId"></grid-row>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
<script>
import PageHeader from "@/layout/PageHeader.vue";
import GridRow from "@/components/project/grid/Row.vue";
import GridSelector from "@/components/project/grid/Selector.vue";

export default {
  components: {
    PageHeader: PageHeader,
    GridRow: GridRow,
    GridSelector: GridSelector
  },

  data() {
    return {
      grids: [],
      projectId: null
    };
  },

  created() {
    this.projectId = parseInt(this.$route.params.id);
    this.fetch();
  },

  methods: {

    fetch() {
      let uri = `/api/project/grids/${this.projectId}`;
      this.axios.get(uri).then(response => {
        this.grids = response.data.data;
      });
    },

    store(gridId) {
      let uri = `/api/project/grid/store/${this.projectId}/${gridId}`;
      this.axios.get(uri).then(response => {
        this.fetch();
      });
    },

    destroy(gridId) {
      let uri = `/api/project/grid/delete/${gridId}`;
      this.axios.delete(uri).then(response => {
        const index = this.grids.findIndex(x => x.id === gridId);
        this.grids.splice(index, 1);
        this.$notify({type: "success", text: "Zeile gelöscht!"});
      });
    }
  }
};
</script>

