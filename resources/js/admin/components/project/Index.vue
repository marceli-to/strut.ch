<template>
  <div>
    <page-header />
    <notifications classes="notification" />
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Bauten</h1>
          <router-link :to="{ name: 'project-create' }" class="btn-add"><span>Hinzufügen</span></router-link>
          <div v-if="projects.length">
            <div v-for="categories in grouped" :key="categories.index">
              <div class="list-items">
                <div class="list-item-group">
                  <div v-for="(project, idx) in categories" :key="idx">
                    <h2 v-if="idx == 0">
                      {{ project.category.name.de }}<span v-if="project.category.id == 1"> – {{ project.category_type.name_singular.de }}</span>
                    </h2>
                  </div>
                <!-- <draggable 
                  v-model="grouped.index" 
                  @end="updateOrder"
                  ghost-class="draggable-ghost-list"
                  tag="div"> -->
                  <div v-for="project in categories" :key="project.id">
                    <div :class="[project.publish == 0 ? 'is-disabled' : '', 'list-item', 'list-item--project']"><!--  list-item--sortable -->
                      <div class="list-item-body">
                        <h3>{{ project.name.de }}, {{ project.location.de }}</h3>
                        <span>{{ project.year }}, {{ project.status }}</span>
                        <span v-if="project.competition">Wettbewerb ({{project.competition}})</span>
                      </div>
                      <div class="list-item-action">
                        <a href="javascript:;" :class="[project.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']" @click.prevent="toggleStatus(project.id)"></a>
                        <router-link :to="{name: 'project-edit', params: { id: project.id }}" class="icon-edit icon-mini"></router-link>
                        <a href="javascript:;" class="icon-copy icon-mini" @click.prevent="clone(project.id)"></a>
                        <a href="javascript:;" class="icon-trash icon-mini" @click.prevent="destroy(project.id)"></a>
                      </div>
                    </div>
                  </div>
                <!-- </draggable> -->
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <p>Es sind keine Projekte vorhanden...</p>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
<script>
  import PageHeader from '@/layout/PageHeader.vue';
  import draggable from 'vuedraggable';
  export default {
    components: {
      draggable,
      PageHeader: PageHeader,
    },

    data() {
      return {
        projects: [],
        grouped: [],
        debounce: false,
      }
    },

    created() {
      this.fetch();
    },

    methods: {

      fetch() {
        let uri = '/api/projects/get';
        this.axios.get(uri).then(response => {
          this.projects = response.data.data;
          this.grouped = _.groupBy(this.projects, "category_type_id");
        });
      },

      destroy(id) {
        let uri = `/api/project/destroy/${id}`;
        this.axios.delete(uri).then(response => {
          this.fetch();
          this.$notify({type: 'success', text: 'Eintrag gelöscht'});
        });
      },

      clone(id) {
        let uri = `/api/project/clone/${id}`;
        this.axios.get(uri).then(response => {
          this.fetch();
          this.$notify({type: 'success', text: 'Eintrag kopiert'});
        });        
      },

      toggleStatus(id) {
        let uri = `/api/project/status/${id}`;
        this.axios.get(uri).then(response => {
          const index = this.projects.findIndex(x => x.id === id);
          this.projects[index].publish = response.data;
          this.$notify({type: 'success', text: 'Status angepasst'});
        });
      },
      
      updateOrder() {

        // let projects = this.projects.map(function(project, index) {
        //     project.order = index;
        //     return project;
        // });

        //console.log(this.grouped);

        // Object.keys(this.grouped).forEach(key => {
        //   const user = this.grouped[key];
        //   console.log(user);
        // });
        // if (this.debounce) return;

        // this.debounce = setTimeout(function(projects) {
        //   this.debounce = false 
        //   let uri = `/api/project/order`;
        //   this.axios.post(uri, {projects: projects}).then((response) => {
        //     this.$router.push({name: 'projects'});
        //   });
        // }.bind(this, projects), 1000);
        // this.$notify({type: 'success', text: 'Reihenfolge angepasst'});
      }
    }
  }
</script>