@component('mail::message')
# FASHI

Dear {{ $user['user_name'] }} thank you for message us. We are processesing your request and we are happy to tell you that "{!! $reply->reply !!}".


Thanks,<br>
Team Fashi.
@endcomponent
