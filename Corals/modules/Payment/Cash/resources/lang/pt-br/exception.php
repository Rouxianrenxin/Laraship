<?php

return [

    'request_did_not_contain' => 'A solicitação não continha um cabeçalho chamado `Cash-Signature`.',
    'the_signature_found_header_name' => 'A assinatura :name encontrada no cabeçalho "Cash-Signature" é inválida. Certifique-se de que
            a chave de configuração `services.Cash.webhook_signing_secret` é configurada com o valor encontrado no painel do Banco. Se você estiver armazenando em cache sua configuração, tente executar o `php artisan clear: cache` para resolver o problema.',
    'cash_sign_secret_not_set' => 'O segredo de assinatura do banco webhook não está definido. Certifique-se de que o `Cash.settings` esteja configurado conforme necessário.',
    'invalid_cash_payload' => 'Carga bancária inválida. Por favor, verifique WebhookCall: :arg',
    'invalid_cash_invoice_code' => 'Código de fatura do banco inválido. Por favor, verifique WebhookCall: :arg',
    'invalid_cash_subscription' => 'Referência de Subscrição Bancária Inválida. Por favor, verifique WebhookCall: :arg',
    'invalid_cash_customer' => 'Cliente bancário inválido. Por favor, verifique WebhookCall: :arg',
    'please_specify_amount_string' => 'Por favor, especifique o valor como uma string ou float.
             com casas decimais (por exemplo, 10,00 para representar US $ 10,00).',


];