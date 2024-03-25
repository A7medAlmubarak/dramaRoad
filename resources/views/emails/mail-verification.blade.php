@component('mail::message')
<h1 style="font-family: 'Great Vibes', cursive; font-size: 40px; color: #800000; text-align: center; margin-bottom: 20px;">DramaRod</h1>

# Mail verification

Your mail verification link will expire in 5 minutes.

@component('mail::button', ['url' => $link])
Verify
@endcomponent

Thanks,<br>
@endcomponent
