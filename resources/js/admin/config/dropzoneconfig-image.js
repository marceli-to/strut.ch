export default {
    url: "/api/media/upload",
    method: 'post',
    maxFilesize: 100,
    maxFiles: 1,
    createImageThumbnails: false,
    acceptedFiles: '.png, .jpg, .mp4, .webm, .mov',
    headers: {
      'Authorization': 'Bearer ' + localStorage.getItem('token')
    }
}