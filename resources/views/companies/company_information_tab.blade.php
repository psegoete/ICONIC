<form method="POST" action="{{ route('companies.update', $company->id) }}" enctype="multipart/form-data">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
    <div class="form-group">
        <div>@include('layouts.partials.alerts._alerts')</div>
    </div>
    <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
      <label for="email">Name <span class="text-danger">*</span></label>
      <input type="text" class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }} " id="Name" placeholder="Enter comapny name" name="company_name"
      value="{{ old('company_name', $company->company_name) }}">

      @if ($errors->has('company_name'))
          <span class="text-danger">{{ $errors->first('company_name') }}</span>
      @endif
    </div>

    <div class="row">
      <div class="form-group{{ $errors->has('address1') ? ' has-error' : '' }} col-md-6">
          <label for="address1">Address line 1 <span class="text-danger">*</span></label>
          <input type="address1" class="form-control{{ $errors->has('address1') ? ' is-invalid' : '' }} " id="address1" placeholder="Enter address1" name="address1"
          value="{{ old('address1', $company->address1) }}">
          @if ($errors->has('address1'))
              <span class="text-danger">{{ $errors->first('address1') }}</span>
          @endif
      </div>

      <div class="form-group{{ $errors->has('address2') ? ' has-error' : '' }} col-md-6">
          <label for="address2">Address line 2 <span class="text-danger">*</span></label>
          <input type="address2" class="form-control{{ $errors->has('address2') ? ' is-invalid' : '' }} " id="address2" placeholder="Enter address2" name="address2"
          value="{{ old('address2', $company->address2) }}">
          @if ($errors->has('address2'))
              <span class="text-danger">{{ $errors->first('address2') }}</span>
          @endif
      </div>
    </div>

    <div class="row">
      <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }} col-md-6">
          <label for="city">City <span class="text-danger">*</span></label>
        <input type="city" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }} " id="city" placeholder="Enter city" name="city"
        value="{{ old('city', $company->city) }}">
        @if ($errors->has('address2'))
              <span class="text-danger">{{ $errors->first('address2') }}</span>
          @endif
      </div>

      <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }} col-md-6">
          <label for="zipcode">Zipcode (optional)</label>
          <input type="zipcode" class="form-control{{ $errors->has('zipcode') ? ' is-invalid' : '' }} " id="zipcode" placeholder="Enter Zipcode" name="zipcode"
          value="{{ old('zipcode', $company->zipcode) }}">
          @if ($errors->has('address2'))
              <span class="text-danger">{{ $errors->first('address2') }}</span>
          @endif
      </div>
    </div>

    <div class="row">
      <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }} col-md-6">
          <label for="country">Country <span class="text-danger">*</span></label>
          <select id="country" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}  dropdown-toggle country" name="country"
            value="{{ old('country', $company->country) }}">
              <option value="{{ old('country', $company->country) }}">South Africa</option>
          </select>
          @if ($errors->has('address2'))
              <span class="text-danger">{{ $errors->first('address2') }}</span>
          @endif
      </div>
      
      <div class="form-group{{ $errors->has('province') ? ' has-error' : '' }} col-md-6">
          <label for="province">State/Province (optional)</label>
          <input type="province" class="form-control{{ $errors->has('province') ? ' is-invalid' : '' }} " id="province" placeholder="Enter State/Province" name="province"
          value="{{ old('province', $company->province) }}">
          @if ($errors->has('address2'))
              <span class="text-danger">{{ $errors->first('address2') }}</span>
          @endif
      </div>
    </div>

    <div class="row">
      <div class="form-group{{ $errors->has('timezone') ? ' has-error' : '' }} col-md-6">
          <label for="timezone">Timezone</label>
          <select id="timezone" class="form-control{{ $errors->has('timezone') ? ' is-invalid' : '' }}  dropdown-toggle cars" name="timezone"
            value="{{ old('timezone', $company->timezone) }}">
              <option value="" selected="selected">Africa/Johannesburg</option>
          </select>
          @if ($errors->has('address2'))
              <span class="text-danger">{{ $errors->first('address2') }}</span>
          @endif
      </div>
    </div>

    <div class="row">
      <div class="form-group{{ $errors->has('company_email') ? ' has-error' : '' }} col-md-12">
          <label for="company_email">CONTACT INFORMATION</label>
          <p>Main email address <span class="text-danger">*</span></p>
        <input type="text" class="form-control{{ $errors->has('company_email') ? ' is-invalid' : '' }} " id="company_email" placeholder="Enter main email address" name="company_email"
        value="{{ old('company_email', $company->company_email) }}">
        @if ($errors->has('address2'))
              <span class="text-danger">{{ $errors->first('address2') }}</span>
          @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-3 col-form-label" for="hf-name"></label>
      <div class="col-md-6">
          {{--  <label for="status" class="control-label">Attachment (optional)
            Only files smaller than 10MB</label>  --}}
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
                  <i class="fa fa-file"></i>
                  <p>Drop your file(s) here <br> </p>
                  <p class="btn btn-secondary clickButton">or click to browse</p>
                  
              </div>
              <input type="file" name="company_logo" id="original_file" class="dropzone" onchange="readURL(this);" >
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
      
    {{-- <div class="row">
        <div class="form-group{{ $errors->has('google_analytics_code') ? ' has-error' : '' }} col-md-12">
            <label for="SupportEmailAddress">Support email address</label>
          <input type="text" class="form-control{{ $errors->has('starter_credits') ? ' is-invalid' : '' }} " id="SupportEmailAddress" placeholder="Enter support email address" name="SupportEmailAddress">
          @if ($errors->has('address2'))
              <span class="text-danger">{{ $errors->first('address2') }}</span>
          @endif
        </div>

    </div>

    <div class="row">
        <div class="form-group{{ $errors->has('starter_credits') ? ' has-error' : '' }} col-md-12">
            <label for="billingEmailAddress">Billing email address</label>
          <input type="text" class="form-control{{ $errors->has('starter_credits') ? ' is-invalid' : '' }} " id="billingEmailAddress" placeholder="Enter billing email address" name="billingEmailAddress">
          @if ($errors->has('address2'))
              <span class="text-danger">{{ $errors->first('address2') }}</span>
          @endif
        </div>
    </div> --}}

    <div class="row">
      <div class="form-group{{ $errors->has('company_phone') ? ' has-error' : '' }} col-md-12">
          <label for="company_phone">Phone number (optional)</label>
        <input type="text" class="form-control{{ $errors->has('company_phone') ? ' is-invalid' : '' }} " id="company_phone" placeholder="Enter phone number" name="company_phone"
        value="{{ old('company_phone', $company->company_phone) }}">
        @if ($errors->has('company_phone'))
              <span class="text-danger">{{ $errors->first('company_phone') }}</span>
          @endif
      </div>
    </div>

    

    <div class="row">
      <div class="form-group{{ $errors->has('bank_account') ? ' has-error' : '' }} col-md-12">
          <label for="bank_account">FINANCIAL INFORMATION</label>
          <p>Bank account  (optional)</p>
        <input type="text" class="form-control{{ $errors->has('bank_account') ? ' is-invalid' : '' }} " id="bank_account" placeholder="Enter bank account" name="bank_account"
        value="{{ old('bank_account', $company->bank_account) }}">
        @if ($errors->has('bank_account'))
              <span class="text-danger">{{ $errors->first('bank_account') }}</span>
          @endif
      </div>
    </div>

    <div class="row">
        <div class="form-group{{ $errors->has('bank_identification_code') ? ' has-error' : '' }} col-md-12">
            <label for="bank_identification_code">Bank Identification Code (BIC) (optional)</label>
          <input type="text" class="form-control{{ $errors->has('bank_identification_code') ? ' is-invalid' : '' }} " id="bank_identification_code" placeholder="Enter bank identification code (BIC)" name="bank_identification_code"
          value="{{ old('bank_identification_code', $company->bank_identification_code) }}">
          @if ($errors->has('bank_identification_code'))
              <span class="text-danger">{{ $errors->first('bank_identification_code') }}</span>
          @endif
        </div>
    </div>

    <div class="row">
        <div class="form-group{{ $errors->has('chamber_of_commernce_number') ? ' has-error' : '' }} col-md-12">
            <label for="chamber_of_commernce_number">Chamber of Commerce number (optional)</label>
          <input type="text" class="form-control{{ $errors->has('chamber_of_commernce_number') ? ' is-invalid' : '' }} " id="chamber_of_commernce_number" placeholder="Enter chamber of commerce number" name="chamber_of_commernce_number"
          value="{{ old('chamber_of_commernce_number', $company->chamber_of_commernce_number) }}">
          @if ($errors->has('chamber_of_commernce_number'))
              <span class="text-danger">{{ $errors->first('chamber_of_commernce_number') }}</span>
          @endif
        </div>
    </div>

    <div class="row">
        <div class="form-group{{ $errors->has('tax_identifier') ? ' has-error' : '' }} col-md-12">
            <label for="tax_identifier">Tax identifier  (optional)</label>
          <input type="text" class="form-control{{ $errors->has('tax_identifier') ? ' is-invalid' : '' }} " id="tax_identifier" placeholder="Enter tax identifier" name="tax_identifier"
          value="{{ old('tax_identifier', $company->tax_identifier) }}">
          @if ($errors->has('tax_identifier'))
              <span class="text-danger">{{ $errors->first('tax_identifier') }}</span>
          @endif
        </div>
    </div>

    <div class="row">
        <div class="form-group{{ $errors->has('skype_username') ? ' has-error' : '' }} col-md-12">
            <label for="LINKS TO SOCIAL MEDIA">LINKS TO SOCIAL MEDIA</label>
            <p>Skype username (optional)</p>
          <input type="text" class="form-control{{ $errors->has('skype_username') ? ' is-invalid' : '' }} " id="skype_username" placeholder="Enter skype username" name="skype_username"
          value="{{ old('skype_username', $company->skype_username) }}">
        </div>
    </div>

    <div class="row">
        <div class="form-group{{ $errors->has('facebook') ? ' has-error' : '' }} col-md-12">
            <label for="facebook">Facebook (optional)</label>
          <input type="text" class="form-control{{ $errors->has('facebook') ? ' is-invalid' : '' }} " id="facebook" placeholder="Enter facebook" name="facebook"
          value="{{ old('facebook', $company->facebook) }}">
        </div>
    </div>

    <div class="row">
        <div class="form-group{{ $errors->has('twitter') ? ' has-error' : '' }} col-md-12">
            <label for="twitter">Twitter (optional)</label>
          <input type="text" class="form-control{{ $errors->has('twitter') ? ' is-invalid' : '' }} " id="twitter" placeholder="Enter twitter" name="twitter"
          value="{{ old('twitter', $company->twitter) }}">
        </div>
    </div>

    <div class="row">
        <div class="form-group{{ $errors->has('google') ? ' has-error' : '' }} col-md-12">
            <label for="google">Google+ (optional)</label>
          <input type="text" class="form-control{{ $errors->has('google') ? ' is-invalid' : '' }} " id="google" placeholder="Google+" name="google"
          value="{{ old('google', $company->google) }}">
        </div>
    </div>

  
    <div class="row">
        <div class="form-group{{ $errors->has('linkedin') ? ' has-error' : '' }} col-md-12">
            <label for="linkedin">LinkedIn (optional)</label>
          <input type="text" class="form-control{{ $errors->has('linkedin') ? ' is-invalid' : '' }} " id="linkedin" placeholder="LinkedIn" name="linkedin"
          value="{{ old('linkedin', $company->linkedin) }}">
        </div>
    </div>

    <div class="row">
        <div class="form-group{{ $errors->has('youtube') ? ' has-error' : '' }} col-md-12">
            <label for="youtube">Youtube (optional))</label>
          <input type="text" class="form-control{{ $errors->has('youtube') ? ' is-invalid' : '' }} " id="youtube" placeholder="youtube" name="youtube"
          value="{{ old('youtube', $company->youtube) }}">
        </div>
    </div>

    <div class="row">
        <div class="cform-group{{ $errors->has('instagram') ? ' has-error' : '' }} col-md-12">
            <label for="instagram">Instagram (optional)</label>
          <input type="text" class="form-control{{ $errors->has('instagram') ? ' is-invalid' : '' }} " id="instagram" placeholder="instagram" name="instagram"
          value="{{ old('instagram', $company->instagram) }}">
        </div>
    </div>
  
    <div class="row">
        <div class="form-group{{ $errors->has('pinterest') ? ' has-error' : '' }} col-md-12">
            <label for="pinterest">Pinterest (optional)</label>
          <input type="text" class="form-control{{ $errors->has('pinterest') ? ' is-invalid' : '' }} " id="pinterest" placeholder="pinterest" name="pinterest"
          value="{{ old('pinterest', $company->pinterest) }}">
        </div>
    </div>

    <div class="row">
        <div class="form-group{{ $errors->has('wechat') ? ' has-error' : '' }} col-md-12">
            <label for="wechat">Wechat (optional)</label>
          <input type="text" class="form-control{{ $errors->has('wechat') ? ' is-invalid' : '' }} " id="wechat" placeholder="wechat" name="wechat"
          value="{{ old('wechat', $company->wechat) }}">
        </div>
    </div>
    <div class="row">
        <div class="form-group{{ $errors->has('qq') ? ' has-error' : '' }} col-md-12">
            <label for="qq">QQ (optional)</label>
          <input type="text" class="form-control{{ $errors->has('qq') ? ' is-invalid' : '' }} " id="qq" placeholder="qq" name="qq"
          value="{{ old('qq', $company->qq) }}">
        </div>
    </div>
    <div class="row">
        <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }} col-md-12">
            <label for="website">Website (optional)</label>
          <input type="text" class="form-control{{ $errors->has('website') ? ' is-invalid' : '' }} " id="website" placeholder="website" name="website"
          value="{{ old('website', $company->website) }}">
        </div>
    </div>

    <div class="row">
        <div class="form-group{{ $errors->has('google_tag_manager_code') ? ' has-error' : '' }} col-md-12">
            <label for="google_tag_manager_code">SERVICES</label>
            <p>Google Tag Manager code (optional)</p>
          <input type="text" class="form-control{{ $errors->has('google_tag_manager_code') ? ' is-invalid' : '' }} " id="google_tag_manager_code" placeholder="Google Tag Manager code" name="google_tag_manager_code"
          value="{{ old('google_tag_manager_code', $company->google_tag_manager_code) }}">
        </div>
    </div>

    <div class="row">
        <div class="form-group{{ $errors->has('google_analytics_code') ? ' has-error' : '' }} col-md-12">
            <label for="google_analytics_code">Google Analytics code (optional)</label>
          <input type="text" class="form-control{{ $errors->has('google_analytics_code') ? ' is-invalid' : '' }} " id="google_analytics_code" placeholder="Google Analytics code" name="google_analytics_code"
          value="{{ old('google_analytics_code', $company->google_analytics_code) }}">
        </div>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-sm btn-primary" onclick="this.disabled=true;this.form.submit();">
          Save
      </button>
  </div>
  </form>