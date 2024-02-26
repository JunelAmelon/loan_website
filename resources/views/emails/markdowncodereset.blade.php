<x-mail::message>
# Kód pro obnovení hesla

Váš kód pro obnovení hesla je ``{{ $resetCode }}``.<br>
Prosím, použijte tento kód k obnovení vašeho hesla.

Děkuji,<br>
{{ config('app.name') }}
</x-mail::message>
