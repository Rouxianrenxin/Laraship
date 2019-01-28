<?php

return [

    'feature' => [
        'display_order' => 'Ordem',
        'id' => 'Identidade',
        'name' => 'Nome',
        'caption' => 'Rubrica',
        'unit' => 'Unidade',
        'type' => 'Tipo',
        'type_option' => [
            'quantity' => 'Quantidade',
            'text' => 'Texto',
            'boolean' => 'boleano',
        ],
        'description' => 'Descrição',
    ],
    'plan' => [
        'id' => 'Identidade',
        'name' => 'Nome',
        'name_help' => 'Um nome amigável para este plano, que será exibido em sua tabela de preços.',
        'price' => 'Preço',
        'price_help' => 'O custo deste plano, por período',
        'bill_cycle' => 'Ciclo de faturas',
        'display_order' => 'Ordem de exibição',
        'recommended' => 'Recomendado',
        'this_free_plan' => 'Este é um plano gratuito',
        'is_visible' => 'É visível?',
        'visible_help' => '<br/> O plano está visível na tabela de preços?',
        'description' => 'Descrição',
        'free_plan' => 'Plano Gratuito',
        'gateway_status' => 'Status do plano de gateway',
        'code' => 'Código',
        'code_help' => 'Um identificador exclusivo para este plano, que será usado para o plano de assinatura remota, se necessário.
                         por exemplo. plano de distribuição será criado se não existir',
        'create_gateway_plan' => 'Crie este plano no gateway',
        'bill_frequency' => 'Freqüência',
        'bill_cycle_every' => 'Cada',
        'every_options' => [
            'week' => 'Semana (s)',
            'month' => 'Mês (s)',
            'year' => 'Anos)',
        ],
        'trial_period' => 'Período de teste',
        'period_help' => 'O número de dias que os novos clientes neste plano devem receber uma avaliação gratuita.',
    ],
    'product' => [
        'image' => 'Imagem',
        'name' => 'Nome',
        'short_code' => 'Código curto',
        'description' => 'Descrição',
        'require_shipping_address' => 'Exigir o endereço de entrega no checkout',
        'clear' => 'Limpar a imagem atual.',
    ],
    'subscription' => [
        'subscription_reference' => 'Referência',
        'sub_reference' => 'Referência de Assinatura',
        'product_id' => 'produtos',
        'gateway' => 'Gateway',
        'subscription_statuses' => [
            'active' => 'Ativo',
            'cancelled' => 'Cancelado',
            'pending' => 'Pendente',
        ],
        'plan_id' => 'Plano',
        'user_id' => 'Do utilizador',
        'trial_ends_at' => 'Julgamento termina em',
        'ends_at' => 'Termina em',
        'on_trial' => 'Em julgamento',
        'description' => 'Descrição',
        'grace_period' => 'Período de carência',
        'pricing' => 'Preços',
        'select_payment_method' => 'Por favor selecione o método de pagamento',
        'next_billing_at' => 'Próximo faturamento em',
    ],


];