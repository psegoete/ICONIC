
<div class="">
    <div class="">

            <h3 class="mb-0"><i class="fas fa-comment-dots"></i> Add reply</h3>
    </div>
    <div class="">
        <div class="comment-form">

            <form action="{{ url('account/comment') }}" method="POST" class="form" enctype="multipart/form-data">
                    {{ method_field('POST') }}
                {!! csrf_field() !!}

                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }} row">
                  <div class="col-md-12">
                    <label for="comment" class="col-form-label form-control-label">Message</label>
                    <textarea rows="4" id="comment" class="form-control" name="comment"></textarea>

                    @if ($errors->has('comment'))
                    <span class="help-block">
                        <strong>{{ $errors->first('comment') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-12">
                      <label for="status" class="control-label">Attachment (optional)
                        Only files smaller than 10MB</label>
                  <div class="row">
                      <div class="col-md-4 col-6">
                          <div class="dropzone-wrapper1">
                              <div class="dropzone-desc1">
                                  <div class="exist">
                                      <p id="empltyoriginalFile1"> No file uploaded yet  </p>
                                  </div>
                                  <div class="notExist">
                                      <p id="empltyoriginalFile"> No file uploaded yet  </p>
                                      <p id="originalFile"> </p>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-8 col-6">
                      <div class="form-group">
                          
                          <div class="dropzone-wrapper">
                          <div class="dropzone-desc">
                              <i class="fa fa-download"></i>
                              <p>Drop your file(s) here <br> </p>
                              <p class="btn btn-secondary clickButton">or click to browse</p>
                          </div>
                          <input type="file" name="comment_file" id="original_file" class="dropzone" onchange="readURL(this);" >
                          </div>
                      </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="existFile">
                          <div class="col-md-1 col-1">
                          </div>
                      </div>
                      <div class="existFile">
                          <div class="col-md-1 col-1">

                          </div>
                      </div>
          
                      <div class="notExistFile">
                          <div class="col-md-1 col-1 import">
                          </div>
                      </div>
                      <div class="notExistFile ">
                          <div class="col-md-1 col-1 deleteOriginalFile">
                          </div>
                      </div>
                  </div>
                  </div>
              </div>
              <div class="form-group row">
                <div class="col-12">
                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck"  name="status" {{ old('status') ? 'checked' : '' }}>
                      <label class="custom-control-label" for="customCheck"> Mark ticket as closed</label>
                  </div>
                </div>
          </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>






K=~NaH*{Hz}x