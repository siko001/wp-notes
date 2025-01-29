<?php

$myText = apply_filter('my_filter', 'This is the inital Text');
// this will output 'This is the inital Text'
echo $myText;



// this is the filter that will be called
add_filter('my_filter', 'my_filter_function', 10, 1);
function my_filter_function($text) {
    return  $text . ' || this is my text from the filter function';
}


// this will override the first filter and add more text to the output
add_filter('my_filter', 'my_filter_function2', 11, 1);
function my_filter_function2($text) {
    return  $text . ' || this is my text from the filter function 2';
}