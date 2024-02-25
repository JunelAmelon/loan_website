<x-mail::message>
# Nová žádost

Obdrželi jste novou žádost od: ``{{$nom}} {{ $prenom }}``.<br>
Prosím, zvažte ji a učiňte své rozhodnutí.

Děkuji,<br>
{{ config('app.name') }}
</x-mail::message>
