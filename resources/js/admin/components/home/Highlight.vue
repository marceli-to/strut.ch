<template>
  <div>
    <loading :active.sync="isLoading" :is-full-page="fullPage" :height="30" :width="30"></loading>
    <div class="grids">
      <button-create :gridId="gridId" :gridPosition="0"></button-create>
      <div class="grid-1fr">
        <div class="span">
          <div class="grid-1fr-highlight">
            <div class="span" v-for="element in elements" :key="element.id">
              <grid-media :element="element"></grid-media>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div :class="[hasOverlay ? 'is-visible': '', 'overlay']">
      <div>
        <a
          href="javascript:;"
          @click.prevent="toggleOverlay()"
          class="icon-close icon-close-overlay"
        ></a>
        <div v-show="showMedia">
          <grid-media-selector :projects="projects"></grid-media-selector>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import grid from "@/mixins/grid";
import GridMedia from "@/components/home/Media.vue";
import ButtonCreate from "@/components/ui/buttons/CreateHighlightGridItem.vue";

export default {
  components: {
    GridMedia: GridMedia,
    ButtonCreate: ButtonCreate
  },

  props: {
    gridId: Number
  },

  mixins: [grid],

  created() {
    this.fetchElements();
  },

  methods: {
    fetchElements() {
      let uri = `/api/home/grid/element/get/${this.$props.gridId}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        let els = [];
        response.data.data.forEach(e => {
          let img = e.projectimage;
          if (img) {
            let el = {
              id: e.id,
              position: e.position,
              isMedia: true,
              projectId: img.project.id || null,
              image: img.name || null,
              caption: `${img.project.name.de}, ${img.project.location.de} (${img.project.year})`,
            };
            els.push(el);
          }
        });

        this.elements = els;
        this.isLoading = false;
      });
    }
  }
};
</script>