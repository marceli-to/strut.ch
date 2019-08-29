// IndexComponent.vue
<template>
    <div>
        <page-header />
        <notifications classes="notification" />
        <div class="container">
            <main class="content" role="main">
                <div>
                    <h1>Highlights</h1>
                    <p>Elements of the highlight section will be displayed randomly.</p>
                    <div class="grid-rows">
                        <div class="grid-row grid-row--highlight">
                            <grid-highlight :gridId="1"></grid-highlight>
                        </div>
                    </div>
                    <h1>Teasers</h1>
                    <p>Select a grid and add a project or a news teaser. Projects or teasers will be displayed as defined by its grid layout.</p>
                    <grid-selector></grid-selector>
                    <div class="grid-rows">
                        <div class="grid-row" v-for="grid in grids" :key="grid.id">
                            <a href="javascript:;" class="btn-trash" @click.prevent="deleteGrid(grid.id)">Delete grid</a>
                            <grid-row :layout="grid.layout.key" :gridId="grid.id"></grid-row>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import PageHeader from '@/layout/PageHeader.vue';
import GridRow from '@/components/home/GridRow.vue';
import GridHighlight from '@/components/home/GridHighlight.vue';
import GridSelector from '@/components/home/GridSelector.vue';

export default {
    components: {
        PageHeader: PageHeader,
        GridRow: GridRow,
        GridHighlight: GridHighlight,
        GridSelector: GridSelector,
    },

    data() {
        return {
            grids: [],
        }
    },

    created() {
        this.axios.get('/api/grid').then(response => {
            this.grids = response.data.data;
        });
    },

    methods: {

        fetchGrids() {
            this.axios.get('/api/grid').then(response => {
                this.grids = response.data.data;
            });
        },

        addGrid(gridId) {
            let uri = `/api/grid/store/${gridId}`;
            this.axios.get(uri).then((response) => {
                this.grids = response.data.data;
                this.$notify({type: 'success', title: 'Success!', text: 'A new grid was added successfully!'});
                this.fetchGrids();
            });
        },

        deleteGrid(id) {
            let uri = `/api/grid/delete/${id}`;
            this.axios.delete(uri).then(response => {
                const index = this.grids.findIndex(x => x.id === id);
                this.grids.splice(index, 1);
                this.$notify({type: 'success', title: 'Success!', text: 'The grid was deleted successfully!'});
            });
        }        
    }
}
</script>

