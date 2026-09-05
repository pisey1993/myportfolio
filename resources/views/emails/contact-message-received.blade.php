<x-mail::message>
# New contact form message

**Name:** {{ $contactMessage->name }}
**Email:** {{ $contactMessage->email }}
@if ($contactMessage->subject)
**Subject:** {{ $contactMessage->subject }}
@endif

{{ $contactMessage->message }}

<x-mail::button :url="route('admin.messages.show', $contactMessage)">
View in admin
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
