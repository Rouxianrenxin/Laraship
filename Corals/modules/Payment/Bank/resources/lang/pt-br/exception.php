<?php

return [

    'request_did_not_contain' => 'A solicitação não continha um cabeçalho chamado `Bank-Signature`.',
    'the_signature_found_header_name' => 'A assinatura :name encontrada no cabeçalho "Bank-Signature" é inválida. Certifique-se de que
            a chave de configuração `services.Bank.webhook_signing_secret` é configurada com o valor encontrado no painel do Banco. Se você estiver armazenando em cache sua configuração, tente executar o `php artisan clear: cache` para resolver o problema.',
    'bank_sign_secret_not_set' => 'O segredo de assinatura do banco webhook não está definido. Certifique-se de que o `Bank.settings` esteja configurado conforme necessário.',
    'invalid_bank_payload' => 'Carga bancária inválida. Por favor, verifique WebhookCall: :arg',
    'invalid_bank_invoice_code' => 'Código de fatura do banco inválido. Por favor, verifique WebhookCall: :arg',
    'invalid_bank_subscription' => 'Referência de Subscrição Bancária Inválida. Por favor, verifique WebhookCall: :arg',
    'invalid_bank_customer' => 'Cliente bancário inválido. Por favor, verifique WebhookCall: :arg',
    'please_specify_amount_string' => 'Por favor, especifique o valor como uma string ou float.
             com casas decimais (por exemplo, 10,00 para representar US $ 10,00).',


];