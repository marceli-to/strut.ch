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
                @click.prevent="deleteRow(grid.id, $event)"
              >Zeile löschen</a>
              <grid-row :layout="grid.layout.key" :gridId="grid.id"></grid-row>
            </div>
          </div>

          <footer :class="[hasChanges ? '' : 'is-hidden', 'form-footer is-warning']">
            <div>
              <span style="max-width: 50%">Das Layout hat nicht publizierte Anpassungen. Damit diese auf der Webseite sichtbar werden, muss das aktuelle Layout publiziert werden.</span>
              <button
                type="submit"
                class="btn-secondary"
                @click.prevent="publish()"
              >Änderungen publizieren</button>
            </div>
          </footer>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import store from "@/store";
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
      grids: [],
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      let self = this;
      this.axios.get("/api/home/grids").then(response => {
        this.grids = response.data.data;
        response.data.data.forEach(function(row) {
          row.elements.forEach(function(el) {
            if (
              (el.environment == "production" && el.action == "delete") ||
              el.environment == "development"
            ) {
              store.commit('gridChanged');
            }
          });
        });
      });
    },

    publish() {
      if (
        confirm(
          "Mit dieser Aktion wird die bestehende Homepage angepasst. Bitte publizieren bestätigen."
        )
      ) {
        this.axios.get("/api/home/grids/deploy").then(response => {
          this.$notify({ type: "success", text: "Homepage wurde publiziert!" });
          store.commit('gridDeployed');
        });
      }
    },

    addRow(id) {
      let uri = `/api/home/grid/store/${id}`;
      this.axios.get(uri).then(response => {
        this.grids = response.data.data;
        this.$notify({ type: "success", text: "Zeile hinzugefügt!" });
        this.fetch();
      });
    },

    deleteRow(id, event) {
      let uri = `/api/home/grid/delete/${id}`;
      this.axios.delete(uri).then(response => {
        let row = event.target.parentNode,
          self = this;
        row.classList.add("fade-out");
        setTimeout(function() {
          const index = self.grids.findIndex(x => x.id === id);
          self.grids.splice(index, 1);
          self.$notify({ type: "success", text: "Zeile gelöscht!" });
        }, 200);
      });
    }
  },

  computed: {
    hasChanges: function() {
      return store.state.hasChanges
    }
  }

};
</script>

