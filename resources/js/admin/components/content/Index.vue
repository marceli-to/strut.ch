<template>
  <div>
    <page-header/>
    <notifications classes="notification"/>
    <div class="container">
      <main class="content" role="main">
        <div>
          <h1>Statische Seiteninhalte</h1>
          <div class="list-items" v-if="content.length">
            <div
              :class="[c.publish == 0 ? 'is-disabled' : '', 'list-item']"
              v-for="c in content"
              :key="c.id"
              data-icons="2"
            >
              <div class="list-item-body">
                <h3>{{ c.title.de }}</h3>
              </div>
              <div class="list-item-action" data-icons="2">
                <a
                  href="javascript:;"
                  :class="[c.publish == 1 ? 'icon-eye' : 'icon-eye-off', 'icon-mini']"
                  @click.prevent="toggleStatus(c.id,$event)"
                ></a>
                <router-link
                  :to="{name: 'content-edit', params: { id: c.id }}"
                  class="icon-edit icon-mini"
                ></router-link>
              </div>
            </div>
          </div>
          <div v-else>
            <p>Es sind keine Inhalte vorhanden...</p>
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

  data() {
    return {
      content: [],
    };
  },

  mixins: [Progress],

  created() {
    let uri = "/api/contents/get";
    this.axios.get(uri).then(response => {
      this.content = response.data.data;
    });
  },

  methods: {
    toggleStatus(id,event) {
      let uri = `/api/content/status/${id}`;
      let el = this.progress(event.target);
      this.axios.get(uri).then(response => {
        const index = this.content.findIndex(x => x.id === id);
        this.content[index].publish = response.data;
        this.$notify({ type: "success", text: "Status angepasst" });
        this.progress(el);
      });
    },
  }
};
</script>