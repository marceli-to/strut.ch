<template>
    <div>
        <page-header />
        <div class="container">
            <main class="content" role="main">
                <div>
                    <h1>Dashboard</h1>
                </div>
            </main>
        </div>
    </div>
</template>
<script>
    import PageHeaderComponent from './layout/PageHeaderComponent.vue';
    export default {
        components: {
            PageHeader: PageHeaderComponent,
        },
    }
</script>