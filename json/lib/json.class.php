<?

// Include Action list and Error list

include_once('action.list.php');
include_once('error.list.php');

// Include Static Validator Class
include_once('validator.class.php');

// Main API class

class ApiJ {

    private $aActions = array(); // Array from action.list.php
    private $aErrors = array(); // Array from error.list.php
    private $aInputData = array(); // Array of input json data
    private $aResult = array(); // Array Json result

    // Constructor function (Create private actions list & private error list)

    public function __construct($aActions, $aErrors) {
        if (JValidator::CheckArray($aErrors))
            $this->aErrors = $aErrors;
        else
            $this->aResult = array(
                'result' => 'error',
                'code' => '-1',
                'message' => 'Error array expected. Wrong type given.',
            );

        if (JValidator::CheckArray($aActions))
            $this->aActions = $aActions;
        else
            $this->aResult = $this->aErrors['ActionArrayError'];
    }

    // This function grab input data from STDIN
    private function getInputData() {
        $data = ''; // To be sure that we have empty string on the start
        // Get json content
        $data = file_get_contents('php://input');

        if (!JValidator::IsNotEmptyString($data)) {
            $data = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
        }

        // Check accepted data
        if (!JValidator::IsNotEmptyString($data)) {
            $this->aResult = $this->aErrors['NoData'];
            echo json_encode($this->aResult);
            exit;
        }

        // Check Json format
        if (JValidator::IsNull($this->aInputData = json_decode($data, true))) {
            $this->aResult = $this->aErrors['BadJson'];
            echo json_encode($this->aResult);
            exit;
        }        
    }

    // Check Action method from json
    private function checkMethod() {
        if (!JValidator::IsKeyExist($this->aInputData['method'], $this->aActions)) {
            $this->aResult = $this->aErrors['BadMethod'];
            $this->aResult['message'] = str_replace('{%METHOD_NAME%}', $this->aInputData['method'], $this->aResult['message']);            
            echo json_encode($this->aResult);
            exit;
        }
    }

    // Check agrs for method and give them correct type
    private function checkArgs() {
        // Check input data type
        if (!JValidator::CheckArray($this->aInputData['data'])) {
            $this->aResult = $this->aErrors['BadJsonArgs'];
            echo json_encode($this->aResult);
            exit;
        }

        // Check Actions params type
        if (!JValidator::CheckArray($this->aActions[$this->aInputData['method']]['params'])) {
            $this->aResult = $this->aErrors['BadActionArgs'];
            echo json_encode($this->aResult);
            exit;
        }

        // Compare defined agrs count with accepted json args count
        if (count($this->aInputData['data']) != count($this->aActions[$this->aInputData['method']]['params'])) {
            $this->aResult = $this->aErrors['ErrorActionAndDataSize'];
            echo json_encode($this->aResult);
            exit;
        }

        // Set types to received Json Data agrs
        $i = 0;
        foreach ($this->aInputData['data'] as $key => $value) {
            $this->aInputData['data'][$key] = JValidator::SetType($value, $this->aActions[$this->aInputData['method']]['params'][$i]);
            $i++;
        }
    }

    // Call requested method
    private function CallMethod() {
        
        // Check if is set user login data for this action                           
        if (JValidator::CheckArray($this->aInputData['user'])) {
            foreach ($this->aInputData['user'] as $key => $value) {
                $this->aInputData['user'][$key] = JValidator::SetType($value, 'string');
            }                        
            arsort($this->aInputData['user']);
            $params = array_merge($this->aInputData['user'], $this->aInputData['data']);            
            } else {
            $params = $this->aInputData['data'];
            ksort($params);
        }

        // Get result from API function
        $result = call_user_func_array($this->aActions[$this->aInputData['method']]['function'], $params);
        
        // Check result for errors
        if (!$result) {
            $this->aResult = $this->aErrors['NoResult'];
            $this->aResult['message'] = str_replace('{%METHOD_NAME%}', $this->aInputData['method'], $this->aResult['message']);
            echo json_encode($this->aResult);
            exit;
        } else {
            // Return API function error
            if (JValidator::IsKeyExist('error', $result)) {
                $this->aResult = $this->aErrors[$result['error']];
                echo json_encode($this->aResult);
                exit;
            }

            // Return Result
            $this->aResult['data'] = $result;
            $this->aResult['result'] = 'ok';
            $this->aResult['code'] = 1;
            echo json_encode($this->aResult);

            exit;
        }
    }

    // Execute function (e.g. main function for all API requests)
    public function execute() {
        if (JValidator::IsNotEmptyArray($this->aResult)) {
            echo json_encode($this->aResult);
            exit;
        }
        $this->getInputData();
        $this->checkMethod();
        $this->checkArgs();
        $this->CallMethod();
    }

}

// Create API object

$ApiJ = new ApiJ($actions, $errors);
