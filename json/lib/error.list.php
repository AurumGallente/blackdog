<?
    $errors = array (
        'ActionArrayError' => array (
            'result' => 'error',
            'code' => '-1',
            'message' => 'Action array expected. Wrong type given.',
        ),

        'NoData' => array (
            'result' => 'error',
            'code' => '-1',
            'message' => 'Empty data string given.',
        ),

        'BadJson' => array (
            'result' => 'error',
            'code' => '-1',
            'message' => 'Non correct JSON format given.',
        ),

        'BadJsonArgs' => array (
            'result' => 'error',
            'code' => '-1',
            'message' => 'Agrs from Json is not in array. Array structure expected.',
        ),

        'BadActionArgs' => array (
            'result' => 'error',
            'code' => '-1',
            'message' => 'Error in action define. Array parameters expected.',
        ),

        'ErrorActionAndDataSize' => array (
            'result' => 'error',
            'code' => '-1',
            'message' => 'Agrument count mistmatch in Actions and Data Json.',
        ), 

        'BadMethod' => array (
            'result' => 'error',
            'code' => '-1',
            'message' => 'Unknown method ({%METHOD_NAME%})',
        ),
        
        'NoResult' => array (
            'result' => 'error',
            'code' => '-1',
            'message' => 'No Result from ({%METHOD_NAME%})',
        ),

        'IncorrectLogin' => array (
            'result' => 'error',
            'code' => '-1',
            'message' => 'No such user',
        ),
    );