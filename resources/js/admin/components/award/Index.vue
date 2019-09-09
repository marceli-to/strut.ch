<template>
  <div>
    <page-header />
    <notifications classes="notification" />
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Auszeichnungen</h1>
          <router-link :to="{ name: 'award-create' }" class="btn-add"><span>Hinzufügen</span></router-link>
          <div class="list-items" v-if="awards.length">
            <div class="list-item-group" v-for="articles in awards" :key="articles.index">
              <h2>{{articles[0].year}}</h2>
              <div :class="[award.publish == 0 ? 'is-disabled' : '', 'list-item']" v-for="award in articles" :key="award.id">
                <div class="list-item-body">
                  <h3>{{ award.title.de }}</h3>
                  <p>{{award.description.de}}</p>
                </div>
                <div class="list-item-action">
                  <a href="javascript:;" :class="[award.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']" @click.prevent="toggleStatus(award.id)"></a>
                  <router-link :to="{name: 'award-edit', params: { id: award.id }}" class="icon-edit icon-mini"></router-link>
                  <a href="javascript:;" class="icon-copy icon-mini" @click.prevent="clone(award.id)"></a>
                  <a href="javascript:;" class="icon-trash icon-mini" @click.prevent="destroy(award.id)"></a>
                </div>
              </div>
            </div>

          </div>
          <div v-else>
            <p>Es sind keine Auszeichnungen vorhanden...</p>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
<script>
  import PageHeader from '@/layout/PageHeader.vue';
  export default {
    components: {
      PageHeader: PageHeader,
    },

    data() {
      return {
        awards: [],
        debounce: false,
      }
    },

    created() {
        let uri = '/api/awards/get';
        this.axios.get(uri).then(response => {
          this.awards = response.data.data;
        });
    },

    methods: {

      destroy(id) {
        if(confirm('Bitte löschen bestätigen!')) {
          let uri = `/api/award/destroy/${id}`;
          this.axios.delete(uri).then(response => {
            this.awards = response.data.data;
            this.$notify({type: 'success', text: 'Eintrag gelöscht'});
          });
        }
      },
      
      clone(id) {
        let uri = `/api/award/clone/${id}`;
        this.axios.get(uri).then(response => {
          this.awards = response.data.data;
          this.$notify({type: 'success', text: 'Eintrag kopiert'});
        });        
      },

      toggleStatus(id) {
        let uri = `/api/award/status/${id}`;
        this.axios.get(uri).then(response => {
          // Awards are grouped by years
          // we need to loop twice
          let tmpAwards = this.awards;
          tmpAwards.forEach(function(awardYear, index) {
            awardYear.forEach(function(award, i){
              if (awardYear[i].id == id) {
                tmpAwards[index][i].publish = response.data;
              }
            });
          });
          this.awards = tmpAwards;
          this.$notify({type: 'success', text: 'Status angepasst'});
        });
      },
    }
  }
</script>