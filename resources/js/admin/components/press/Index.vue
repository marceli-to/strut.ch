<template>
  <div>
    <page-header />
    <notifications classes="notification" />
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Presse</h1>
          <router-link :to="{ name: 'press-create' }" class="btn-add"><span>Hinzufügen</span></router-link>
          <div class="list-items" v-if="press.length">
            <div class="list-item-group" v-for="articles in press" :key="articles.index">
              <h2>{{articles[0].year}}</h2>
              <div :class="[p.publish == 0 ? 'is-disabled' : '', 'list-item']" v-for="p in articles" :key="p.id">
                <div class="list-item-body">
                  <h3>{{ p.title.de }} </h3>
                  <p>{{p.description.de}}</p>
                  <span v-if="p.project">
                    Projekt: {{p.project.name.de}}, {{p.project.location.de}} ({{p.project.year}})
                  </span>
                </div>
                <div class="list-item-action">
                  <a href="javascript:;" :class="[p.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']" @click.prevent="toggleStatus(p.id)"></a>
                  <router-link :to="{name: 'press-edit', params: { id: p.id }}" class="icon-edit icon-mini"></router-link>
                  <a href="javascript:;" class="icon-copy icon-mini" @click.prevent="clone(p.id)"></a>
                  <a href="javascript:;" class="icon-trash icon-mini" @click.prevent="destroy(p.id)"></a>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <p>Es sind keine Presse-Artikel vorhanden...</p>
          </div>
          <footer class="form-footer">
            <div>
              <div class="filter">
                <div><strong>Filter Jahr</strong></div>
                <div>
                  <div class="select-wrapper">
                    <select v-model="selected" @change="filter($event)">
                      <option v-for="option in options.years" :key="option.value">
                        {{ option }}
                      </option>
                    </select>
                  </div>
                </div>
                <div>
                  <a href="" @click.prevent="resetFilter()">Zurücksetzen</a>
                </div>
              </div>
            </div>
          </footer>
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
        press: [],
        selected: null,
        options: {
          years: []
        },
        debounce: false,
      }
    },

    created() {
      this.fetch();
    },

    methods: {

      fetch($year) {
        let uri = '/api/press/get';
        this.axios.get(uri).then(response => {
          this.press = response.data.data;
          this.options.years = this.getYears(response.data.data);
        });        
      },

      filter() {
        let uri = '/api/press/get/' + this.selected;
        this.axios.get(uri).then(response => {
          this.press = response.data.data;
        });   
      },

      resetFilter() {
        this.selected = null;
        this.fetch();
      },

      destroy(id) {
        if(confirm('Bitte löschen bestätigen!')) {
          let uri = `/api/press/destroy/${id}`;
          this.axios.delete(uri).then(response => {
            this.press = response.data.data;
            this.$notify({type: 'success', text: 'Eintrag gelöscht'});
          });
        }
      },
      
      clone(id) {
        let uri = `/api/press/clone/${id}`;
        this.axios.get(uri).then(response => {
          //this.press.push(response.data);
          this.press = response.data.data;
          this.$notify({type: 'success', text: 'Eintrag kopiert'});
        });        
      },

      toggleStatus(id) {
        let uri = `/api/press/status/${id}`;
        this.axios.get(uri).then(response => {
          // Press articles are grouped by years
          // we need to loop twice
          let tmpPress = this.press;
          tmpPress.forEach(function(pressYear, index) {
            pressYear.forEach(function(p, i){
              if (pressYear[i].id == id) {
                tmpPress[index][i].publish = response.data;
              }
            });
          });
          this.press = tmpPress;
          this.$notify({type: 'success', text: 'Status angepasst'});
        });
      },

      getYears(data) {
        let years = [];
        data.forEach(function(items){
          items.forEach(function(item){
            years.push(item.year);
          })
        });
        return [...new Set(years)];
      }
    }
  }
</script>
