<template>
  <div>
    <loading :active.sync="isLoading" :is-full-page="fullPage" :height="30" :width="30"></loading>
    <div class="grids">
      <div v-if="layout == '1fr'">
        <div class="grid-1fr">
          <div class="span">
            <div v-if="elements[0] && elements[0].position == '0'">
              <div v-if="elements[0].isMedia">
                <grid-media :element="elements[0]"></grid-media>
              </div>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="false"></buttons-create>
            </div>
          </div>
        </div>
      </div>
      <div v-if="layout == '2fr'">
        <div class="grid-2fr">
          <div class="span">
            <div v-if="elements[0] && elements[0].position == '0'">
              <grid-media :element="elements[0]"></grid-media>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="false"></buttons-create>
            </div>
          </div>
          <div class="span">
            <div v-if="elements[1] && elements[1].position == '1'">
              <grid-media :element="elements[1]"></grid-media>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="1" :showArticle="false"></buttons-create>
            </div>
          </div>
        </div>
      </div>
      <div v-if="layout == '3fr'">
        <div class="grid-3fr">
          <div class="span">
            <div v-if="elements[0] && elements[0].position == '0'">
              <div v-if="elements[0].isMedia">
                <grid-media :element="elements[0]"></grid-media>
              </div>
              <div v-if="elements[0].isArticle">
                <grid-article :element="elements[0]"></grid-article>
              </div>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="true"></buttons-create>
            </div>
          </div>
          <div class="span">
            <div v-if="elements[1] && elements[1].position == '1'">
              <div v-if="elements[1].isMedia">
                <grid-media :element="elements[1]"></grid-media>
              </div>
              <div v-if="elements[1].isArticle">
                <grid-article :element="elements[1]"></grid-article>
              </div>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="1" :showArticle="true"></buttons-create>
            </div>
          </div>
          <div class="span">
            <div v-if="elements[2] && elements[2].position == '2'">
              <div v-if="elements[2].isMedia">
                <grid-media :element="elements[2]"></grid-media>
              </div>
              <div v-if="elements[2].isArticle">
                <grid-article :element="elements[2]"></grid-article>
              </div>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="2" :showArticle="true"></buttons-create>
            </div>
          </div>
        </div>
      </div>
      <div v-if="layout == '2fr-1fr'">
        <div class="grid-2fr-1fr">
          <div class="span">
            <div v-if="elements[0] && elements[0].position == '0'">
              <grid-media :element="elements[0]"></grid-media>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="false"></buttons-create>
            </div>
          </div>
          <div class="span">
            <div v-if="elements[1] && elements[1].position == '1'">
              <div v-if="elements[1].isMedia">
                <grid-media :element="elements[1]"></grid-media>
              </div>
              <div v-if="elements[1].isArticle">
                <grid-article :element="elements[1]"></grid-article>
              </div>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="1" :showArticle="true"></buttons-create>
            </div>
          </div>
        </div>
      </div>
      <div v-if="layout == '1fr-2fr'">
        <div class="grid-1fr-2fr">
          <div class="span">
            <div v-if="elements[0] && elements[0].position == '0'">
              <div v-if="elements[0].isMedia">
                <grid-media :element="elements[0]"></grid-media>
              </div>
              <div v-if="elements[0].isArticle">
                <grid-article :element="elements[0]"></grid-article>
              </div>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="true"></buttons-create>
            </div>
          </div>
          <div class="span">
            <div v-if="elements[1] && elements[1].position == '1'">
              <grid-media :element="elements[1]"></grid-media>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="1" :showArticle="false"></buttons-create>
            </div>
          </div>
        </div>
      </div>
      <div v-if="layout == '2fr-1fr_stacked'">
        <div class="grid-2fr-1fr_stacked">
          <div class="span">
            <div v-if="elements[0] && elements[0].position == '0'">
              <grid-media :element="elements[0]"></grid-media>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="false"></buttons-create>
            </div>
          </div>
          <div class="span grid-stacked">
            <div class="span">
              <div v-if="elements[1] && elements[1].position == '1'">
                <div v-if="elements[1].isMedia">
                  <grid-media :element="elements[1]"></grid-media>
                </div>
                <div v-if="elements[1].isArticle">
                  <grid-article :element="elements[1]"></grid-article>
                </div>
              </div>
              <div v-else>
                <buttons-create :gridId="gridId" :gridPosition="1" :showArticle="true"></buttons-create>
              </div>
            </div>
            <div class="span">
              <div v-if="elements[2] && elements[2].position == '2'">
                <div v-if="elements[2].isMedia">
                  <grid-media :element="elements[2]"></grid-media>
                </div>
                <div v-if="elements[2].isArticle">
                  <grid-article :element="elements[2]"></grid-article>
                </div>
              </div>
              <div v-else>
                <buttons-create :gridId="gridId" :gridPosition="2" :showArticle="true"></buttons-create>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="layout == '1fr_stacked-2fr'">
        <div class="grid-1fr_stacked-2fr">
          <div class="span grid-stacked">
            <div class="span">
              <div v-if="elements[0] && elements[0].position == '0'">
                <div v-if="elements[0].isMedia">
                  <grid-media :element="elements[0]"></grid-media>
                </div>
                <div v-if="elements[0].isArticle">
                  <grid-article :element="elements[0]"></grid-article>
                </div>
              </div>
              <div v-else>
                <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="true"></buttons-create>
              </div>
            </div>
            <div class="span">
              <div v-if="elements[1] && elements[1].position == '1'">
                <div v-if="elements[1].isMedia">
                  <grid-media :element="elements[1]"></grid-media>
                </div>
                <div v-if="elements[1].isArticle">
                  <grid-article :element="elements[1]"></grid-article>
                </div>
              </div>
              <div v-else>
                <buttons-create :gridId="gridId" :gridPosition="1" :showArticle="true"></buttons-create>
              </div>
            </div>
          </div>
          <div class="span">
            <div v-if="elements[2] && elements[2].position == '2'">
              <grid-media :element="elements[2]"></grid-media>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="2" :showArticle="false"></buttons-create>
            </div>
          </div>
        </div>
      </div>
      <div v-if="layout == '1fr-1fr-1fr_stacked'">
        <div class="grid-1fr-1fr-1fr_stacked">
          <div class="span">
            <div v-if="elements[0] && elements[0].position == '0'">
              <div v-if="elements[0].isMedia">
                <grid-media :element="elements[0]"></grid-media>
              </div>
              <div v-if="elements[0].isArticle">
                <grid-article :element="elements[0]"></grid-article>
              </div>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="true"></buttons-create>
            </div>
          </div>
          <div class="span">
            <div v-if="elements[1] && elements[1].position == '1'">
              <div v-if="elements[1].isMedia">
                <grid-media :element="elements[1]"></grid-media>
              </div>
              <div v-if="elements[1].isArticle">
                <grid-article :element="elements[1]"></grid-article>
              </div>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="1" :showArticle="true"></buttons-create>
            </div>
          </div>
          <div class="span grid-stacked">
            <div class="span">
              <div v-if="elements[2] && elements[2].position == '2'">
                <div v-if="elements[2].isMedia">
                  <grid-media :element="elements[2]"></grid-media>
                </div>
                <div v-if="elements[2].isArticle">
                  <grid-article :element="elements[2]"></grid-article>
                </div>
              </div>
              <div v-else>
                <buttons-create :gridId="gridId" :gridPosition="2" :showArticle="true"></buttons-create>
              </div>
            </div>
            <div class="span">
              <div v-if="elements[3] && elements[3].position == '3'">
                <div v-if="elements[3].isMedia">
                  <grid-media :element="elements[3]"></grid-media>
                </div>
                <div v-if="elements[3].isArticle">
                  <grid-article :element="elements[3]"></grid-article>
                </div>
              </div>
              <div v-else>
                <buttons-create :gridId="gridId" :gridPosition="3" :showArticle="true"></buttons-create>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="layout == '1fr-1fr_stacked-1fr'">
        <div class="grid-1fr-1fr_stacked-1fr">
          <div class="span">
            <div v-if="elements[0] && elements[0].position == '0'">
              <div v-if="elements[0].isMedia">
                <grid-media :element="elements[0]"></grid-media>
              </div>
              <div v-if="elements[0].isArticle">
                <grid-article :element="elements[0]"></grid-article>
              </div>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="true"></buttons-create>
            </div>
          </div>
          <div class="span grid-stacked">
            <div class="span">
              <div v-if="elements[1] && elements[1].position == '1'">
                <div v-if="elements[1].isMedia">
                  <grid-media :element="elements[1]"></grid-media>
                </div>
                <div v-if="elements[1].isArticle">
                  <grid-article :element="elements[1]"></grid-article>
                </div>
              </div>
              <div v-else>
                <buttons-create :gridId="gridId" :gridPosition="1" :showArticle="true"></buttons-create>
              </div>
            </div>
            <div class="span">
              <div v-if="elements[2] && elements[2].position == '2'">
                <div v-if="elements[2].isMedia">
                  <grid-media :element="elements[2]"></grid-media>
                </div>
                <div v-if="elements[2].isArticle">
                  <grid-article :element="elements[2]"></grid-article>
                </div>
              </div>
              <div v-else>
                <buttons-create :gridId="gridId" :gridPosition="2" :showArticle="true"></buttons-create>
              </div>
            </div>
          </div>
          <div class="span">
            <div v-if="elements[3] && elements[3].position == '3'">
              <div v-if="elements[3].isMedia">
                <grid-media :element="elements[3]"></grid-media>
              </div>
              <div v-if="elements[3].isArticle">
                <grid-article :element="elements[3]"></grid-article>
              </div>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="3" :showArticle="true"></buttons-create>
            </div>
          </div>
        </div>
      </div>
      <div v-if="layout == '1fr_stacked-1fr-1fr'">
        <div class="grid-1fr_stacked-1fr-1fr">
          <div class="span grid-stacked">
            <div class="span">
              <div v-if="elements[0] && elements[0].position == '0'">
                <div v-if="elements[0].isMedia">
                  <grid-media :element="elements[0]"></grid-media>
                </div>
                <div v-if="elements[0].isArticle">
                  <grid-article :element="elements[0]"></grid-article>
                </div>
              </div>
              <div v-else>
                <buttons-create :gridId="gridId" :gridPosition="0" :showArticle="true"></buttons-create>
              </div>
            </div>
            <div class="span">
              <div v-if="elements[1] && elements[1].position == '1'">
                <div v-if="elements[1].isMedia">
                  <grid-media :element="elements[1]"></grid-media>
                </div>
                <div v-if="elements[1].isArticle">
                  <grid-article :element="elements[1]"></grid-article>
                </div>
              </div>
              <div v-else>
                <buttons-create :gridId="gridId" :gridPosition="1" :showArticle="true"></buttons-create>
              </div>
            </div>
          </div>
          <div class="span">
            <div v-if="elements[2] && elements[2].position == '2'">
              <div v-if="elements[2].isMedia">
                <grid-media :element="elements[2]"></grid-media>
              </div>
              <div v-if="elements[2].isArticle">
                <grid-article :element="elements[2]"></grid-article>
              </div>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="2" :showArticle="true"></buttons-create>
            </div>
          </div>
          <div class="span">
            <div v-if="elements[3] && elements[3].position == '3'">
              <div v-if="elements[3].isMedia">
                <grid-media :element="elements[3]"></grid-media>
              </div>
              <div v-if="elements[3].isArticle">
                <grid-article :element="elements[3]"></grid-article>
              </div>
            </div>
            <div v-else>
              <buttons-create :gridId="gridId" :gridPosition="3" :showArticle="true"></buttons-create>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div :class="[hasOverlay ? 'is-visible': '', 'overlay']">
      <div>
        <a
          href="javascript:;"
          @click.prevent="toggleOverlay()"
          class="icon-close icon-close-overlay"
        ></a>
        <div v-show="showMedia">
          <grid-media-selector :projects="projects" v-bind:is="selector"></grid-media-selector>
        </div>
        <div v-show="showNews">
          <grid-article-selector :news="news" v-bind:is="selector"></grid-article-selector>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import grid from "@/mixins/grid";
import GridMedia from "@/components/home/Media.vue";
import GridArticle from "@/components/home/Article.vue";
import ButtonsCreate from "@/components/ui/buttons/CreateGridItem.vue";

export default {
  components: {
    GridMedia: GridMedia,
    GridArticle: GridArticle,
    ButtonsCreate: ButtonsCreate,
  },

  props: {
    layout: String,
    gridId: Number
  },

  mixins: [grid],

  created() {
    this.fetchElements();
  },

  methods: {
    fetchElements() {
      let uri = `/api/home/grid/element/get/${this.$props.gridId}`;
      this.isLoading = true;
      this.axios.get(uri).then(response => {
        let els = [];
        if (response.data.data) {
          response.data.data.forEach(e => {
            if (e.news_id) {
              let el = {
                id: e.id,
                position: e.position,
                isArticle: true,
                articleId: e.news.id,
                date: e.news.date.de,
                title: e.news.title.de,
                text: e.news.text.de,
                media: e.news.media
              };
              els[e.position] = el;
            }

            if (e.project_image_id) {
              let img = e.projectimage;
              let el = {
                id: e.id,
                position: e.position,
                isMedia: true,
                projectId: img.project.id || null,
                image: img.name || null,
                caption: `${img.project.name.de}, ${img.project.location.de} (${img.project.year})`,
              };
              els[e.position] = el;
            }
          });

          this.elements = els;
        }
        this.isLoading = false;
      });
    }
  }
};
</script>