<?php

return [

    'coupon' => [
        'not_eligible_use_coupon' => 'Você não está qualificado para usar este código de cupom',
        'code_reached_maximum' => 'O código de cupom atingiu seu uso máximo',
        'must_least_total' => 'Você deve ter pelo menos um total de :amount',
        'max_discount_amount' => 'Isso tem um desconto máximo de :amount',
        'coupon_not_available' => 'Este cupom não está disponível',
        'must_use_discount_amount' => 'Você deve usar um valor de desconto.',
    ],
    'cart' => [
        'not_find_relation' => 'Não foi possível encontrar o modelo de relação',
        'not_find model' => 'Não foi possível encontrar o modelo de item para :arg',
        'item_limited_per_order' => 'Este item é limitado a itens :quantity por pedido.',
        'quantity_valid_num' => 'A quantidade deve ser um número válido',
        'price_must_valid_num' => 'O preço deve ser um número válido',
        'tax_must_number' => 'O imposto deve ser um número',
        'taxable_option_must_boolean' => 'A opção tributável deve ser um booleano',
    ],
    'misc' => [
        'invalid_gateway' => 'Configuração Inválida do Gateway',
        'product_code_exist' => 'O produto com código :arg existe no Gateway.',
        'create_gateway' => 'Falha ao criar produto do gateway :message',
        'update_gateway' => 'atualizar produto do gateway falhado :message',
        'delete_product' => 'Gateway deleteProduct falhado :message',
        'create_gateway_sku' => 'Criar sku do gateway falhado :message',
        'update_gateway_sku' => 'atualização sku do gateway falhou :message',
        'delete_sku' => 'Gateway deleteSKU falhou :message',
        'create_order_failed' => 'Falha ao criar pedido do Gateway :message',
        'invalid_order_code' => 'Código de pedido inválido :data',
        'update_gateway_order_failed' => 'atualizar pedido de gateway falhou :message',
        'order_already_paid' => 'O pedido já foi pago',
        'gateway_create_payment' => 'Gateway criar Token de Pagamento falhado :data',
        'least_should_upload' => 'Pelo menos um arquivo deve ser enviado',
    ],
    'sku' => [
        'item_has_only_quantity' => 'Este item tem apenas um total de :quantity quantidade disponível em estoque',
        'item_current_out' => 'Este item está fora de estoque',
        'invalid_custom' => 'Valor da opção personalizada inválido',
    ],
    'checkout' => [
        'invalid_coupon' => 'Código de cupom inválido',
    ],


];