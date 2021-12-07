@component('mail::message')
# Team Deleted

This team no longer exists.

@component('mail::panel')
    Some features and services may not be accessible if your subscription was based on the team plan.
    Login to your account to see the changes.
@endcomponent

@component('mail::button', ['url' => route('account.index')])
View my account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent


Dear Marnes,

EagleEye registered a plartform and chose Ultimate plan. 

The tenant wants to use their own domain, in the meantime add their domain to server as addons domain.

Regards,
EagleEye

Dear Marnes,

EagleEye registered a plartform and chose Ultimate plan. 

The tenant wants to use sub domain, add their subdomain on the server.

Regards,
EagleEye


Dear EagleEye,

Thank you for registering your plartfom.

Please caontact your hosting provider to point your to this this IP Address: 5.189.174.191

Once you are done with pointing, please let Iconic Code Development know at info@iconiccodedevelopment.com.

Regards,
Iconic Code Development



