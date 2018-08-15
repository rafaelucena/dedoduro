@extends('admin/layouts.app')

@section('custom_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css" rel="stylesheet" />
@endsection

@section('content')
<div class="card">
    <div class="card-header">Politicians - Edit <a href="{{ route('politicians.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
        <form method="post" action="{{ route('politicians.update', $politician->id) }}" enctype="multipart/form-data" novalidate>
            @csrf
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="short_name">Short name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="short_name" name="short_name" value="{{ old('short_name', $persona->shortName) }}" placeholder="Name the politician is recognized by..." maxlength="60" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="image">Featured Image (optional)</label>
                        <img class="img-fluid" src="{{ url( Storage::url($persona->image) ) }}" alt="{{ $persona->shortName }}">
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="first_name">First name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $persona->firstName) }}" placeholder="Pedro" maxlength="60" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="last_name">Last name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $persona->lastName) }}" placeholder="da Silva" maxlength="60" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="party_id">Party <span class="required">*</span></label>
                        <select class="form-control" id="party_id" name="party_id" required>
                            @foreach($parties as $party)
                                <option value="{{ $party->id }}" @if(old('party_id', $politician->party->id) == $party->id) selected @endif>{{ $party->shortName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="description">Description <span class="required">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="6" required>{!! old('description', $persona->description) !!}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="role_id">Role <span class="required">*</span></label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if(old('role_id', $politician->role->id) == $role->id) selected @endif>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="is_active">Publish <span class="required">*</span></label>
                        <select class="form-control" id="is_active" name="is_active" required>
                            <option value="1" @if(old('is_active', $politician->isActive) == 1) selected @endif>Yes</option>
                            <option value="0" @if(old('is_active', $politician->isActive) == 0) selected @endif>No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
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
    $('#categories').select2({
        theme: "bootstrap",
        tags: true,
        placeholder: "Choose Categories...",
        minimumInputLength: 2,
        delay : 200,
        tokenSeparators: [',','.'],
        ajax: {
            url: '{{ route("categories.ajaxSelectData") }}',
            dataType: 'json',
            cache: true,
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1
                };
            },
        }
    });
    $('#categories').trigger('change');
});

// Count Char Helper
function countChar(val, id, limit) {
    leftChar = limit - val.value.length;
    $('#'+id).text( leftChar + " Characters Left");
}
</script>
@endsection
