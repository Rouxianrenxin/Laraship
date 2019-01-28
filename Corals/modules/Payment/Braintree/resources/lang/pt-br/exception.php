<?php

return [

    'request_did_not_contain_header_named' => 'A solicitação não continha um cabeçalho chamado `Braintree-Signature`.',
    'the_signature_found_header_named' => 'A assinatura :name encontrada no cabeçalho chamado `Braintree-Signature` é inválida. Certifique-se de que a chave de configuração `services.braintree.webhook_signing_secret` esteja configurada com o valor encontrado no painel do Braintree.
            Se você estiver armazenando em cache sua configuração, tente executar o `php artisan clear: cache` para resolver o problema.',
    'braintree_webhook_sing_secret_not_set' => 'O segredo de assinatura do webhook do Braintree não está definido. Certifique-se de que o `braintree.settings` esteja configurado conforme necessário.',
    'invalid_braintree_payload' => 'Carga útil do Braintree inválida. Por favor, verifique WebhookCall: :arg',
    'invalid_braintree_invoice_code' => 'Código de fatura Braintree inválido. Por favor, verifique WebhookCall: :arg',
    'invalid_braintree_subscription_reference' => 'Referência de assinatura Braintree inválida. Por favor, verifique WebhookCall: :arg',
    'invalid_braintree_customer' => 'Cliente Braintree inválido. Por favor, verifique WebhookCall: :arg',
    'braintree_library_requires_extension' => 'A biblioteca Braintree requer a extensão :name.',
    'invalid_request_exception_specify_amount' => 'Especifique o valor como uma string ou float, com casas decimais (por exemplo, 10,00 para representar US $ 10,00)',


];