<!-- Apply Modal -->
<div class="modal fade" id="postOpportunityModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyModalLabel">Post an Opportunity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('OpportunityPostStore') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Title -->
                            <div class="form-group row">
                                <label for="title" class="col-md-3 col-form-label">Title</label>
                                <div class="col-md-9">
                                    <input id="title" type="text" placeholder="Post Title" value="{{ old('title') }}" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" required autofocus>
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="form-group row">
                                <label for="category_id" class="col-md-3 col-form-label">Category</label>
                                <div class="col-md-9">
                                    <select name="category_id" id="category_id" class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" required>
                                        <option value="" disabled selected>Select a category</option>
                                        @foreach (App\Models\CRM\OppCategorie\OpportunityCategorie::all() as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <div class="text-danger mt-2">
                                            <p class="mb-0">{{ $errors->first('category') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group row">
                                <label for="description" class="col-md-3 col-form-label">Description</label>
                                <div class="col-md-9">
                                    <textarea name="description" id="editor" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" required>{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="text-danger mt-2">
                                            <p class="mb-0">{{ $errors->first('description') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Thumbnail Upload -->
                            <div class="form-group row">
                                <label for="file-input-logo" class="col-md-3 col-form-label">Upload Thumbnail</label>
                                <div class="col-md-9">
                                    <div class="d-flex align-items-center">
                                        <img id="preview-thumb" src="{{ asset('backend/assets/images/icons/favicon.png') }}" alt="preview" class="img-thumbnail mr-3" style="width: 90px;height: 90px">
                                        <input type="file" name="post_thumbnail" id="file-input-logo" class="form-control-file" required>
                                    </div>
                                    @if ($errors->has('post_thumbnail'))
                                        <div class="text-danger mt-2">
                                            <p class="mb-0">{{ $errors->first('post_thumbnail') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="form-group row">
                                <label for="status" class="col-md-3 col-form-label">Status</label>
                                <div class="col-md-9">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Live</option>
                                        <option value="0">Draft</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group row">
                                <div class="col-md-9 offset-md-3">
                                    <button class="btn btn-success" type="submit">Create Post</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
