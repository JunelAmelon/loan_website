<x-mail::message>
# Žádost byla ověřena

Dobrý den, pane {{ $name }} {{ $prenom }}. <br>
Vaše žádost o půjčku ``{{ $montantDemande }}Kč`` byla schválena. <br>
Celková částka k zaplacení, včetně úroků ve výši ``4%`` ročně, je ``{{ $montant_restant }}Kč``. <br>
Musíte splácet částku ``{{ $montantMensuel }}Kč`` měsíčně po dobu ``{{ $dureeAnnees }}`` roku na účet číslo ``(Číslo účtu) v (Název banky)``. <br>
Pravidelně kontrolujte svůj účet při splácení, abyste se ujistili, že je správně zaznamenán.

Děkuji,<br>
{{ config('app.name') }}
</x-mail::message>
