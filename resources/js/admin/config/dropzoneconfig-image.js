export default {
    url: "/api/media/upload",
    method: 'post',
    maxFilesize: 100,
    maxFiles: 1,
    createImageThumbnails: false,
    acceptedFiles: '.png, .jpg',
    headers: {
      'Authorization': 'Bearer ' + localStorage.getItem('token')
    }
}