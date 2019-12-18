<template>
  <div>
    <page-header/>
    <notifications classes="notification"/>
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Jobs</h1>
          <router-link :to="{ name: 'job-create' }" class="btn-add">
            <span>Hinzufügen</span>
          </router-link>
          <div class="list-items" v-if="jobs.length">
            <draggable v-model="jobs" @end="updateOrder" ghost-class="draggable-ghost" tag="div">
              <div
                :class="[job.publish == 0 ? 'is-disabled' : '', 'list-item', 'is-sortable']"
                v-for="job in jobs"
                :key="job.id"
              >
                <div class="list-item-body">
                  <h3>{{ job.title.de }}</h3>
                  {{ job.lead.de }}
                </div>
                <div class="list-item-action">
                  <a
                    href="javascript:;"
                    :class="[job.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']"
                    @click.prevent="toggleStatus(job.id,$event)"
                  ></a>
                  <router-link
                    :to="{name: 'job-edit', params: { id: job.id }}"
                    class="icon-edit icon-mini"
                  ></router-link>
                  <a href="javascript:;" class="icon-copy icon-mini" @click.prevent="clone(job.id,$event)"></a>
                  <a
                    href="javascript:;"
                    class="icon-trash icon-mini"
                    @click.prevent="destroy(job.id,$event)"
                  ></a>
                </div>
              </div>
            </draggable>
          </div>
          <div v-else>
            <p>Es sind keine Jobs vorhanden...</p>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
<script>
import PageHeader from "@/layout/PageHeader.vue";
import draggable from "vuedraggable";
import Progress from "@/mixins/progress";

export default {
  components: {
    draggable,
    PageHeader: PageHeader
  },

  mixins: [Progress],

  data() {
    return {
      jobs: [],
      debounce: false
    };
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      let uri = "/api/jobs/get";
      this.axios.get(uri).then(response => {
        this.jobs = response.data.data;
      });
    },

    destroy(id,event) {
      if (confirm("Bitte löschen bestätigen!")) {
        let uri = `/api/job/destroy/${id}`;
        let el = this.progress(event.target);
        this.axios.delete(uri).then(response => {
          this.jobs.splice(this.jobs.indexOf(id), 1);
          this.$notify({ type: "success", text: "Eintrag gelöscht" });
          this.progress(el);
        });
      }
    },

    clone(id,event) {
      let uri = `/api/job/clone/${id}`;
      let el = this.progress(event.target);
      this.axios.get(uri).then(response => {
        this.jobs.push(response.data);
        this.$notify({ type: "success", text: "Eintrag kopiert" });
        this.progress(el);
      });
    },

    toggleStatus(id,event) {
      let uri = `/api/job/status/${id}`;
      let el = this.progress(event.target);
      this.axios.get(uri).then(response => {
        const index = this.jobs.findIndex(x => x.id === id);
        this.jobs[index].publish = response.data;
        this.$notify({ type: "success", text: "Status angepasst" });
        this.progress(el);
      });
    },

    updateOrder() {
      let jobs = this.jobs.map(function(job, index) {
        job.order = index;
        return job;
      });

      if (this.debounce) return;

      this.debounce = setTimeout(
        function(jobs) {
          this.debounce = false;
          let uri = `/api/job/order`;
          this.axios.post(uri, { jobs: jobs }).then(response => {
            this.$router.push({ name: "jobs" });
          });
        }.bind(this, jobs),
        1000
      );
      this.$notify({ type: "success", text: "Reihenfolge angepasst" });
    }
  }
};
</script>