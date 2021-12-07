<form method="POST" action="{{ route('platformsettings') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('starter_credits') ? ' has-error' : '' }} row">
        <div class="col-md-6">
            <label class="col-form-label" for="starter_credits">Give new users starter credits</label>
                <select class="form-control{{ $errors->has('starter_credits') ? ' is-invalid' : '' }} " required="required" id="starter_credits" name="starter_credits" @>
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>

                @if ($errors->has('starter_credits'))
                    <span class="text-danger">{{ $errors->first('starter_credits') }}</span>
                @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('zip_file_service_files') ? ' has-error' : '' }} row">
        <div class="col-md-6">
            <label class="col-form-label" for="zip_file_service_files">Zip file service files</label>
                <select class="form-control{{ $errors->has('zip_file_service_files') ? ' is-invalid' : '' }} " required="required" id="zip_file_service_files" name="zip_file_service_files" @>
                    <option value="all">Always</option>
                    <option value="except">All but some (specify below)</option>
                    <option value="none" selected="selected">Never</option>
                </select>

                @if ($errors->has('zip_file_service_files'))
                    <span class="text-danger">{{ $errors->first('zip_file_service_files') }}</span>
                @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('original_zip_files_for_tuners') ? ' has-error' : '' }} row">
        <div class="col-md-6">
            <label class="col-form-label" for="original_zip_files_for_tuners">Add WinOLS ini file to original zip files for tuners</label>
                <select class="form-control{{ $errors->has('original_zip_files_for_tuners') ? ' is-invalid' : '' }} " required="required" id="original_zip_files_for_tuners" name="original_zip_files_for_tuners" @>
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>

                @if ($errors->has('original_zip_files_for_tuners'))
                    <span class="text-danger">{{ $errors->first('original_zip_files_for_tuners') }}</span>
                @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('evc_enabled') ? ' has-error' : '' }} row">
        <div class="col-md-6">
            <label class="col-form-label" for="evc_enabled">EVC</label>
                <select class="form-control{{ $errors->has('evc_enabled') ? ' is-invalid' : '' }} " required="required" id="evc_enabled" name="evc_enabled" >
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>

                @if ($errors->has('evc_enabled'))
                    <span class="text-danger">{{ $errors->first('evc_enabled') }}</span>
                @endif
        </div>
    </div>


    <div class="form-group{{ $errors->has('notes_to_customers') ? ' has-error' : '' }} row">
        <div class="col-md-6">
            <label for="notes_to_customers">Notes to customers</label>
            <textarea name="notes_to_customers" id="notes_to_customers" cols="30" rows="10" class="form-control{{ $errors->has('notes_to_customers') ? ' is-invalid' : '' }} summernote">{{ old('notes_to_customers', $PlatformSetting->notes_to_customers) }}</textarea>

                @if ($errors->has('notes_to_customers'))
                <span class="text-danger">{{ $errors->first('notes_to_customers') }}</span>
                @endif
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary" onclick="this.disabled=true;this.form.submit();">
            Save
        </button>
    </div>
</form>