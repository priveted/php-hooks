<?php
include_once "../lib/pe.php-hooks.php";

/* The simplest type of hook that does not return data but only uses it */

//You can add a hook object in any order before executing the fn_main() function
PeHooks::add("simple_hook_demo", function () {
    echo " fitrst";
});


function fn_main()
{

    echo "Hooks: ";
    //Execute the added objects as a function
    PeHooks::run("simple_hook_demo");
}

PeHooks::add("simple_hook_demo", function () {
    echo " last";
});


fn_main(); // =  Hooks: fitrst last

//It is no longer possible to add a hook object at this point (PEHook::add).