<x-mail::message>
# Žádost byla ověřena

Dobrý den, pane {{ $nom }} {{ $prenom }}. <br>
Vaše žádost o půjčku ``{{ $montantDemande }} CZK`` byla schválena.
Celková částka k zaplacení, včetně úroků ve výši ``4%`` ročně, je ``{{ $montant_restant }} CZK``.
Musíte splácet částku ``{{ $montantMensuel }} CZK`` měsíčně po dobu ``{{ $dureeAnnees }}`` roku na účet číslo ``(Číslo účtu) v (Název banky)``. <br>
Pravidelně kontrolujte svůj účet při splácení, abyste se ujistili, že je správně zaznamenán.

Děkuji,<br>
{{ config('app.name') }}
</x-mail::message>
