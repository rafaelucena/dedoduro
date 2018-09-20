
<div id="action-box" class="box-body">
    <input id="action_id_{{ $backKey }}" name="action[id][]" type="hidden"
           value="{{ $action->id }}" class="form-control">
    <div class="col-md-4 form-group">
        <label for="action_title_{{ $backKey }}">Title <span class="required">*</span></label>
        <select id="action_title_{{ $backKey }}" name="action[title][]" class="form-control select2 action_title_select2" required>
            @if ($action->title)
            <option value="{{ old('action[title][]', $action->title) }}" selected>{{ $action->title }}</option>
            @endif
        </select>
    </div>
    <div class="col-md-8 form-group">
        <label for="action_subtitle_{{ $backKey }}">Subtítulo</label>
        <input id="action_subtitle_{{ $backKey }}" name="action[subtitle][]" type="text"
               value="{{ $action->subtitle }}" class="form-control" maxlength="255" required>
    </div>
    <div class="col-md-4 form-group">
        <label for="action_happened_at_{{ $backKey }}">Quando <span class="required">*</span></label>
        <input id="action_happened_at_{{ $backKey }}" name="action[happened_at][]" type="text"
               value="{{ $action->happenedAt ? $action->happenedAt->format('d-m-Y H:i') : '' }}" class="form-control" maxlength="60" required>
    </div>
    <div class="col-md-8 form-group">
        <label for="action_url_{{ $backKey }}">Url</label>
        <input id="action_url_{{ $backKey }}" name="action[url][]" type="text"
               value="{{ $action->url }}" class="form-control" maxlength="511" required>
    </div>
    <div class="col-md-4 form-group">
        <label for="action_type_id_{{ $backKey }}">Tema <span class="required">*</span></label>
        <select id="action_type_id_{{ $backKey }}" name="action[type_id][]" class="form-control" disabled required>
            <option value=""></option>
            <option value="1">Economia</option>
            <option value="2">Política</option>
            <option value="3">Criminal</option>
            <option value="4">Saúde</option>
        </select>
    </div>
    {{--<input type="hidden">--}}
    <div class="col-md-2 form-group">
        <label for="action_person_id_{{ $backKey }}">Posição/Voto <span class="required">*</span></label>
        <select id="action_person_id_{{ $backKey }}" name="action[person_type_id][]" class="form-control" required>
            <option value=""></option>
            @foreach($personaActionTypes as $personaActionType)
            <option value="{{ $personaActionType->id }}" @if (($personaAction->getPersonaActionType() ? $personaAction->getPersonaActionType()->id : '') == $personaActionType->id) selected @endif>{{ $personaActionType->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 form-group">
        <label for="action_is_relevant_{{ $backKey }}">Relevante <span class="required">*</span></label>
        <select id="action_is_relevant_{{ $backKey }}" name="action[is_relevant][]" class="form-control" required>
            <option value=""></option>
            <option value="1" @if($action->isRelevant === 1) selected @endif>Sim</option>
            <option value="0" @if($action->isRelevant === 0) selected @endif>Não</option>
        </select>
    </div>
    <div class="col-md-2 form-group">
        <label for="action_is_relevant_until_{{ $backKey }}">Relevante até</label>
        <input id="action_is_relevant_until_{{ $backKey }}" name="action[is_relevant_until][]" type="text" class="form-control" maxlength="60" required>
    </div>
    <div class="col-md-2 form-group">
        <label for="action_is_active_{{ $backKey }}">Público <span class="required">*</span></label>
        <select id="action_is_active_{{ $backKey }}" name="action[is_active][]" class="form-control" required>
            <option value=""></option>
            <option value="1" @if($personaAction->isActive === 1) selected @endif>Sim</option>
            <option value="0" @if($personaAction->isActive === 0) selected @endif>Não</option>
        </select>
    </div>
</div>