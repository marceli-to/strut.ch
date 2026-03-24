<template>
  <div>
    <div class="progress">
      <div :class="isLoading ? 'is-loading progress__bar': 'progress__bar'"></div>
    </div>
    <div class="grids">
      <div v-if="layout == '2fr'">
        <div class="grid-layout-preview">
          <img :src="getAssetUri(layout)" height="47" width="102">
        </div>
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
        <div class="grid-layout-preview">
          <img :src="getAssetUri(layout)" height="47" width="102">
        </div>
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
        <div class="grid-layout-preview">
          <img :src="getAssetUri(layout)" height="47" width="102">
        </div>
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
      <div v-if="layout == '1fr_sm_lg-1fr_lg_sm'">
        <div class="grid-layout-preview">
          <img :src="getAssetUri(layout)" height="47" width="102">
        </div>
        <div class="grid-1fr_sm_lg-1fr_lg_sm">
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
          <div class="span grid-stacked">
            <div class="span">
              <div v-if="elements[2] && elements[2].position == '2'">
                  <grid-media :element="elements[2]"></grid-media>
              </div>
              <div v-else>
                <button-add :gridId="gridId" :gridPosition="2"></button-add>
              </div>
            </div>
            <div class="span">
              <div v-if="elements[3] && elements[3].position == '3'">
                  <grid-media :element="elements[3]"></grid-media>
              </div>
              <div v-else>
                <button-add :gridId="gridId" :gridPosition="3"></button-add>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="layout == '1fr_lg_sm-1fr_sm_lg'">
        <div class="grid-layout-preview">
          <img :src="getAssetUri(layout)" height="47" width="102">
        </div>
        <div class="grid-1fr_lg_sm-1fr_sm_lg">
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
          <div class="span grid-stacked">
            <div class="span">
              <div v-if="elements[2] && elements[2].position == '2'">
                  <grid-media :element="elements[2]"></grid-media>
              </div>
              <div v-else>
                <button-add :gridId="gridId" :gridPosition="2"></button-add>
              </div>
            </div>
            <div class="span">
              <div v-if="elements[3] && elements[3].position == '3'">
                  <grid-media :element="elements[3]"></grid-media>
              </div>
              <div v-else>
                <button-add :gridId="gridId" :gridPosition="3"></button-add>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="layout == '1fr_sm_lg-1fr_lg'">
        <div class="grid-layout-preview">
          <img :src="getAssetUri(layout)" height="47" width="102">
        </div>
        <div class="grid-1fr_sm_lg-1fr_lg">
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
          <div class="span grid-stacked">
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
      <div v-if="layout == '1fr_lg-1fr_sm_lg'">
        <div class="grid-layout-preview">
          <img :src="getAssetUri(layout)" height="47" width="102">
        </div>
        <div class="grid-1fr_lg-1fr_sm_lg">
          <div class="span grid-stacked">
            <div class="span">
              <div v-if="elements[0] && elements[0].position == '0'">
                  <grid-media :element="elements[0]"></grid-media>
              </div>
              <div v-else>
                <button-add :gridId="gridId" :gridPosition="0"></button-add>
              </div>
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
          <h1>Bild oder Video auswählen</h1>
          <div class="project-selector">
            <div class="project-selector__item">
              <div class="project-selector__media">
                <figure v-for="image in images" :key="'img-' + image.id">
                  <a href @click.prevent="storeMedia(image.id, 'image')">
                    <img :src="getAssetSource(image.name)" height="50" width="50">
                  </a>
                </figure>
                <figure v-for="video in videos" :key="'vid-' + video.id" class="is-video">
                  <a href @click.prevent="storeMedia(video.id, 'video')">
                    <video :src="getVideoSource(video.name)" height="50" width="50" muted preload="metadata"></video>
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

      // Project videos
      videos: [],

      // Grid elements
      elements: []
    };
  },

  props: {
    layout: String,
    gridId: Number,
    projectId: Number
  },

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
                type: e.video ? 'video' : 'image',
                image: e.video ? e.video.name : (e.image ? e.image.name : null),
                caption: e.video ? (e.video.caption ? e.video.caption.de : '') : (e.image ? e.image.caption.de : '')
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
      let imageUri = `/api/project/image/get/${this.$props.projectId}`;
      let videoUri = `/api/project/video/get/${this.$props.projectId}`;
      this.isLoading = true;

      Promise.all([
        this.axios.get(imageUri),
        this.axios.get(videoUri).catch(() => ({ data: { data: [] } }))
      ]).then(([imageResponse, videoResponse]) => {
        this.images = imageResponse.data.data;
        this.videos = videoResponse.data.data || [];
        this.toggleOverlay();
        this.isLoading = false;
        this.tmpGridId = gridId;
        this.tmpPosition = position;
      });
    },

    storeMedia(mediaId, type) {
      let data = {
        position: this.tmpPosition,
        grid_id: this.tmpGridId,
        project_image_id: type === 'image' ? mediaId : null,
        project_video_id: type === 'video' ? mediaId : null,
        project_id: this.$props.projectId
      };

      let uri = '/api/project/grid/image/store';
      this.isLoading = true;
      this.axios.post(uri, data).then(response => {
        this.toggleOverlay();
        this.$notify({type: 'success', text: 'Medium hinzugefügt!'});
        this.fetch();
      });
    },

    deleteImage(id) {
      let uri = `/api/project/grid/image/delete/${id}`;
      this.isLoading = true;
      this.axios.delete(uri).then(response => {
        this.$notify({type: 'success', text: 'Medium gelöscht!'});
        this.fetch();
      });
    },

    getAssetSource(asset) {
      return `/media/grid/${asset}`;
    },

    getVideoSource(file) {
      return `/storage/media/${file}`;
    },

    getAssetUri(key) {
      return `/assets/admin/img/icons/grid-layout-${key}.svg`;
    },

    toggleOverlay() {
      let html = document.querySelector('html');
      html.classList.toggle('has-overlay');
      this.hasOverlay = this.hasOverlay ? false : true;
    },
  }
};
</script>
