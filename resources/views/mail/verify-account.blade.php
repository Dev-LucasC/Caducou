<x-mail::message>
# Valide sua conta

Bem-vindo ao Caducou. Confirme seu e-mail para liberar o acesso funcional ao painel.

<x-mail::button :url="$verificationUrl">
Validar e acessar o Dashboard
</x-mail::button>

Este link expira em 60 minutos. Se voce nao criou uma conta, ignore esta mensagem.

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>
