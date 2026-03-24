export default {
    url: "/api/media/upload",
    method: 'post',
    maxFilesize: 200,
    maxFiles: 10,
    createImageThumbnails: false,
    acceptedFiles: '.mp4, .webm, .mov',
    headers: {
      'Authorization': 'Bearer ' + localStorage.getItem('token')
    }
}
