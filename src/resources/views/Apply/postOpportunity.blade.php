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



<div class="card bg-white">
    <div class="card-body mt-5 mb-5">

        <form action="{{ route('OpportunityPostStore') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <div class="col-md-2">Title</div>
                <div class="col-md-4">
                    <input id="name" type="text" placeholder="Post Title" value="{{ old('title') }}" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value=""  autofocus="" required>
                    @if ($errors->has('title'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                     @endif


                 </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="category">Category:</label>
                </div>
                <div class="col-md-4">
                    <select name="category_id" id="category_id" class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" required>
                        @foreach (App\Models\CRM\OppCategorie\OpportunityCategorie::all() as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            
                        @endforeach
                    </select>
                    @if ($errors->has('category'))
                        <div style="color:red">
                            <p class="mb-0">{{ $errors->first('category') }}</p>
                        </div>
                    @endif

                 </div>
            </div>

            <div class="form-group row">
                <div class="col-md-2">Description</div>
                <div class="col-md-10">

                    <textarea name="description" id="editor" class="{{ $errors->has('description') ? ' is-invalid' : '' }}" required >{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <div style="color:red">
                            <p class="mb-0">{{ $errors->first('description') }}</p>
                        </div>
                    @endif
                 </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="file-input-logo">Upload post Thumbnail:</label>
                </div>
                <div class="col-md-4">
                    <div class="set_thumb">

                        <div id='settings-logo'>
                          <img id="preview-thumb" align='middle'src="{{ asset('backend/assets/images/icons/favicon.png') }}" alt="your image" title=''/>
                        </div>
                            <div class="fileUploadInput">
                                <input type="file" name="post_thumbnail" id="file-input-logo" required />
                                <button class="input-file-btn"><i class="material-icons"> cloud_upload </i></button>
                            </div>
                      </div>
                      @if ($errors->has('post_thumbnail'))
                            <div style="color:red">
                                <p class="mb-0">{{ $errors->first('post_thumbnail') }}</p>
                            </div>
                        @endif
                 </div>
            </div>

            <div class="form-group row">
                <div class="col-md-2">
                    <label for="status">Status:</label>
                </div>
                <div class="col-md-4">
                    <select name="status" id="status" class="form-control" required>
                        
                        <option value="1">Live</option>
                        <option value="0">Draft</option>
                            
                       
                    </select>
                

                 </div>
            </div>




            <div class="form-group pt-2 row">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <button class="theme-primary-btn btn btn-success" type="submit">Create post</button>
                   
                 </div>
            </div>

        </form>
  
    </div>
</div>
        
            </div>
        </div>
    </div>
</div>
