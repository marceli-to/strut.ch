export default {

    methods: {
        showAssetEdit(e) {
            let editForm = e.target.parentNode.nextElementSibling;
            editForm.classList.toggle('is-visible');
        },

        hideAssetEdit(e) {
            let editForm = e.target.parentNode;
            editForm.classList.toggle('is-visible');
        },

        changeTab(tab) {
            // set all tabs inactive and remove errors if any
            for (let prop in this.tabs) {
                this.tabs[prop].active = false;
                this.tabs[prop].error = false;
            }

            // set active tab
            this.tabs[tab].active = true;
        },

        removeError(field, language) {
            if (language) {
                this.errors[field][language] = false;
            } else {
                this.errors[field] = false;
            }
        },
    }
};
