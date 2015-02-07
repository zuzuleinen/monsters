<?php

namespace Andrei\App;

/**
 * Utility class for different functionalities
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 * 
 */
class Helper
{
    /**
     * Make a camelCase string to underscored camel_case
     * 
     * @param string $inputString
     * @return string
     */
    public static function camelCaseToUnderscored($inputString)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $inputString)), '_');
    }
    
    /**
     * Transform an underscored string to camelCase
     * 
     * @param string $inputString
     * @return string
     */
    public static function underscoredToCamelCase($inputString)
    {
        return preg_replace('/_(.?)/e',"strtoupper('$1')",$inputString); 
    }
}
