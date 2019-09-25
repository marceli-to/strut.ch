<template>
  <div>
    <div class="progress">
      <div :class="isLoading ? 'is-loading progress__bar': 'progress__bar'"></div>
    </div>
    <div class="grids">
      <div v-if="layout == '2fr'">
        <div class="grid-2fr">
          <div class="span">
            <div v-if="elements[0] && elements[0].position == '0'">
              <grid-media :element="elements[0]"></grid-media>
            </div>
            <div v-else>
              <button-add :gridId="gridId" :gridPosition="0"></button-add>
            </div>
          </div>
          <div class="span">
            <div v-if="elements[1] && elements[1].position == '1'">
              <grid-media :element="elements[1]"></grid-media>
            </div>
            <div v-else>
              <button-add :gridId="gridId" :gridPosition="1"></button-add>
            </div>
          </div>
        </div>
      </div>
      <div v-if="layout == '1fr_stacked-1fr'">
        <div class="grid-1fr_stacked-1fr">
          <div class="span grid-stacked">
            <div class="span">
              <div v-if="elements[0] && elements[0].position == '0'">
                  <grid-media :element="elements[0]"></grid-media>
              </div>
              <div v-else>
                <button-add :gridId="gridId" :gridPosition="0"></button-add>
              </div>
            </div>
            <div class="span">
              <div v-if="elements[1] && elements[1].position == '1'">
                  <grid-media :element="elements[1]"></grid-media>
              </div>
              <div v-else>
                <button-add :gridId="gridId" :gridPosition="1"></button-add>
              </div>
            </div>
          </div>
          <div class="span">
            <div v-if="elements[2] && elements[2].position == '2'">
              <grid-media :element="elements[2]"></grid-media>
            </div>
            <div v-else>
              <button-add :gridId="gridId" :gridPosition="2"></button-add>
            </div>
          </div>
        </div>
      </div>
      <div v-if="layout == '1fr-1fr_stacked'">
        <div class="grid-1fr-1fr_stacked">
          <div class="span">
            <div v-if="elements[0] && elements[0].position == '0'">
              <grid-media :element="elements[0]"></grid-media>
            </div>
            <div v-else>
              <button-add :gridId="gridId" :gridPosition="0"></button-add>
            </div>
          </div>
          <div class="span grid-stacked">
            <div class="span">
              <div v-if="elements[1] && elements[1].position == '1'">
                  <grid-media :element="elements[1]"></grid-media>
              </div>
              <div v-else>
                <button-add :gridId="gridId" :gridPosition="1"></button-add>
              </div>
            </div>
            <div class="span">
              <div v-if="elements[2] && elements[2].position == '2'">
                  <grid-media :element="elements[2]"></grid-media>
              </div>
              <div v-else>
                <button-add :gridId="gridId" :gridPosition="2"></button-add>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div :class="[hasOverlay ? 'is-visible': '', 'overlay']">
      <div>
        <a href="javascript:;" @click.prevent="toggleOverlay()" class="icon-close-overlay"></a>
        <div>
          <h1>Projektbild auswählen</h1>
          <div class="project-selector">
            <div class="project-selector__item">
              <div class="project-selector__media">
                <figure v-for="image in images" :key="image.id">
                  <a href @click.prevent="storeImage(image.id)">
                    <img :src="getAssetSource(image.name)" height="50" width="50">
                  </a>
                </figure>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import GridMedia from "@/components/project/grid/Media.vue";
import ButtonAdd from "@/components/project/grid/ButtonAdd.vue";

export default {
  components: {
    ButtonAdd: ButtonAdd,
    GridMedia: GridMedia
  },

  data() {
    return {
      hasOverlay: false,
      isLoading: false,

      tmpGridId: null,
      tmpPosition: null,

      // Project images
      images: [],

      // Grid elements
      elements: []
    };
  },

  props: {
    layout: String,
    gridId: Number,
    projectId: Number
  },

  //mixins: [grid],

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      let uri = `/api/project/grid/images/${this.$props.gridId}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        let els = [];
        if (response.data.data) {
          response.data.data.forEach(e => {
            if (e.id) {
              let el = {
                id: e.id,
                position: e.position,
                imageId: e.image.id,
                image: e.image.name,
                caption: e.image.caption.de
              };
              els[e.position] = el;
            }
          });

          if (els.length > 0) {
            this.elements = els;
          }
          else if (els.length == 0) {
            this.elements = [];
          }
        }
        this.isLoading = false;
      });
    },

    showImages(gridId, position) {
      let uri = `/api/project/image/get/${this.$props.projectId}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        this.images = response.data.data;
        this.toggleOverlay();
        this.isLoading = false;
        this.tmpGridId = gridId;
        this.tmpPosition = position;
      });
    },

    storeImage(imageId) {
      let data = {
        position: this.tmpPosition,
        grid_id: this.tmpGridId,
        project_image_id: imageId,
        project_id: this.$props.projectId
      };

      let uri = '/api/project/grid/image/store';
      this.isLoading = true;
      this.axios.post(uri, data).then(response => {
        this.toggleOverlay();
        this.$notify({type: 'success', text: 'Bild hinzugefügt!'});
        this.fetch();
      });
    },

    deleteImage(id) {
      let uri = `/api/project/grid/image/delete/${id}`;
      this.isLoading = true;
      this.axios.delete(uri).then(response => {
        this.$notify({type: 'success', text: 'Bild gelöscht!'});
        this.fetch();
      });
    },

    getAssetSource(asset) {
      return `/media/${asset}/xs`;
    },

    toggleOverlay() {
      let html = document.querySelector('html');
      html.classList.toggle('has-overlay');
      this.hasOverlay = this.hasOverlay ? false : true;
    },
  }
};
</script>