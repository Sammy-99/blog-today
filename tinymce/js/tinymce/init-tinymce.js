const image_upload_handler_callback = (blobInfo, progress) => new Promise((resolve, reject) => {
    
    const xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', 'controllers/Dashboard.php');
    
    xhr.upload.onprogress = (e) => {
        progress(e.loaded / e.total * 100);
    };
    
    xhr.onload = () => {
        
        if (xhr.status === 403) {
            reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
            return;
        }
      
        if (xhr.status < 200 || xhr.status >= 300) {
            reject('HTTP Error: ' + xhr.status);
            return;
        }
      
        const json = JSON.parse(xhr.responseText);
      
        if (!json || typeof json.location != 'string') {
            reject('Invalid JSON: ' + xhr.responseText);
            return;
        }

        
        resolve(json.location);
    };
    
    xhr.onerror = () => {
        reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
    };
    
    const formData = new FormData();
    formData.append('file', blobInfo.blob(), blobInfo.filename());
    
    xhr.send(formData);
});

tinymce.init({
    selector : "textarea#text_editor",
    branding: false,
    menubar: true,
    plugins: "lists advlist anchor link autosave preview fullscreen visualblocks table image autolink codesample media quickbars code charmap directionality emoticons help pagebreak searchreplace template wordcount ",
    toolbar: "undo redo | styleselect | " +
            "bold italic underline | sizeselect | fontselect | fontsizeselect | forecolor backcolor | restoredraft | " +
            "alignleft aligncenter alignright alignjustify | emoticons | " +
            "bullist numlist | preview | fullscreen | outdent indent | codesample | ltr rtl | " +
            "table | anchor | link unlink | image | code | media | hr | visualblocks | charmap | fullpage | searchreplace | paste pastetext | template | pagebreak | wordcount | help",
    allow_html_in_named_anchor: true,
    autosave_ask_before_unload: true,
    codesample_global_prismjs: true,   
    imagetools_toolbar: 'rotateleft rotateright | flipv fliph | editimage imageoptions', 
    link_assume_external_targets: true,
    pagebreak_split_block: true,
    pagebreak_separator: '<!-- my page break -->',
    paste_block_drop: true,
    images_upload_url: "controllers/Dashboard.php",
    images_upload_handler: image_upload_handler_callback,
    codesample_global_prismjs: true,
    codesample_languages: [
        { text: 'HTML/XML', value: 'markup' },
        { text: 'JavaScript', value: 'javascript' },
        { text: 'CSS', value: 'css' },
        { text: 'PHP', value: 'php' },
        { text: 'Ruby', value: 'ruby' },
        { text: 'Python', value: 'python' },
        { text: 'Java', value: 'java' },
        { text: 'C', value: 'c' },
        { text: 'C#', value: 'csharp' },
        { text: 'C++', value: 'cpp' }
      ]

});

