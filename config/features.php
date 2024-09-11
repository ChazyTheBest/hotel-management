<?php

use App\Features\AccountFeatures;

return [

    'account' => [
        AccountFeatures::accountDeletionFeatures(),
        AccountFeatures::accountPhotos([
            'disk' => 'public'
        ])
    ]

];
