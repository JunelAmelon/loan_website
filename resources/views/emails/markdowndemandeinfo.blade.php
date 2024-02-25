<x-mail::message>
# Nouvelle Demande

Vous avez reçu une nouvelle demande de: ``{{$nom}} {{ $prenom }}``.<br>
Veuillez l'étudier et apporter votre décision.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
