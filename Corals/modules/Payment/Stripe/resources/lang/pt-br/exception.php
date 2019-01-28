<?php

return [

    'request_did_not_contain' => 'A solicitação não continha um cabeçalho chamado `Stripe-Signature`.',
    'signature_found_header_named' => 'A assinatura :name encontrada no cabeçalho chamado "Stripe-Signature" é inválida. Certifique-se de que a chave de configuração `services.stripe.webhook_signing_secret` esteja definida com o valor encontrado no painel Stripe.
                                    Se você estiver armazenando em cache sua configuração, tente executar o `php artisan clear: cache` para resolver o problema.',
    'stripe_secret_not_set' => 'O segredo de assinatura Stripe webhook não está definido. Certifique-se de que o `stripe.settings` esteja configurado conforme necessário.',
    'invalid_stripe_payload' => 'Carga útil de tarja inválida. Por favor, verifique WebhookCall: :arg',
    'invalid_stripe_invoice' => 'Código de Fatura de Lipe Inválido. Por favor, verifique WebhookCall: :arg',
    'invalid_stripe_subscription' => 'Referência de assinatura de listra inválida. Por favor, verifique WebhookCall: :arg',
    'invalid_stripe_customer' => 'Cliente de faixa inválido. Por favor, verifique WebhookCall: :arg',
    'source_transaction_required' => 'O parâmetro sourceTransaction ou transferGroup é obrigatório',
    'amount_is_too_high' => 'A precisão do valor é muito alta para a moeda.',
    'negative_not_allowed' => 'Um valor negativo não é permitido.',
    'zero_amount_not_allowed' => 'Uma quantidade zero não é permitida.',
    'must_pass_card' => 'Você deve passar o cartão ou o cliente',


];