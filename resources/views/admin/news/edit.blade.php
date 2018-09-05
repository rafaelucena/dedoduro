@extends('admin/layouts.app')

@section('custom_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css" rel="stylesheet" />
@endsection

@section('content')
    @include('admin/news/form')
@endsection

@section('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
<script>
// Integrate TinyMCE Editor
// Make Config Settings
var editor_config = {
    path_absolute : base_url,
    selector:'#description',
    height: 100,
    plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat',
    image_advtab: true,
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + '/tinymce/filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };
// Init TinyMCE
tinymce.init(editor_config);
    $(document).ready(function() {
        $('#source_id').select2({
            theme: "bootstrap",
            placeholder: 'Select a source...',
            minimumInputLength: 0,
            tokenSeparators: [',','.'],
        });
        $('#source_id').trigger('change');

        $('#personas_politicians').select2({
            theme: "bootstrap",
            placeholder: 'Select at least one politician...',
            minimumInputLength: 3,
            // maximumSelectionLength: 3,
            // delay : 100,
            tokenSeparators: [',','.'],
            ajax: {
                url: '{{ route('personas.ajaxSelect') }}',
                dataType: 'json',
                cache: true,
                data: function(params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1
                    };
                },
            },
            // templateResult: formatItem,
            // templateSelection: formatItem
        });
        $('#personas_politicians').trigger('change');

    });

// Count Char Helper
function countChar(val, id, limit) {
    leftChar = limit - val.value.length;
    $('#'+id).text( leftChar + " Characters Left");
}
</script>
@endsection
