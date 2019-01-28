<?php

return [

    'advertiser' => [
        'name' => 'Nome',
        'contact' => 'Contato',
        'email' => 'O email',
        'notes' => 'Notas',
    ],
    'banner' => [
        'name' => 'Nome',
        'campaign' => 'Campanha',
        'dimension' => 'Dimensão',
        'type' => 'Tipo',
        'type_options' => [
            'script' => 'Roteiro',
            'media' => 'meios de comunicação',
            'link' => 'Ligação',
        ],
        'weight' => 'Peso',
        'notes' => 'Notas',
        'url' => 'URL',
    ],
    'campaign' => [
        'name' => 'Nome',
        'advertiser' => 'Anunciante',
        'starts_at' => 'Começa em',
        'ends_at' => 'Termina em',
        'ends_at_help' => 'Se data final não selecionada; campanha não expira',
        'notes' => 'Notas',
        'weight' => 'Peso',
        'limit_type' => 'Tipo limite',
        'limit_type_options' => [
            'impressions' => 'Impressões',
            'clicks' => 'Cliques',
        ],
        'limit_per_day' => 'Limite por dia',
        'limit_per_day_help' => '* obrigatório se o tipo de limite for selecionado',
    ],
    'impression' => [
        'banner_id' => 'Bandeira',
        'zone_id' => 'Zona',
        'session_id' => 'Sessão',
        'page_slug' => 'Lesma',
        'clicked' => 'Clicado',
        'visitor_details' => 'Detalhes',
    ],
    'website' => [
        'name' => 'Nome',
        'url' => 'URL',
        'contact' => 'Contato',
        'email' => 'O email',
        'notes' => 'Notas',
    ],
    'zone' => [
        'name' => 'Nome',
        'website' => 'Local na rede Internet',
        'key' => 'Chave',
        'dimension' => 'Dimensão',
        'notes' => 'Notas',
        'banner' => 'Banners',
        'embed_code' => 'Código embutido',
    ],


];