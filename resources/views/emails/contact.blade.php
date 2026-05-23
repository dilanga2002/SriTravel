<x-mail::message>
# New Contact Form Submission

**Name:** {{ $name }}  
**Email:** {{ $email }}  
**Subject:** {{ $subject }}  
**Message:**  
{{ $messageContent }}

<x-mail::button :url="'mailto:' . $email">
Reply to Sender
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>