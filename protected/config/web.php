<?php

return [
     // ...
     'modules' => [
        // ...
    
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1',  '::1', '192.168.1.*', '172.16.3.211', '192.168.25.19'],
        ],
		
		'matching_questions' => [
            'class' => 'app\modules\matching_questions\MatchingQuestions',
        ],
    ]
];

