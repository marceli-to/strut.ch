// IndexComponent.vue
<template>
  <div>
    <page-header/>
    <notifications classes="notification"/>
    <div class="progress">
      <div :class="isLoading ? 'is-loading progress__bar': 'progress__bar'"></div>
    </div>
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
              <div class="fs-xs">
                Die Seite hat nicht publizierte Änderungen. Damit diese auf der Webseite sichtbar werden, muss das aktuelle Layout publiziert werden.
              </div>
              <div>
                <button
                  type="submit"
                  class="btn-secondary"
                  @click.prevent="publish()"
                >Änderungen publizieren</button>
              </div>
              <div>
                <button
                  type="submit"
                  class="btn-primary"
                  @click.prevent="restore()"
                  >Änderungen verwerfen</button>
              </div>

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
      isLoading: false
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
              store.commit("gridChanged");
            }
          });
        });
        this.isLoading = false;
      });
    },

    publish() {
      if (
        confirm(
          "Bitte publizieren bestätigen."
        )
      ) {
        this.isLoading = true;
        this.axios.get("/api/home/grids/deploy").then(response => {
          this.$notify({ type: "success", text: "Seite publiziert!" });
          store.commit("gridDeployed");
          this.isLoading = false;
        });
      }
    },

    restore() {
      if (
        confirm(
          "Bitte zurücksetzen bestätigen."
        )
      ) {
        this.isLoading = true;
        this.axios.get("/api/home/grids/reset").then(response => {
          this.$notify({type: "success", text: "Seite publiziert!"});
          store.commit("gridDeployed");
          this.isLoading = false;
          this.$router.go();
        });
      }
    },

    addRow(id) {
      let uri = `/api/home/grid/store/${id}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        this.grids = response.data.data;
        this.$notify({ type: "success", text: "Zeile hinzugefügt!" });
        this.fetch();
      });
    },

    deleteRow(id, event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/home/grid/delete/${id}`;
        this.isLoading = true;
        this.axios.delete(uri).then(response => {
          let row = event.target.parentNode,
            self = this;
          row.classList.add("fade-out");
          setTimeout(function() {
            const index = self.grids.findIndex(x => x.id === id);
            self.grids.splice(index, 1);
            self.$notify({ type: "success", text: "Zeile gelöscht!" });
            self.isLoading = false;
          }, 200);
        });
      }
    }
  },

  computed: {
    hasChanges: function() {
      return store.state.hasChanges;
    }
  }
};
</script>

