<x-mail::message>
# Code de Réinitialisation de mot de passe

Votre code de réinitialisation de mot de passe est ``{{ $resetCode }}``.<br>
Veuillez l'utiliser pour réinitialiser votre mot de passe.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
