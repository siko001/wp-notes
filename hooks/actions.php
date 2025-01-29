<?php


// this is the action that will be called
do_action('my_action', 'my optional parameter');


// this is the first function that will execute first (but excutes 2nd as the forth has higher priority)
add_action('my_action', 'my_function', 10, 1);
function my_function($param) {
    echo 'this: my text from the function || and this is my text from the the params: ' . '' . $param;
}


// THis is the second function and will execute after the first function
add_action('my_action', 'my_function2', 11, 1);
function my_function2($param) {
    echo 'this: my text from the function 2 || and this is my text from the the params: ' . '' . $param;
}


// this is the third function and will execute after the second function but without the parameter
add_action('my_action', 'my_function3', 12);
function my_function3() {
    echo 'this: my text from the function 3 || and this is my text from the the params: ';
}


// this is the fourth but will execute first as it has the highest priority
add_action('my_action', 'my_function4', 9, 1);
function my_function4($param) {
    echo 'this: my text from the function 4 || and this is my text from the the params: ' . '' . $param;
}
