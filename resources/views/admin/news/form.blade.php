<div class="card">
    <div class="card-header">{{ $formHelper->title }} <a href="{{ route('news.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
        <form method="post" action="{{ $formHelper->action }}" enctype="multipart/form-data" novalidate>
            @csrf
            {{ method_field($formHelper->method) }}
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">Title <span class="required">*</span></label>
                        <select class="form-control" id="title" name="title" required>
                            @if ($news->title)
                                <option value="{{ old('title', $news->title) }}" selected>{{ $news->title }}</option>
                            @endif
                        </select>
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
                        <select class="form-control" id="url" name="url" required>
                            @if ($news->url)
                                <option value="{{ old('url', $news->url) }}" selected>{{ $news->url }}</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="published_at">Published at <span class="required">*</span></label>
                        <input type="text" class="form-control" id="published_at" name="published_at"
                               value="{{ old('published_at', $news->publishedAt ? $news->publishedAt->format('Y-m-d H:i') : '') }}" placeholder="1999-05-13 16:47" maxlength="20" required>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="6">{!! old('description', $news->description) !!}</textarea>
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
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ $formHelper->submit }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>