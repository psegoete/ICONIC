<form method="POST" action="{{ route('legaldocuments') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('privancy_policy') ? ' has-error' : '' }} ">
        <label for="privancy_policy">Privancy policy</label>
        <textarea name="privancy_policy" id="privancy_policy" cols="30" rows="10" class="form-control{{ $errors->has('privancy_policy') ? ' is-invalid' : '' }} summernote">{{ old('privancy_policy', $LegalDocument->privancy_policy) }}
        </textarea>

        @if ($errors->has('privancy_policy'))
        <span class="text-danger">{{ $errors->first('privancy_policy') }}</span>
        @endif
    </div>
    

    <div class="form-group{{ $errors->has('refund_policy') ? ' has-error' : '' }} ">
        <label for="refund_policy">Refund policy</label>
        <textarea name="refund_policy" id="refund_policy" cols="30" rows="10" class="form-control{{ $errors->has('refund_policy') ? ' is-invalid' : '' }} summernote">{{ old('refund_policy', $LegalDocument->refund_policy) }}</textarea>
        
        @if ($errors->has('refund_policy'))
            <span class="text-danger">{{ $errors->first('refund_policy') }}</span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('terms_and_conditions') ? ' has-error' : '' }} ">
        <label for="terms_and_conditions">Terms and conditions</label>
        <textarea name="terms_and_conditions" id="terms_and_conditions" cols="30" rows="10" class="form-control{{ $errors->has('terms_and_conditions') ? ' is-invalid' : '' }} summernote">{{ old('terms_and_conditions', $LegalDocument->terms_and_conditions) }}</textarea>

        @if ($errors->has('terms_and_conditions'))
        <span class="text-danger">{{ $errors->first('terms_and_conditions') }}</span>
        @endif
    
    </div>

    <div class="form-group{{ $errors->has('disclaimer') ? ' has-error' : '' }} ">
        <label for="disclaimer">Disclaimer</label>
        <textarea name="disclaimer" id="disclaimer" cols="30" rows="10" class="form-control{{ $errors->has('disclaimer') ? ' is-invalid' : '' }} summernote">{{ old('disclaimer', $LegalDocument->disclaimer) }}</textarea>
        
        @if ($errors->has('disclaimer'))
            <span class="text-danger">{{ $errors->first('disclaimer') }}</span>
        @endif
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary" onclick="this.disabled=true;this.form.submit();">
            Save
        </button>
    </div>
</form>