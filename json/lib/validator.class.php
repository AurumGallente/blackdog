<?
    class JValidator {
        
        // Check is variable is an array
        public static function CheckArray($Input) {
            if (is_array($Input)) {
                return true;
            } else {
                return false;
            }
        }
        
        // Check is array is epmty
        public static function IsNotEmptyArray($Input) {
            if ( JValidator::CheckArray($Input) && !empty($Input) )
                return true;
            else 
                return false;
        }
        
        // Check is string is empty
        public static function IsNotEmptyString($String) {
            if (strlen($String) != 0)
                return true;
            else 
                return false;
        }
        
        // Check is result is NULL
        public static function IsNull($Input) {
            if (is_null($Input))
                return true;
            else 
                return false;
        }
        
        // Check is key exist in array
        public static function IsKeyExist($key, $array) {
            if (array_key_exists($key, $array)) 
                return true;
            else 
                return false;
        }
        
        // Set type
        public static function SetType($variable, $type, $isArgument = false) {
            switch ($type) {
                case 'integer':
                    return (integer)$variable;
                break;
                
                case 'string':
                    return ($isArgument) ? '"'.(string)$variable.'"' : (string)$variable;
                break;
                
                default:
                    return ($isArgument) ? '"'.(string)$variable.'"' : (string)$variable;
                break;
            }
        }
    }