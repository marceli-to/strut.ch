<template>
    <div>
        <div class="grid-layout-selector">
            <a href="" class="btn-toggle-layout" @click.prevent="toggleSelect()">Select grid layout</a>
            <ul :class="showSelect ? 'is-visible': ''" ref="dropdown">
                <li v-for="layout in layouts" :key="layout.id">
                    <a href="" @click.prevent="addGrid(layout.id)">
                        <img :src="getMediaSource(layout.key)" height="30" width="100">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            layouts: [],
            showSelect: false
        }
    },

    created() {
        this.axios.get('/api/gridlayout/fetch').then(response => {
            this.layouts = response.data.data;
        });
    },

    methods: {

        getMediaSource(key) {
            return `/assets/admin/img/icons/grid-layout-${key}.svg`;
        },

        toggleSelect() {
            this.showSelect = this.showSelect ? false : true;
        },

        addGrid(gridId) {
            this.showSelect = false;
            this.$parent.addGrid(gridId);
        },
    }
}
</script>
