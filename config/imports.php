<?php

return [
    'order' => [
        'label' => 'Import Orders',
        'permission_required' => 'import_orders',
        'files' => [
            'file1' => [
                'label' => 'Orders File',
                'headers_to_db' => [
                    'order_date' => [
                        'label' => 'Order Date',
                        'type' => 'date',
                        'validation' => ['required']
                    ],
                    'channel' => [
                        'label' => 'Channel',
                        'type' => 'string',
                        'validation' => ['required', 'in' => ['PT', 'Amazon']]
                    ],
                    'sku' => [
                        'label' => 'SKU',
                        'type' => 'string',
                        'validation' => ['required'],
                    ],
                    'item_description' => [
                        'label' => 'Item Description',
                        'type' => 'string',
                        'validation' => ['nullable'],
                    ],
                    'origin' => [
                        'label' => 'Origin',
                        'type' => 'string',
                        'validation' => ['required'],
                    ],
                    'so_num' => [
                        'label' => 'SO#',
                        'type' => 'string',
                        'validation' => ['required'],
                    ],
                    'cost' => [
                        'label' => 'Cost',
                        'type' => 'double',
                        'validation' => ['required', 'numeric', 'min:0'],
                    ],
                    'shipping_cost' => [
                        'label' => 'Shipping Cost',
                        'type' => 'double',
                        'validation' => ['required', 'numeric', 'min:0'],
                    ],
                    'total_price' => [
                        'label' => 'Total Price',
                        'type' => 'double',
                        'validation' => ['required', 'numeric', 'min:0'],
                    ]
                ],
                'update_or_create' => ['so_num', 'sku']
            ]
        ]
    ],
    'product' => [
        'label' => 'Import Products',
        'permission_required' => 'import_products',
        'files' => [
            'file1' => [
                'label' => 'Products File',
                'headers_to_db' => [
                    'sku' => [
                        'label' => 'SKU',
                        'type' => 'string',
                        'validation' => ['required', 'unique:products,sku'],
                    ],
                    'name' => [
                        'label' => 'Product Name',
                        'type' => 'string',
                        'validation' => ['required'],
                    ],
                    'category' => [
                        'label' => 'Category',
                        'type' => 'string',
                        'validation' => ['required'],
                    ],
                    'price' => [
                        'label' => 'Price',
                        'type' => 'double',
                        'validation' => ['required', 'numeric', 'min:0'],
                    ],
                    'stock' => [
                        'label' => 'Stock',
                        'type' => 'integer',
                        'validation' => ['required', 'integer', 'min:0'],
                    ]
                ],
                'update_or_create' => ['sku']
            ]
        ]
    ],
];
