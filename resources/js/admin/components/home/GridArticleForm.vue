<template>
    <div>
        <h2>Create a news entry</h2>
        <nav class="tabs">
            <ul>
                <li>
                    <a href="javascript:;" @click="changeTab('data')" :class="[tabs.data.active ? 'is-active' : '', tabs.data.error ? 'has-error' : '']">Data</a>
                </li>
                <li>
                    <a href="javascript:;" @click="changeTab('translation')" :class="[tabs.translation.active ? 'is-active' : '', tabs.translation.error ? 'has-error' : '']">Translation</a>
                </li>
                <li>
                    <a href="javascript:;" @click="changeTab('media')" :class="tabs.media.active ? 'is-active' : ''">Media</a>
                </li>
            </ul>
        </nav>
        <form @submit.prevent="storeArticle">
            <div class="span" v-show="tabs.data.active">
                <div class="form-row" :class="errors.date.de ? 'has-error': ''">
                    <label>Date</label>
                    <input type="text" @focus="removeError('date', 'de')" v-model="news.date.de">
                </div>
                <div class="form-row" :class="errors.title.de ? 'has-error': ''">
                    <label>Title *</label>
                    <input type="text" @focus="removeError('title', 'de')" v-model="news.title.de">
                </div>
                <div class="form-row" :class="errors.text.de ? 'has-error': ''">
                    <label>Text</label>
                    <textarea @focus="removeError('text', 'de')" v-model="news.text.de" :class="errors.text.de ? 'has-error': ''" rows="5"></textarea>
                </div>
            </div>
            <div class="span" v-show="tabs.translation.active">
                <div class="form-row" :class="errors.date.en ? 'has-error': ''">
                    <label>Date</label>
                    <input type="text" @focus="removeError('date', 'en')" v-model="news.date.en">
                </div>
                <div class="form-row" :class="errors.title.en ? 'has-error': ''">
                    <label>Title *</label>
                    <input type="text" @focus="removeError('title', 'en')" v-model="news.title.en">
                </div>
                <div class="form-row" :class="errors.text.en ? 'has-error': ''">
                    <label>Text</label>
                    <textarea @focus="removeError('text', 'en')"  v-model="news.text.en" :class="errors.text.en ? 'has-error': ''" rows="5"></textarea>
                </div>
            </div>
            <div class="form-row form-buttons">
                <button type="submit">Speichern</button>
            </div>
        </form>
    </div>
</template>
<script>
export default {

    data() {
        return {

            // model
            news: {
                date: {
                    de: null,
                    en: null,
                },
                title: {
                    de: null,
                    en: null,
                },
                text: {
                    de: null,
                    en: null,
                }      
            },

            // fields to validate
            errors: {
                date: {
                    de: false,
                    en: false,
                },
                title: {
                    de: false,
                    en: false,
                },
                text: {
                    de: false,
                    en: false,
                }
            },

            // tabs
            tabs: {
                data: {
                    active: true,
                    error: false
                },
                translation: {
                    active: false,
                    error: false
                },
                media: {
                    active: false,
                    error: false
                }
            },
        }
    },

    created() {
    },

    mounted() {
    },

    methods: {

        storeArticle() {
            this.$parent.storeArticle(this.news);
            // this.resetData();
        },

        resetData() {
            var self = this;
            Object.keys(this.news).forEach(function(key,index) {
                self.news[key].de = '';
                self.news[key].en = '';
            });
        },

        changeTab(tab) {
            // set all tabs inactive
            // remove errors if any
            for (let prop in this.tabs) {
                this.tabs[prop].active = false;
                this.tabs[prop].error = false;
            };
            // set active tab
            this.tabs[tab].active = true;
        },

        removeError(field, language) {
            this.errors[field][language] = false;
        },
    }
}
</script>