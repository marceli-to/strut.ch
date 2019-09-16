<template>
  <div>
    <div class="form-row" v-if="asset == null">
      <label for="document">{{labelNew}}</label>
      <vue-image-dropzone
        ref="dropzone_image"
        id="dropzone_image"
        :options="dropzoneImageConfig"
        @vdropzone-complete="afterImageUpload"
      ></vue-image-dropzone>
      <span class="dz-restrictions">{{labelRestrictions}}</span>
    </div>
    <div class="form-row" v-if="asset">
      <label>{{labelExisting}}</label>
      <div class="dropzone-existing-assets">
        <div>
          <figure :class="[assetType == 'image' ? 'is-image' : '', 'dz-existing-asset']">
            <a :href="getAssetUri(asset)" target="_blank" class="dz-file-preview">
              <img :src="getAssetSource(asset)" height="300" width="300">
            </a>
            <div class="dz-toolbar">
              <a :href="getAssetUri(asset)" target="_blank" class="icon-external-link icon-mini"></a>
              <a
                href="javascript:;"
                class="icon-trash icon-mini"
                @click.prevent="deleteImageUpload(asset)"
              ></a>
            </div>
          </figure>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import vue2Dropzone from "vue2-dropzone";
import dropzoneImageConfig from "@/config/dropzoneconfig-image.js";

export default {
  components: {
    vueImageDropzone: vue2Dropzone
  },

  props: {
    labelNew: String,
    labelExisting: String,
    labelRestrictions: String,
    asset: String,
    assetType: String,
    acceptedFiles: String,
    maxFiles: Number,
    maxFilesize: Number,
    uploadUrl: String
  },

  data() {
    return {
      dropzoneImageConfig: dropzoneImageConfig
    };
  },

  created() {
    this.dropzoneImageConfig.url = this.$props.uploadUrl;
    this.dropzoneImageConfig.acceptedFiles = this.$props.acceptedFiles;
    this.dropzoneImageConfig.maxFiles = this.$props.maxFiles;
    this.dropzoneImageConfig.maxFilesize = this.$props.maxFilesize;
  },

  methods: {
    afterImageUpload(asset) {
      this.$refs.dropzone_image.removeFile(asset);
      this.$parent.afterImageUpload(asset);
    },

    deleteImageUpload(asset) {
      this.$parent.deleteImageUpload(asset);
    },

    getAssetUri(asset) {
      return `/media/${asset}/sm`;
    },

    getAssetSource(asset) {
      return `/media/thumbnail/${asset}`;
    }
  }
};
</script>