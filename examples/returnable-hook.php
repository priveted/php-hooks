<?php
include_once "../lib/pe.php-hooks.php";

/* The type of hook that returns data and uses it */

//You can add a hook object in any order before executing the fn_main() function
PeHooks::add("returnable_hook", function ($data) {
    $data["test_hook_data_1"] = "hello";
    return $data;
});


function fn_main()
{
    // Execute the added objects as a function and get the result
    $data = PeHooks::run("returnable_hook", array("foo" => "bar"), true);
    var_dump($data); //array(2) { ["foo"]=> string(3) "bar" ["test_hook_data_1"]=> string(5) "hello" }
}


//This method will merge the result array with the master data array. To output a string or overwrite the result as a separate array, use the $override parameter
PeHooks::add("returnable_hook", function ($data) {
    $data["test_hook_data_2"] = "Merged!"; // Will not be added to the main data array
    return array("merged_with_data" => "YES"); //This array will be merged with the main one ($data)

});


// This method will not work because it returns a normal string.To output a string or overwrite the result as a separate array, use the $override parameter
PeHooks::add("returnable_hook", function ($data) {
    $data["test_hook_data_3"] = "bye!"; // Will not be added to the main data array
    return " regular string "; // This line will be disregarded
});


fn_main(); // =  Hooks: fitrst last

//It is no longer possible to add a hook object at this point (PEHook::add).