<?php
include_once "../lib/pe.php-hooks.php";


// Adding a simple hook to be executed in the fn_variable() and fn_array() functions

/**
 * @param string - Hook name (ID)
 * @param object - Hook callback function
 */
PeHooks::add("simple_hook_varriable", function (&$varriable /* $var1, $var2, ... */) {     //Use the & operator to make changes to the variable and get new data

    $varriable .= " - First hook -"; // or $varriable = " - First hook -"; to overwrite

});


function fn_varriable()
{
    $varriable = "Original text";

    PeHooks::apply("simple_hook_varriable", $varriable);

    return  $varriable;
}


function fn_array()
{
    $arr = array(
        "original" => "inited"
    );

    PeHooks::apply("simple_hook_array", $arr);

    return  $arr;
}


/**
 * @param string - Hook name (ID)
 * @param object - Hook callback function
 */
PeHooks::add("simple_hook_array", function (&$arr) { // Use the & operator to make changes to the array and get new data

    $arr["new_item"] = 'Added the "simple_hook_array" hook'; // Or overwrite the value of "original" - $arr["original"] = "not original";

});



print_r([
    fn_varriable(), // Result: "Original text - First hook -"
    fn_array() /* Result:
        array(
            "original" => "inited" || "not original",
            "new_item" => "Added the "simple_hook_array" hook"
        );
    */
]);