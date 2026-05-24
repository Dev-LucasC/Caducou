<x-mail::message>
# Valide sua conta

Este e um e-mail de teste do Caducou para validar a configuracao local de envio.

<x-mail::button :url="$validationUrl">
Validar conta
</x-mail::button>

Se voce nao solicitou este acesso, ignore esta mensagem.

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>
