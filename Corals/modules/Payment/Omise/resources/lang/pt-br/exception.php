<?php

return [

    'request_did_not_contain' => 'A solicitação não continha um cabeçalho chamado `Omise-Signature`.',
    'signature_found_header_named' => 'A assinatura :name encontrada no cabeçalho chamado `Omise-Signature é inválida. Certifique-se de que o `services.omise.webhook_signing_secret`
                                        A chave de configuração é definida com o valor encontrado no painel do Omise. Se você estiver armazenando em cache sua configuração, tente executar o `php artisan clear: cache` para resolver o problema.',
    'stripe_secret_not_set' => 'O segredo de assinatura do Stripe Omise não está definido. Certifique-se de que o `omise.settings` esteja configurado conforme necessário.',
    'invalid_two_checked_payload' => 'Carga útil do Omise inválida. Por favor, verifique WebhookCall: :arg',
    'invalid_two_checked_invoice' => 'Código de fatura Omise inválido. Por favor, verifique WebhookCall: :arg',
    'invalid_two_checked_subscription' => 'Referência de assinatura Omise inválida. Por favor, verifique WebhookCall: :arg',
    'invalid_two_checked_customer' => 'Cliente do Omise inválido. Por favor, verifique WebhookCall: :arg',


];