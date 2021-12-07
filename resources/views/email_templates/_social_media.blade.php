<div style="margin-left: 6%;margin-right: 6%;width:88%;">
    <div style="display: inline-block;margin-left: 6px" align="center">
        <a href="{{ url('/') }}" >Homepage</a>
    </div>
    <div style="display: inline-block;" align="center">
        <a href="{{ url('/') }}" >Account</a>
    </div>
    <div style="display: inline-block;" align="center">
        <a href="{{ $company->facebook }}" target="_blank">Facebook</a>
    </div>
    <div style="display: inline-block;" align="center">
        <a href="{{ $company->youtube }}" target="_blank">Youtube</a>
    </div>
    <div style="display: inline-block;" align="center">
        <a href="{{ $company->instagram }}" target="_blank">Instagram</a>
    </div>
</div>
<div style="margin-left: 6%;margin-right: 6%;width:88%;">
    <p style="margin-left: 6px">
        {{ $company->company_name .' - '. $company->city .' - '. $company->province .', '.$company->country }}
    </p>
</div>