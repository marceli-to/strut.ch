// IndexComponent.vue
<template>
  <div>
    <page-header/>
    <notifications classes="notification"/>
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Highlights</h1>
          <div class="grid-rows">
            <div class="grid-row grid-row--highlight">
              <grid-highlight :gridId="1"></grid-highlight>
            </div>
          </div>
          <h1>Bauten</h1>
          <grid-selector></grid-selector>
          <div class="grid-rows">
            <div class="grid-row" v-for="grid in grids" :key="grid.id">
              <a
                href="javascript:;"
                class="btn-trash"
                @click.prevent="deleteGrid(grid.id)"
              >Zeile löschen</a>
              <grid-row :layout="grid.layout.key" :gridId="grid.id"></grid-row>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import PageHeader from "@/layout/PageHeader.vue";
import GridRow from "@/components/home/Row.vue";
import GridHighlight from "@/components/home/Highlight.vue";
import GridSelector from "@/components/home/Selector.vue";

export default {
  components: {
    PageHeader: PageHeader,
    GridRow: GridRow,
    GridHighlight: GridHighlight,
    GridSelector: GridSelector
  },

  data() {
    return {
      grids: []
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      this.axios.get('/api/home/grids').then(response => {
        this.grids = response.data.data;
      });
    },

    addGrid(gridId) {
      let uri = `/api/home/grid/store/${gridId}`;
      this.axios.get(uri).then(response => {
        this.grids = response.data.data;
        this.$notify({type: "success", text: "Zeile hinzugefügt!"});
        this.fetch();
      });
    },

    deleteGrid(id) {
      let uri = `/api/home/grid/delete/${id}`;
      this.axios.delete(uri).then(response => {
        const index = this.grids.findIndex(x => x.id === id);
        this.grids.splice(index, 1);
        this.$notify({type: "success", text: "Zeile gelöscht!"});
      });
    }
  }
};
</script>

