$(function () {
    //CKEditor
    //CKEDITOR.replace('ckeditor');
    //CKEDITOR.config.height = 300;

    //TinyMCE
    tinymce.init({
        selector: "textarea.tinymce",
        theme: "modern",
        height: 140,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true,
        relative_urls : false,
        remove_script_host : false, 
        document_base_url : "http://localhost/PROJECTS/GROCERY/Ecom/assets/admin/"
    });
    tinymce.suffix = ".min";

    var root = location.protocol + '//' + location.host+"/";
    var pathparts = location.pathname.split('/');
    if (location.host == 'localhost') {
        root = location.origin+'/'+pathparts[1].trim('/')+'/'+pathparts[2].trim('/')+"/"+pathparts[3].trim('/')+'/';
    } else {
        root = location.origin+"/";
    }
    tinyMCE.baseURL = root+'assets/admin/plugins/tinymce';

});