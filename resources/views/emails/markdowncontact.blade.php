<x-mail::message>
# Nová zpráva od kontaktu od: {{ $name }}

**Email** :``{{ $email }}`` <br>
**Sběrka** :``{{ $subject }}`` <br>
**Zpráva** : <br> {{ $msg }}


Děkuji,<br>
{{ config('app.name') }}
</x-mail::message>
