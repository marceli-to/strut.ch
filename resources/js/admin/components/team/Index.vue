<template>
  <div>
    <page-header />
    <notifications classes="notification" />
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Team</h1>
          <router-link :to="{ name: 'team-create' }" class="btn-add"><span>Hinzufügen</span></router-link>
          <div class="list-cards" v-if="team.length">
            <draggable 
              v-model="team" 
              @end="updateOrder"
              ghost-class="draggable-ghost"
              tag="div">
              <div :class="[t.publish == 0 ? 'is-disabled' : '', 'list-card-item', 'list-item--sortable']" v-for="t in team" :key="t.id">
                <div class="list-card-body">
                  <h2>{{ t.firstname }} {{ t.name }}</h2>
                  <p>
                    <span v-if="t.role.de">{{ t.role.de }}</span>
                    <span v-if="t.position.de">{{ t.position.de }}</span>
                    <span v-if="t.email">{{ t.email }}</span>
                    <span v-if="t.phone">{{ t.phone }}</span>
                  </p>
                </div>
                <div class="list-card-action">
                  <a href="javascript:;" :class="[t.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']" @click.prevent="toggleStatus(t.id)"></a>
                  <router-link :to="{name: 'team-edit', params: { id: t.id }}" class="icon-edit icon-mini"></router-link>
                  <a href="javascript:;" class="icon-copy icon-mini" @click.prevent="clone(t.id)"></a>
                  <a href="javascript:;" class="icon-trash icon-mini" @click.prevent="destroy(t.id)"></a>
                </div>
              </div>
            </draggable>
          </div>
          <div v-else>
            <p>Es sind keine Teammitglieder vorhanden...</p>
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
        team: [],
        debounce: false,
      }
    },

    created() {
        let uri = '/api/team/get';
        this.axios.get(uri).then(response => {
          this.team = response.data.data;
        });
    },

    methods: {

      destroy(id) {
        let uri = `/api/team/destroy/${id}`;
        this.axios.delete(uri).then(response => {
          this.team.splice(this.team.indexOf(id), 1);
          this.$notify({type: 'success', text: 'Eintrag gelöscht'});
        });
      },
      
      clone(id) {
        let uri = `/api/team/clone/${id}`;
        this.axios.get(uri).then(response => {
          this.team.push(response.data);
          this.$notify({type: 'success', text: 'Eintrag kopiert'});
        });        
      },

      toggleStatus(id) {
        let uri = `/api/team/status/${id}`;
        this.axios.get(uri).then(response => {
          const index = this.team.findIndex(x => x.id === id);
          this.team[index].publish = response.data;
          this.$notify({type: 'success', text: 'Status angepasst'});
        });
      },
      
      updateOrder() {
        let team = this.team.map(function(t, index) {
            t.order = index;
            return t;
        });

        if (this.debounce) return;

        this.debounce = setTimeout(function(team) {
          this.debounce = false 
          let uri = `/api/team/order`;
          this.axios.post(uri, {team: team}).then((response) => {
            this.$router.push({name: 'team'});
          });
        }.bind(this, team), 1000);
        this.$notify({type: 'success', text: 'Reihenfolge angepasst'});
      }
    }
  }
</script>