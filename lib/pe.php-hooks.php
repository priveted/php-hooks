<?php

/** 
 * @author Eduard Y, dev@priveted.com, https://priveted.com
 * @version 1.0.1
 * @copyright Copyright (c) 2022, priveted.com
 */


class PeHooks
{

    /**
     * Storing data and hook results
     * hook_data - Hook Names and functions
     * hook_result - Preserves the value of the executed hook function
     * @var array
     */
    static $storage = array(
        "hook_data" => array(),
        "hook_result" => array()
    );

    /**
     * Add data to the hook
     * @param string - Hook name (ID)
     * @param object - Hook function / function(array $data) { ... }
     */

    static function add($name = "index", $fn = true)
    {
        $data = (self::is($name)) ? self::$storage['hook_data'][$name] : array();
        array_push($data, $fn);
        self::$storage['hook_data'][$name] = $data;
    }


    /**
     * Run all functions added to the current hookЦ
     * @param string - Hook name (ID)
     * @param array - Return an array of data to the add function 
     * @param bool - Return the result 
     * @param bool - Overrides the output result
     * @return array
     */

    static function run($name = "index", $keys = array(0), $is_return = false, $override = false)
    {
        $data = (self::is($name)) ? self::$storage['hook_data'][$name] : array();
        $last = 0;
        $results = isset(self::$storage['hook_result'][$name]) ?
            self::$storage['hook_result'][$name] : array();
        if ($data) {
            foreach ($data as $key => $hook) {
                $results[$key] = $hook($keys);
            }
            self::$storage['hook_results'][$name] = $results;

            if ($is_return) {
                if ($results) {
                    foreach ($results as $key => $item) {
                        if ($item) {
                            if (is_array($item)) {
                                foreach ($item as $k => $v) {
                                    $keys[$k] = $v;
                                }
                            }
                        }
                        $last = $key;
                    }
                    if ($override)
                        return $results[$last];
                    else
                        return $keys;
                }
            }
        } else
            return false;
    }

    /**
     * Clear the hook
     * @param string - Hook name (ID)
     */

    static function clear($name = "index")
    {
        if (self::is($name)) {
            unset(self::$storage['hook_data'][$name]);
        }
    }


    /**
     * Run all functions added to the current hook
     * @param string - Hook name (ID)
     */

    static function is($name)
    {
        return (isset(self::$storage['hook_data'][$name]));
    }
}
