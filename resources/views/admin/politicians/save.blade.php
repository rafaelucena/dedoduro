@extends('layouts/back')

@section('content')
    {{--@include('admin/politicians/form')--}}
    <div class="page-content">
        <div class="row margin-b-0">
            <div class="col s12 m12 l12">
                <div class="card no-shadow">
                    <div class="card-content">
                        <span class="card-title">Novo político</span>
                        <p>
                            Forms are the standard way to receive user inputted data. The transitions and smoothness of these elements are very important because of the inherent user interaction associated with forms.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row margin-b-0">
{{--            @include('admin/politicians/form')--}}
            <form method="post" action="{{ $formHelper->action }}" enctype="multipart/form-data" novalidate>
                @csrf
                {{ method_field($formHelper->method) }}
            <div class="col s12 m12 l6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Dados pessoais</span>
                        <div class="row margin-b-0">
                            <fieldset class="no-styles col s12">
                                <div class="row">
                                    <div class="input-field col s8">
                                        <input type="text" class="validate" id="short_name" name="short_name" data-error="wrong"
                                               value="{{ old('short_name', $persona->shortName) }}" maxlength="60" required>
                                        <label for="short_name" class="active">Nome associado</label>
                                        {{--<input placeholder="Placeholder" id="first_name" type="text" class="validate">--}}
                                        {{--<label for="first_name" class="active">First Name</label>--}}
                                    </div>
                                    <div class="input-field col s4">
                                        <select id="is_active">
                                            <option value="0">Não</option>
                                            <option value="1">Sim</option>
                                        </select>
                                        <label id="is_active" name="is_active">Publicar</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="first_name" name="first_name" type="text" class="validate" data-error="wrong"
                                               value="{{ old('first_name', $persona->firstName) }}" required>
                                        <label for="first_name" class="">Nome</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="last_name" name="last_name" type="text" class="validate" data-error="wrong"
                                               value="{{ old('last_name', $persona->lastName) }}" required>
                                        <label for="last_name" class="">Sobrenome</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="birthday" name="birthday" type="text" class="validate" data-error="wrong"
                                               value="{{ old('birthday', ''/*$persona->birthday*/) }}" required disabled="disabled">
                                        <label for="birthday" class="">Data de nascimento</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="gender" type="text" class="validate" data-error="wrong"
                                               value="{{ old('gender', ''/*$persona->gender*/) }}" required disabled="disabled">
                                        <label for="gender" class="">Gênero</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea id="description" class="materialize-textarea" length="120"></textarea>
                                        <label for="description">Descrição</label>
                                    </div>
                                </div>
                                </fieldset>
                            <button type="submit" class="btn teal rounded right-align">Criar</button>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col s12 m12 l6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Rotas</span>
                        <div class="row margin-b-0">
                            <fieldset class="no-styles col s12">
                                <div class="input-field col s12">
                                    <select class="form-control select2-input" id="slugs" name="slugs[]" multiple required>
                                        @if (is_array(old('slugs')))
                                            @foreach (old('slugs') as $oldSlug)
                                                <option value="{{ $oldSlug }}" selected="selected">
                                                    @if(is_numeric($oldSlug))
                                                        {{ app('em')->getRepository(App\Http\Models\Slug::class)->find($oldSlug)->name }}
                                                    @else
                                                        {{ $oldSlug }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        @else
                                            @foreach($persona->getSlugs() as $personaSlug)
                                                <option value="{{ $personaSlug->slug->id }}" selected>{{ $personaSlug->slug->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="slugs">Rotas</label>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Político</span>
                        <div class="row margin-b-0">
                            <fieldset class="no-styles col s12">
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="image" type="file" name="image" class="validate">
                                        <label for="image">Image</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <select id="party_id" name="party_id" class="validate" required>
                                            @foreach($parties as $party)
                                                @if ($loop->first)
                                                    <option value="">Selecione</option>
                                                @endif
                                                <option value="{{ $party->id }}" @if(old('party_id', $politician->getParty() ? $politician->getParty()->id : '') == $party->id) selected @endif>{{ $party->shortName }}</option>
                                            @endforeach
                                        </select>
                                        <label for=party_id"">Partido atual</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <select id="role_id" name="role_id" class="validate" required>
                                            @foreach($roles as $role)
                                                @if ($loop->first)
                                                    <option value="">Selecione</option>
                                                @endif
                                                <option value="{{ $role->id }}" @if(old('role_id', $politician->getRole() ? $politician->getRole()->id : '') == $role->id) selected @endif>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="role_id">Cargo recente</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <select id="role_wish_local_id" name="role_wish_local_id" class="validate" disabled="disabled" required>
                                            <option value="">Selecione</option>
                                            <option value="1">Nacional (Brasil)</option>
                                            <option value="2">Regional (DF)</option>
                                            <option value="3">Local (Goiânia)</option>
                                        </select>
                                        <label for="role_wish_local_id">Eleito por</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s3">
                                        <input id="number" name="number" type="text" class="validate" disabled="disabled" data-error="wrong"
                                               value="" maxlength="60" required>
                                        <label for="number">Número</label>
                                    </div>
                                    <div class="input-field col s3">
                                        <select id="length_id" name="length_id" disabled>
                                            <option value="1">2018-2022</option>
                                            <option value="2">2018-2026</option>
                                        </select>
                                        <label for="length_id">Termo (duração)</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <select id="is_role_still" name="is_role_still">
                                            <option value="1">Sim</option>
                                            <option value="0">Não</option>
                                        </select>
                                        <label for="is_role_still">Ainda ocupa o cargo?</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <select id="role_wish_id" name="role_wish_id" class="validate" required>
                                            @foreach($roles as $role)
                                                @if ($loop->first)
                                                    <option value="">Selecione</option>
                                                @endif
                                                <option value="{{ $role->id }}" @if(old('role_wish_id', $politician->getRoleWish() ? $politician->getRoleWish()->id : '') == $role->id) selected @endif>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="role_wish_id">Cargo desejado</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <select id="role_wish_local_id" name="role_wish_local_id" class="validate" disabled="disabled" required>
                                            <option value="">Selecione</option>
                                            <option value="1">Nacional (Brasil)</option>
                                            <option value="2">Regional (DF)</option>
                                            <option value="3">Local (Goiânia)</option>
                                        </select>
                                        <label for="role_wish_local_id">Elegível por</label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('custom_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
    <script>
        // Integrate TinyMCE Editor
        // Make Config Settings
        // var editor_config = {
        //     path_absolute : base_url,
        //     selector:'#description',
        //     height: 100,
        //     plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
        //     toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat',
        //     image_advtab: true,
        //     relative_urls: false,
        //     file_browser_callback : function(field_name, url, type, win) {
        //         var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        //         var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
        //
        //         var cmsURL = editor_config.path_absolute + '/tinymce/filemanager?field_name=' + field_name;
        //         if (type == 'image') {
        //             cmsURL = cmsURL + "&type=Images";
        //         } else {
        //             cmsURL = cmsURL + "&type=Files";
        //         }
        //
        //         tinyMCE.activeEditor.windowManager.open({
        //             file : cmsURL,
        //             title : 'Filemanager',
        //             width : x * 0.8,
        //             height : y * 0.8,
        //             resizable : "yes",
        //             close_previous : "no"
        //         });
        //     }
        // };
        // // Init TinyMCE
        // tinymce.init(editor_config);

        $(document).ready(function() {
            function formatItem (item) {
                if (!item.id) {
                    return item.text;
                }
                return $('<span>' + item.text + '</span>');
            }

            $('.select2-input').select2({
                theme: "material",
                tags: true,
                placeholder: '{{ $formHelper->select2Helper->placeholder }}',
                minimumInputLength: 2,
                maximumSelectionLength: 3,
                delay : 100,
                tokenSeparators: [',','.'],
                ajax: {
                    url: '{{ $formHelper->select2Helper->ajaxUrl }}',
                    dataType: 'json',
                    cache: true,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        };
                    },
                },
                templateResult: formatItem,
                templateSelection: formatItem
            });
            $('.select2-input').trigger('change');
        });
    </script>
@endsection
