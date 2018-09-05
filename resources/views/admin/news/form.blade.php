<div class="card">
    <div class="card-header">{{ $formHelper->title }} <a href="{{ route('news.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
        <form method="post" action="{{ $formHelper->action }}" enctype="multipart/form-data" novalidate>
            @csrf
            {{ method_field($formHelper->method) }}
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title_s">Title <span class="required">*</span></label>
                        <select class="form-control" id="title_s" name="title_s" required>
                            @if ($news->title)
                                <option value="{{ old('title', $news->title) }}" selected>{{ $news->title }}</option>
                            @endif
                        </select>
                        {{--<label for="title">Title <span class="required">*</span></label>--}}
                        {{--<input type="text" class="form-control" id="title" name="title"--}}
{{--                               value="{{ old('title', $news->title) }}" placeholder="Title of the news..." maxlength="127" required>--}}
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="role_id">Source <span class="required">*</span></label>
                    <select class="form-control" id="source_id" name="source_id" required>
                    @foreach($sources as $source)
                        <option value="{{ $source->id }}" @if(old('source_id', $news->id ? ($news->getSource() ? $news->getSource()->id : '') : '') == $source->id) selected @endif>{{ $source->name }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="url">Url <span class="required">*</span></label>
                        <input type="text" class="form-control" id="url" name="url"
                               value="{{ old('url', $news->url) }}" placeholder="https://www.etc.com/oh-well" maxlength="511" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="published_at">Published at <span class="required">*</span></label>
                        <input type="text" class="form-control" id="published_at" name="published_at"
                               value="{{ old('published_at', $news->publishedAt ? $news->publishedAt->format('Y-m-d H:i') : '') }}" placeholder="da Silva" maxlength="20" required>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="description">Description <span class="required">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="6" required>{!! old('description', $news->description) !!}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="personas_politicians">Politicians <span class="required">*</span></label>
                        <select class="form-control select2-input" id="personas_politicians" name="personas_politicians[]" required multiple>
                        @if (is_array(old('personas_politicians')))
                            @foreach (old('personas_politicians') as $oldPersonaPolitician)
                                <option value="{{ $oldPersonaPolitician }}" selected="selected">
                                @if(is_numeric($oldPersonaPolitician))
                                    {{ app('em')->getRepository(App\Http\Models\Persona::class)->find($oldPersonaPolitician)->firstName . ' ' . app('em')->getRepository(App\Http\Models\Persona::class)->find($oldPersonaPolitician)->lastName }}
                                @else
                                    {{ $oldPersonaPolitician }}
                                @endif
                                </option>
                            @endforeach
                        @else
                            @foreach($news->getPersonas(\App\Http\Models\News::RELATED_POLITICIANS) as $personaPolitician)
                                <option value="{{ $personaPolitician->id }}" selected>{{ $personaPolitician->firstName . ' ' . $personaPolitician->lastName }}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label for="party_id">Party <span class="required">*</span></label>--}}
                        {{--<select class="form-control" id="party_id" name="party_id" required>--}}
{{--                            @foreach($parties as $party)--}}
                                {{--<option value="{{ $party->id }}" @if(old('party_id', $politician->getParty() ? $politician->getParty()->id : '') == $party->id) selected @endif>{{ $party->shortName }}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="role_id">Role <span class="required">*</span></label>--}}
                        {{--<select class="form-control" id="role_id" name="role_id" required>--}}
{{--                            @foreach($roles as $role)--}}
                                {{--<option value="{{ $role->id }}" @if(old('role_id', $politician->getRole() ? $politician->getRole()->id : '') == $role->id) selected @endif>{{ $role->name }}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="is_active">Publish <span class="required">*</span></label>--}}
                        {{--<select class="form-control" id="is_active" name="is_active" required>--}}
                            {{--<option value="1" @if(old('is_active', $politician->isActive) == 1) selected @endif>Yes</option>--}}
                            {{--<option value="0" @if(old('is_active', $politician->isActive) == 0) selected @endif>No</option>--}}
                        {{--</select>--}}
                    {{--</div>--}}
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ $formHelper->submit }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>