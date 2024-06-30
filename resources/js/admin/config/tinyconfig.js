export default {
    license_key: 'gpl',
    skin_url: '/assets/admin/js/_tinymce/skins/strut',
    branding: false,
    menubar: false,
    statusbar: false,
    // external_plugins: {
    //    link: '/assets/admin/js/tinymce/plugins/link/plugin.min.js',
    // },
    plugins: ['lists', 'code', 'link'],
    toolbar: 'undo redo | bold | link | superscript | removeformat | styles',
    paste_as_text: true,
    height : "240px",
    style_formats_merge: false,
    style_formats: [{
        title: 'Text',
        items: [
            { title: 'Worttrennung deaktivieren', inline: 'span', styles: { "white-space": 'nowrap' } },
        ],
    }]

}