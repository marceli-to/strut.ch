<template>
  <div>
    <div class="form-row" v-if="asset == null">
      <label for="document">{{labelNew}}</label>
      <vue-file-dropzone
        ref="dropzone_file"
        id="dropzone_file"
        :options="dropzoneFileConfig"
        @vdropzone-complete="afterFileUpload"
      ></vue-file-dropzone>
      <span class="dz-restrictions">{{labelRestrictions}}</span>
    </div>
    <div class="form-row" v-if="asset">
      <label>{{labelExisting}}</label>
      <div class="dropzone-existing-assets">
        <div>
          <figure :class="[assetType == 'image' ? 'is-image' : '', 'dz-existing-asset']">
            <a :href="getAssetUri(asset)" target="_blank" class="dz-file-preview">
              <img src="/assets/admin/img/icons/file.svg" height="100" width="100">
            </a>
            <div class="dz-toolbar">
              <a :href="getAssetUri(asset)" target="_blank" class="icon-external-link icon-mini"></a>
              <a
                href="javascript:;"
                class="icon-trash icon-mini"
                @click.prevent="deleteFileUpload(asset)"
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
import dropzoneFileConfig from "@/config/dropzoneconfig-file.js";

export default {
  components: {
    vueFileDropzone: vue2Dropzone
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
      dropzoneFileConfig: dropzoneFileConfig
    };
  },

  created() {
    this.dropzoneFileConfig.url = this.$props.uploadUrl;
    this.dropzoneFileConfig.acceptedFiles = this.$props.acceptedFiles;
    this.dropzoneFileConfig.maxFiles = this.$props.maxFiles;
    this.dropzoneFileConfig.maxFilesize = this.$props.maxFilesize;
  },

  methods: {
    afterFileUpload(asset) {
      this.$refs.dropzone_file.removeFile(asset);
      this.$parent.afterFileUpload(asset);
    },

    deleteFileUpload(asset) {
      this.$parent.deleteFileUpload(asset);
    },

    getAssetUri(asset) {
      return `/storage/media/downloads/${asset}`;
    }
  }
};
</script>