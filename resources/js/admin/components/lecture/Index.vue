<template>
  <div>
    <page-header/>
    <notifications classes="notification"/>
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Vorträge</h1>
          <router-link :to="{ name: 'lecture-create' }" class="btn-add">
            <span>Hinzufügen</span>
          </router-link>
          <div class="list-items" v-if="lectures.length">
            <div class="list-item-group" v-for="articles in lectures" :key="articles.index">
              <h2>{{articles[0].year}}</h2>
              <div
                :class="[lecture.publish == 0 ? 'is-disabled' : '', 'list-item']"
                v-for="lecture in articles"
                :key="lecture.id"
              >
                <div class="list-item-body">
                  <h3>{{ lecture.title.de }}</h3>
                  <p>{{lecture.description.de}}</p>
                </div>
                <div class="list-item-action">
                  <a
                    href="javascript:;"
                    :class="[lecture.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']"
                    @click.prevent="toggleStatus(lecture.id,$event)"
                  ></a>
                  <router-link
                    :to="{name: 'lecture-edit', params: { id: lecture.id }}"
                    class="icon-edit icon-mini"
                  ></router-link>
                  <a
                    href="javascript:;"
                    class="icon-copy icon-mini"
                    @click.prevent="clone(lecture.id,$event)"
                  ></a>
                  <a
                    href="javascript:;"
                    class="icon-trash icon-mini"
                    @click.prevent="destroy(lecture.id,$event)"
                  ></a>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <p>Es sind keine Vorträge vorhanden...</p>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
<script>
import PageHeader from "@/layout/PageHeader.vue";
import Progress from "@/mixins/progress";

export default {
  components: {
    PageHeader: PageHeader
  },

  mixins: [Progress],

  data() {
    return {
      lectures: [],
      debounce: false
    };
  },

  created() {
    let uri = "/api/lectures/get";
    this.axios.get(uri).then(response => {
      this.lectures = response.data.data;
    });
  },

  methods: {
    destroy(id,event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/lecture/destroy/${id}`;
        let el = this.progress(event.target);
        this.axios.delete(uri).then(response => {
          this.lectures = response.data.data;
          this.$notify({ type: "success", text: "Eintrag gelöscht" });
          this.progress(el);
        });
      }
    },

    clone(id,event) {
      let uri = `/api/lecture/clone/${id}`;
      let el = this.progress(event.target);
      this.axios.get(uri).then(response => {
        this.lectures = response.data.data;
        this.$notify({ type: "success", text: "Eintrag kopiert" });
        this.progress(el);
      });
    },

    toggleStatus(id,event) {
      let uri = `/api/lecture/status/${id}`;
      let el = this.progress(event.target);
      this.axios.get(uri).then(response => {
        // lectures are grouped by years
        // we need to loop twice
        let tmplectures = this.lectures;
        tmplectures.forEach(function(lectureYear, index) {
          lectureYear.forEach(function(lecture, i) {
            if (lectureYear[i].id == id) {
              tmplectures[index][i].publish = response.data;
            }
          });
        });
        this.lectures = tmplectures;
        this.$notify({ type: "success", text: "Status angepasst" });
        this.progress(el);
      });
    }
  }
};
</script>