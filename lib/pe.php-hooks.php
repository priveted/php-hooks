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
     * @param object - Hook function -> A set of keys. If you need to return a value, use & - the value will be written to the variable when the hook is executed/ function(&$data, $data2, ...) { ... }
     */

    static function add($name = "index", $fn = true)
    {
        $data = (self::is($name)) ? self::$storage['hook_data'][$name] : array();
        array_push($data, $fn);
        self::$storage['hook_data'][$name] = $data;
    }


    /**
     * Run all functions added to the current hook
     * @param string - Hook name (ID)
     * @param mixed - A set of variables or arrays in which values will be written / hooks::apply("name", $var1, $array1, ...)
     */

    static function apply($name = "index", &...$keys)
    {
        $data = (self::is($name)) ? self::$storage['hook_data'][$name] : array();
        $results = isset(self::$storage['hook_result'][$name]) ? self::$storage['hook_result'][$name] : array();
        if ($data) {
            foreach ($data as $key => $hook) {
                $results[$key] = ($keys) ? $hook(...$keys) : $hook();
            }

            self::$storage['hook_results'][$name] = $results;

            if ($results) {
                foreach ($results as $key => $item) {
                    if ($item) {
                        if (is_array($item)) {
                            foreach ($item as $k => $v) {
                                $keys[$k] = $v;
                            }
                        }
                    }
                }
                return $keys;
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
