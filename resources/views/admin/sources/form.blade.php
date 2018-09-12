<div class="card">
    <div class="card-header">{{ $formHelper->title }} <a href="{{ route('sources.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
        <form method="post" action="{{ $formHelper->action }}">
            @csrf
            {{ method_field($formHelper->method) }}
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="name">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $source->name) }}"
                               placeholder="Write the source name" maxlength="150" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="short_name">Short name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="short_name" name="short_name" value="{{ old('short_name', $source->shortName) }}"
                               placeholder="Write a short name for the source" maxlength="150" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="url">Url <span class="required">*</span></label>
                        <input type="text" class="form-control" id="url" name="url" value="{{ old('url', $source->url) }}"
                               placeholder="http://www.fakenews.com/" maxlength="150" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="is_active">Publish <span class="required">*</span></label>
                        <select class="form-control" id="is_active" name="is_active" required>
                            <option value="1" @if(old('is_active', $source->isActive) == 1) selected @endif>Yes</option>
                            <option value="0" @if(old('is_active', $source->isActive) == 0) selected @endif>No</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ $formHelper->submit }}</button>
        </form>
    </div>
</div>