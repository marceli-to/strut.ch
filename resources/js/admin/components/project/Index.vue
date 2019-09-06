<template>
  <div>
    <page-header />
    <notifications classes="notification" />
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Projekte</h1>
          <router-link :to="{ name: 'project-create' }" class="btn-add"><span>Hinzufügen</span></router-link>
          <div class="list-items" v-if="projects.length">
            <draggable 
              v-model="projects" 
              @end="updateOrder"
              ghost-class="draggable-ghost"
              tag="div">
              <div :class="[project.publish == 0 ? 'is-disabled' : '', 'list-item', 'list-item--sortable']" v-for="project in projects" :key="project.id">
                <div class="list-item-body">
                  <h3>{{ project.title.de }}</h3>
                </div>
                <div class="list-item-action">
                  <a href="javascript:;" :class="[project.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']" @click.prevent="toggleStatus(project.id)"></a>
                  <router-link :to="{name: 'project-edit', params: { id: project.id }}" class="icon-edit icon-mini"></router-link>
                  <a href="javascript:;" class="icon-copy icon-mini" @click.prevent="clone(project.id)"></a>
                  <a href="javascript:;" class="icon-trash icon-mini" @click.prevent="destroy(project.id)"></a>
                </div>
              </div>
            </draggable>
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
        debounce: false,
      }
    },

    created() {
        let uri = '/api/projects/get';
        this.axios.get(uri).then(response => {
          this.projects = response.data.data;
        });
    },

    methods: {

      destroy(id) {
        let uri = `/api/project/destroy/${id}`;
        this.axios.delete(uri).then(response => {
          this.projects.splice(this.projects.indexOf(id), 1);
          this.$notify({type: 'success', text: 'Eintrag gelöscht'});
        });
      },

      clone(id) {
        let uri = `/api/project/clone/${id}`;
        this.axios.get(uri).then(response => {
          this.projects.push(response.data);
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
        let projects = this.projects.map(function(project, index) {
            project.order = index;
            return project;
        });

        if (this.debounce) return;

        this.debounce = setTimeout(function(projects) {
          this.debounce = false 
          let uri = `/api/project/order`;
          this.axios.post(uri, {projects: projects}).then((response) => {
            this.$router.push({name: 'projects'});
          });
        }.bind(this, projects), 1000);
        this.$notify({type: 'success', text: 'Reihenfolge angepasst'});
      }
    }
  }
</script>