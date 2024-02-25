<x-mail::message>
# Nouveau message de contact de: {{ $name }}

**Email** :``{{ $email }}`` <br>
**Sujet** :``{{ $subject }}`` <br>
**Message** : <br> {{ $msg }}


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
