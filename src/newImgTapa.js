var fileTypes = [
    'image/jpeg',
    'image/pjpeg',
    'image/png'
  ]
  
  function validFileType(file) {
    for(var i = 0; i < fileTypes.length; i++) {
      if(file.type === fileTypes[i]) {
        return true;
      }
    }
    console.log("archivo no valido");
    return false;
  }
function onChange(event) {
    var file = event.target.files[0];
    if(validFileType(file)) {
      var tapaThumb = document.getElementById('tapaThumb');
      tapaThumb.src = window.URL.createObjectURL(file);
    }}