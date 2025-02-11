
'use strict';

/**
 * function for render image in DOM
 */
window.isUploading = false;
window.uploadProcess = 0;
function uploadImage(file_upload, div_out, url, data){
  let reader = new FileReader();
  reader.readAsDataURL(file_upload);
   reader.onload = function(e){

    let file_element = FileDOM(e, file_upload);
    div_out.prepend(file_element);
    postFile(url, file_upload, file_element, data);
  }
}

function FileDOM(e, file){

/*  <div class="media-element d-flex">
        <img src="/assets/images/icon/document-light.png" alt="">
        <input type="text" name="files[]" class="d-none">
        <div class="info">
            <span class="name">document.txt</span>
            <div class="progress" style="">
                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
        <i class="mdi mdi-close destroy"></i>
    </div>*/

    var elem = document.createElement("div");
        elem.classList.add('media-element');
    let src = '';
    if(isImage(file)){
        src =  e.target.result;
    }else{
        src = '/assets/images/icon/document-light.png';
    }

    elem.innerHTML = `<img src="${src}" alt="">
            <input type="text" name="files[]" class="d-none">
            <div class="info">
                <span class="name">${file.name}</span>
                <div class="progress" style="">
                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <i class="mdi mdi-check-circle finish-check" style="display:none;"></i>
            </div>
            <i class="mdi mdi-close destroy"></i>`;
    return elem;

}

function FileDOMImage(e){

    /*
    <div class="image">
      <i id="del-img" class="fa-solid fa-xmark"></i>
      <img src="" />
      <input type="text" class="d-none" name="gallery_uploaded[]" />
      <span class="progress-bar"></span>
      <div class="info-details"></div>
    </div>
    */

    var image = document.createElement("div");
        image.classList.add('image');

    const itag = document.createElement('i');
        itag.classList.add('fa-solid', 'fa-xmark');
        itag.setAttribute('id', 'del-img');

    var img = document.createElement('img')
        img.setAttribute('src', e.target.result);

    // var inp = document.createElement('input')
    //     inp.setAttribute('type', 'file');
    //     inp.classList.add('d-none');
    //     inp.setAttribute('name', 'gallery[]');

    var inp = document.createElement('input')
        inp.setAttribute('type', 'text');
        inp.classList.add('d-none');
        inp.setAttribute('name', 'gallery_uploaded[]');

    var prog = document.createElement('span')
        prog.classList.add('progress-bar')

    var details = document.createElement('div')
        details.classList.add('info-details')

    itag.onclick = function(e){
      e.target.parentElement.remove();
    }

    // file objec assign
    // let container = new DataTransfer();
    //   container.items.add(file_upload);
    // inp.files = container.files

    image.append(itag, img, inp, prog, details);
    return image;
}


function postFile(url, file, elem, data) {

    console.log(url);
    var token = document.querySelector('meta[name="csrf-token"').getAttribute('content');
    let progress = elem.getElementsByClassName('progress-bar')[0];
    let input_project_id = document.querySelector('#project-id');

    let cancelBtn = $(elem).find('.destroy');
    isUploading = true;
    uploadProcess++;

    let size = file.size / 1024 / 1024;
    let numStream = 1;
    if(size < 2 ){
        numStream = 1;

    }else if(size < 16){
        numStream = 5;

    }else if(size < 64){
        numStream = 10;

    }else if(size < 256){
        numStream = 15;

    }else{
        numStream = 20;
    }

    var uploader = new Resumable({
        // uploadMethod: 'POST',
        target: url,
        chunkSize: 4 * 1024 * 1024, // 1MB
        query:{
            _token: token,
            ...data,
        },
        testChunks: false, // Check if the chunk already exists
        simultaneousUploads: numStream,
        throttleProgressCallbacks: 1,
    });
    uploader.addFile(file);
    uploader.on('fileAdded', (file) => {
        console.log('prepare upload');
        console.log(uploader)
        uploader.upload();
    });
    uploader.on('progress', function(){
        let percent = Math.floor(uploader.progress() * 100);
        progress.style.width = percent + '%';
    });
    uploader.on('fileSuccess', function(file, resp){
        progress.parentElement.nextElementSibling.style.display = 'unset';
        progress.parentElement.remove();
        // progress.style.width = '100%';
        // progress.classList.remove('bg-warning')
        // progress.classList.add('bg-success');

        console.log('success upload file');
        console.log(file, resp);

        let response = JSON.parse(resp)
        uploadProcess--;
        if(uploadProcess < 1){
            isUploading = false;
        }
        if(response.status != 'success'){
            elem.remove();
            toastr.error(response.message);
            return false;
        }
        
        if(input_project_id && response.project_id){
            input_project_id.value = response.project_id;   
        }
        let input = elem.getElementsByTagName('input')[0];
        elem.dataset.id = response.media.id;
        input.value = JSON.stringify(response.media);
        cancelBtn.off('click');
    });
    uploader.on('fileError', function(file, resp){
        uploadProcess--;
        if(uploadProcess < 1){
            isUploading = false;
        }
        let response = JSON.parse(resp)
        elem.remove();
        toastr.error(response.message);
        return false;
    })

    cancelBtn.click(function(e){
        uploader.cancel();
        // httpRequest.abort();
        elem.remove();
        uploadProcess--;
        if(uploadProcess < 1){
            isUploading = false;
        }
    });

    // var formdata = new FormData();

    // formdata.append('image', file);
    // formdata.append('_token',token);
    // for(let key in data){
    //     formdata.append(key, data[key]);
    // }

    // var httpRequest = new XMLHttpRequest();
    // httpRequest.open('post', url);
    // httpRequest.setRequestHeader("Accept", "application/json");
    // // request.timeout = 45000;

    // httpRequest.upload.addEventListener('progress', function (e) {
    //     var file1Size = file.size;

    //     if (e.loaded <= file1Size) {
    //         var percent = Math.round(e.loaded / file1Size * 100);
    //         progress.style.width = percent + '%';
    //         // progress.innerHTML = percent + '%';
    //     }

    //     if(e.loaded == e.total){
    //         progress.style.width = '100%';
    //         // progress.innerHTML = '';
    //         progress.classList.remove('bg-warning')
    //         progress.classList.add('bg-success');
    //     }
    // });

    // httpRequest.onload = function() {
    //     let response = JSON.parse(this.response)
    //     uploadProcess--;
    //     if(uploadProcess < 1){
    //         isUploading = false;
    //     }
    //     if(response.status != 'success'){
    //         elem.remove();
    //         toastr.error(response.message);
    //         return false;
    //     }
        
    //     if(input_project_id && response.project_id){
    //         input_project_id.value = response.project_id;   
    //     }
    //     let input = elem.getElementsByTagName('input')[0];
    //     elem.dataset.id = response.media.id;
    //     input.value = JSON.stringify(response.media);
    //     cancelBtn.off('click');
    // }

    // httpRequest.onerror = function () {
    //     uploadProcess--;
    //     if(uploadProcess < 1){
    //         isUploading = false;
    //     }
    //     let response = JSON.parse(this.response)
    //     elem.remove();
    //     toastr.error(response.message);
    //     return false;
    // };
    // httpRequest.send(formdata);

    window.addEventListener('beforeunload', function (e) {
        if (isUploading) {
            e.preventDefault();
            e.returnValue = 'you are upload file, are you sure to leave'; // Some browsers show a default message
        }
    });
}
// function cancelUpload(httpRequest){
//     httpRequest.abort();
// }

/**
 * show Image on is upladed
 */

jQuery('.upload-named input[type="file"]').on('change', function(e){
    let file = e.target.files[0];
    let text = jQuery(e.target).parent().siblings('.name-file').html(file.name);
    let prevImage = jQuery(e.target).parent().prev('.image-prev');
    if(prevImage && isImage(file)){

        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(e){
            prevImage.find('img').attr('src', e.target.result) 
        }
    }
    // .find('img').attr('src') 
    console.log(file.type)
});
