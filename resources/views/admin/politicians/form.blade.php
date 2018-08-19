<div class="card">
    <div class="card-header">{{ $formHelper->title }} <a href="{{ route('politicians.index') }}" class="btn btn-light float-right btn-sm "><i class="fas fa-chevron-left"></i> Go Back</a></div>

    <div class="card-body">
        <form method="post" action="{{ $formHelper->action }}" enctype="multipart/form-data" novalidate>
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
                        <label for="slugs">Slugs <span class="required">*</span></label>
                        <select class="form-control select2-input" id="slugs" name="slugs[]" required multiple>
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
                        <label for="party_id">Party <span class="required">*</span></label>
                        <select class="form-control" id="party_id" name="party_id" required>
                            @foreach($parties as $party)
                                <option value="{{ $party->id }}" @if(old('party_id', $politician->party ? $politician->party->id : '') == $party->id) selected @endif>{{ $party->shortName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role <span class="required">*</span></label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if(old('role_id', $politician->role ? $politician->role->id : '') == $role->id) selected @endif>{{ $role->name }}</option>
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
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ $formHelper->submit }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>