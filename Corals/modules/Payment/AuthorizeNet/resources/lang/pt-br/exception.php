<?php

return [

    'request_not_contain_header' => 'A solicitação não continha um cabeçalho chamado `AuthorizeNet-Signature`.',
    'signature_found_header_name' => 'A assinatura :name encontrada no cabeçalho chamado `AuthorizeNet-Signature` é inválida. Certifique-se de que o `services.AuthorizeNet.webhook_signing_secret`
                                      chave de configuração é definida para o valor que você encontrou no painel do AuthorizeNet. Se você estiver armazenando em cache sua configuração, tente executar o `php artisan clear: cache` para resolver o problema.',
    'authorize_webhook_sing_secret' => 'O segredo de assinatura do AuthorizeNet webhook não está definido. Certifique-se de que o `AuthorizeNet.settings` esteja configurado conforme necessário.',
    'invalid_authorize_payload' => 'Carga útil do AuthorizeNet inválida. Por favor, verifique WebhookCall: :arg',
    'invalid_authorize_invoice_code' => 'Código de fatura líquido de autorização inválido. Por favor, verifique Webhook Call: :arg',
    'invalid_authorize_subscription_Reference' => 'Invalid Authorize Net Subscription Reference. Por favor, verifique Webhook Call: :arg',
    'invalid_authorize_customer' => 'Inválido Autorizar Cliente Líquido. Por favor, verifique Webhook Call: :arg',
    'invalid_request_exception_specify_amount' => 'Especifique o valor como uma string ou float, com casas decimais (por exemplo, 10,00 para representar US $ 10,00)',


];