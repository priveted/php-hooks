<?php
include_once "../lib/pe.php-hooks.php";

/* The type of hook that can return rewritable data */

//You can add a hook object in any order before executing the fn_main() function
PeHooks::add("returnable_hook", function ($data) {
    $data["test_hook_data_1"] = "hello"; // Will not be added to the main data array
    return $data; //Will be ignored
});


function fn_main()
{
    // Execute the added objects as a function and get the result
    $data = PeHooks::run("returnable_hook", array("foo" => "bar"), true, true);
    var_dump($data); // string(28) " It can be any type of data "
}


//The latter has priority 
PeHooks::add("returnable_hook", function ($data) {
    $data["test_hook_data_2"] = "Oops!"; // Will not be added to the main data array
    return " It can be any type of data "; // This array will be merged with the main one ($data)
});


fn_main(); // =  Hooks: fitrst last

//It is no longer possible to add a hook object at this point (PEHook::add).