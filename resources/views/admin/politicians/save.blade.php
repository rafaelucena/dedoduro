@extends('layouts/back')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Criar novo político
            <small>Inputs</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="general.html#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="general.html#">Forms</a></li>
            <li class="active">General Elements</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form method="post" action="{{ $formHelper->action }}" enctype="multipart/form-data" novalidate class="row">
            @csrf
            {{ method_field($formHelper->method) }}
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Dados pessoais</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <fieldset role="form">
                        <div class="box-body">
                            <div class="col-md-8 form-group">
                                <label for="short_name">Nome associado <span class="required">*</span></label>
                                <input type="text" class="form-control" id="short_name" name="short_name" value="{{ old('short_name', $persona->shortName) }}" placeholder="Nome como o político é reconhecido" maxlength="60" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="image">Imagem de perfil (recomendado)</label>
                                <img class="img-fluid" src="{{ url( Storage::url($persona->image) ) }}" alt="{{ $persona->shortName }}">
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="first_name">Nome <span class="required">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $persona->firstName) }}" placeholder="Fulano" maxlength="60" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="last_name">Sobrenome <span class="required">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $persona->lastName) }}" placeholder="do Plano Redondo" maxlength="60" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="birthday">Data de nascimento <span class="required">*</span></label>
                                <input type="text" class="form-control" id="birthday" name="birthday" value="" placeholder="" maxlength="60" disabled required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="gender">Gênero <span class="required">*</span></label>
                                <select id="gender" name="gender" class="form-control" disabled required>
                                    <option value="1">Masculino</option>
                                    <option value="2">Feminino</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="description">Descrição</label>
                                <textarea id="description" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </fieldset>
                </div>
                <!-- /.box -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Trajetória</h3>
                        <button id="add-new-trajectory" type="button" class="btn btn-success pull-right">Adicionar</button>
                        <button id="remove-trajectory" type="button" class="btn btn-danger pull-right">Remover</button>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <fieldset id="trajectory" role="form">
                        <div id="trajectory-box" class="box-body">
                            <div class="col-md-4 form-group">
                                <label for="trajectory_title">Título <span class="required">*</span></label>
                                <input id="trajectory_title" name="trajectory_title[]" type="text" class="form-control" maxlength="60" required>
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="trajectory_subtitle">Subtítulo <span class="required">*</span></label>
                                <input id="trajectory_subtitle" name="trajectory_subtitle[]" type="text" class="form-control" maxlength="60" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="trajectory_since">Desde <span class="required">*</span></label>
                                <input id="trajectory_since" name="trajectory_since[]" type="text" class="form-control" maxlength="60" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="trajectory_until">Até </label>
                                <input id="trajectory_until" name="trajectory_until[]" type="text" class="form-control" maxlength="60">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="trajectory_is_relevant">Relevante <span class="required">*</span></label>
                                <select id="trajectory_is_relevant" name="trajectory_is_relevant[]" class="form-control" required>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Acesso</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <fieldset role="form">
                        <div class="box-body">
                            <div class="col-md-12 form-group">
                                <label for="slugs">Rotas <span class="required">*</span></label>
                                <select class="form-control select2 select2-input" id="slugs" name="slugs[]" required multiple>
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
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="main_slug">Rota principal <span class="required">*</span></label>
                                <select class="form-control select2 select2-input" id="main_slug" name="main_slug" required>
                                    @if (is_array(old('slugs')))
                                        @foreach (old('slugs') as $oldSlug)
                                            @if ($loop->first)
                                                <option value="{{ $oldSlug }}" selected="selected">
                                                    @if(is_numeric($oldSlug))
                                                        {{ app('em')->getRepository(App\Http\Models\Slug::class)->find($oldSlug)->name }}
                                                    @else
                                                        {{ $oldSlug }}
                                                    @endif
                                                </option>
                                            @else
                                                @break
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($persona->getSlugs() as $personaSlug)
                                            @if ($loop->first)
                                                <option value="{{ $personaSlug->slug->id }}" selected>{{ $personaSlug->slug->name }}</option>
                                            @else
                                                @break
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="aux_slugs">Rotas auxiliares <span class="required">*</span></label>
                                <select class="form-control select2 select2-input" id="aux_slugs" name="aux_slugs[]" required multiple disabled>
                                    @if (is_array(old('slugs')))
                                        @foreach (old('slugs') as $oldSlug)
                                            @if ($loop->first)
                                                @continue
                                            @else
                                                <option value="{{ $oldSlug }}" selected="selected">
                                                    @if(is_numeric($oldSlug))
                                                        {{ app('em')->getRepository(App\Http\Models\Slug::class)->find($oldSlug)->name }}
                                                    @else
                                                        {{ $oldSlug }}
                                                    @endif
                                                </option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($persona->getSlugs() as $personaSlug)
                                            @if ($loop->first)
                                                @continue
                                            @else
                                                <option value="{{ $personaSlug->slug->id }}" selected>{{ $personaSlug->slug->name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </fieldset>
                </div>
                <!-- /.box -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Político</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <fieldset role="form">
                        <div class="box-body">
                            <div class="col-md-4 form-group">
                                <label for="party_id">Partido atual <span class="required">*</span></label>
                                <select class="form-control" id="party_id" name="party_id" required>
                                    @foreach($parties as $party)
                                        <option value="{{ $party->id }}" @if(old('party_id', $politician->getParty() ? $politician->getParty()->id : '') == $party->id) selected @endif>{{ $party->shortName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="role_id">Cargo recente <span class="required">*</span></label>
                                <select class="form-control" id="role_id" name="role_id" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" @if(old('role_id', $politician->getRole() ? $politician->getRole()->id : '') == $role->id) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="role_wish_local_id">Eleito por</label>
                                <select id="role_wish_local_id" name="role_wish_local_id" class="form-control" disabled required>
                                    <option value="">Selecione</option>
                                    <option value="1">Nacional (Brasil)</option>
                                    <option value="2">Regional (DF)</option>
                                    <option value="3">Local (Goiânia)</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="is_role_still">Ainda ocupa? <span class="required">*</span></label>
                                <select class="form-control" id="is_role_still" name="is_role_still" required>
                                    <option value="1" @if(old('is_role_still', $politician->isRoleStill) == 1) selected @endif>Sim</option>
                                    <option value="0" @if(old('is_role_still', $politician->isRoleStill) == 0) selected @endif>Não</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="role_id">Cargo desejado</label>
                                <select class="form-control" id="role_wish_id" name="role_wish_id">
                                    <option value=""></option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" @if(old('role_wish_id', $politician->getRoleWish() ? $politician->getRoleWish()->id : '') == $role->id) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="role_wish_local_id">Elegível por</label>
                                <select id="role_wish_local_id" name="role_wish_local_id" class="form-control" disabled required>
                                    <option value="">Selecione</option>
                                    <option value="1">Nacional (Brasil)</option>
                                    <option value="2">Regional (DF)</option>
                                    <option value="3">Local (Goiânia)</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="length_id">Termo (duração)</label>
                                <select id="length_id" name="length_id" class="form-control" disabled>
                                    <option value="1">2018-2022</option>
                                    <option value="2">2018-2026</option>
                                </select>
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="is_active">Publicar <span class="required">*</span></label>
                                <select class="form-control" id="is_active" name="is_active" required>
                                    <option value="1" @if(old('is_active', $politician->isActive) == 1) selected @endif>Sim</option>
                                    <option value="0" @if(old('is_active', $politician->isActive) == 0) selected @endif>Não</option>
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </fieldset>
                </div>

                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Votações/Ações</h3>
                        <button id="add-new-action" type="button" class="btn btn-warning pull-right">Adicionar</button>
                        <button id="remove-action" type="button" class="btn btn-danger pull-right">Remover</button>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <fieldset id="actions" role="form">
                        @forelse ($personaActions as $key => $personaAction)
                            @include ('admin/includes/partials/action-box-inputs', ['action' => $personaAction->getAction(), 'backKey' => (count($personaActions) - 1 - $key)])
                        @empty
                            @include ('admin/includes/partials/action-box-inputs', ['action' => new \App\Http\Models\Action(),'backKey' => 0])
                        @endforelse
                    </fieldset>
                </div>
            </div>
            <!--/.col (right) -->
        </form>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('custom_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
    <script>
        // Integrate TinyMCE Editor
        // Make Config Settings
        let editor_config = {
            path_absolute : base_url,
            selector:'#description',
            height: 100,
            plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat',
            image_advtab: true,
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
                let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                let cmsURL = editor_config.path_absolute + '/tinymce/filemanager?field_name=' + field_name;
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
            function formatItem (item) {
                if (!item.id) {
                    return item.text;
                }
                return $('<span>' + item.text + '</span>');
            }

            $('.select2-input').select2({
                theme: "bootstrap",
                tags: true,
                placeholder: 'Insira pelo menos uma rota...',
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

            // Trajectory section
            $("#add-new-trajectory").click(function() {
                $("#trajectory-box").clone().prependTo("#trajectory")
            });
            $("#remove-trajectory").click(function() {
                $('#trajectory-box:not(:first-child)').last().remove();
            });

            // START - Action title select2
                let actionTitleSelect2 = {
                    theme: "bootstrap",
                    tags: true,
                    placeholder: 'Busque aqui por votações já cadastradas...',
                    minimumInputLength: 1,
                    maximumSelectionLength: 3,
                    tokenSeparators: [',','.'],
                    ajax: {
                        url: '{{ route('actions.ajaxSelect') }}',
                        delay : 100,
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
                };
                $('.action_title_select2').select2(actionTitleSelect2);
                $('.action_title_select2').trigger('change');

                // Action section
                $("#add-new-action").click(function() {
                    // First we destroy the current select2
                    $('.action_title_select2').select2('destroy');

                    let cloneDiv = $('#action-box:first-child').clone();
                    let cloneInputId = '';

                    // Find each input with the class .form-control
                    cloneDiv.find('.form-control').each(function() {
                        // Get the 'id' of each of them
                        cloneInputId = $(this).attr('id');
                        // Replace only the number at the end of the string, with the current number plus one
                        cloneInputId = cloneInputId.replace(/\d+$/, (+(cloneInputId.split('_').pop()) + 1));
                        // Get then the element and set the new 'id'
                        cloneDiv.find(this).attr('id', cloneInputId);

                        // Check if it's also a select2 element by testing the native select2 attribute: data-select2-id
                        if ($(this).attr('data-select2-id') !== undefined) {
                            // If it exists, we also set this element for the incremented 'id'
                            cloneDiv.find(this).attr('data-select2-id', cloneInputId);
                        }
                    });

                    // Find each label
                    cloneDiv.find('label').each(function() {
                        // Get the 'for' of each of them
                        cloneInputId = $(this).attr('for');
                        // Replace only the number at the end of the string, with the current number plus one
                        cloneInputId = cloneInputId.replace(/\d+$/, (+(cloneInputId.split('_').pop()) + 1));
                        // Get then the element and set the new 'for'
                        cloneDiv.find(this).attr('for', cloneInputId);
                    });

                    cloneDiv.find('input').val('');
                    cloneDiv.find('select').val('');
                    cloneDiv.prependTo("#actions");

                    $('.action_title_select2').select2(actionTitleSelect2);
                    // $('.action_title_select2').trigger('change');
                });

                $("#remove-action").click(function() {
                    $('#action-box:not(:last-child)').first().remove();
                });

            $(document).on('change', '.action_title_select2', function() {
                let actionSelected = $(this).select2('data');
                let elementIdIterator = $(this).attr('id').split('_').pop();

                $(('#action_id_' + elementIdIterator)).val(actionSelected[0].id);
                $(('#action_url_' + elementIdIterator)).val(actionSelected[0].dataUrl);
                $(('#action_subtitle_' + elementIdIterator)).val(actionSelected[0].dataSubtitle);
                $(('#action_happened_at_' + elementIdIterator)).val(actionSelected[0].dataHappenedAt);
                $(('#action_is_relevant_' + elementIdIterator)).val(actionSelected[0].dataIsRelevant);
            });
            // END - Action title select2
        });
    </script>
@endsection
