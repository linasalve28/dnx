<?php

function pb_validate_object_id($object_id,$object_type,$level=1) {

    if ($level==1) {
        // This function will validate if an object ID matches the accepted format
        if (str_len($object_id)==16) {
        } else {
            return false;
        }

    } else if ($level==2) {
        // If it exists in the object_type table
    } else if ($level==3) {
        //Finally if the user trying to use the object has permission to do so.
    }

}

function pb_string_length_validation($string,$length=255) {

    if (str_len($string) > $length) {
        return false;
    }


}

function pb_general_validation($input,$stringtype="string",$stringlength) {

    if(gettype($input)!==$stringtype) {
        return false;

    }

    if (strlen($input) > $stringlength) {
        return false;

    }


}

function pb_validate_ultrasafe($string) {
    // This function will remove all html tags and characters that are not normal. Creates ultrasafe variable.
    if(!$string=filter_var($string, FILTER_SANITIZE_STRING)){
        return false;
    } else {
        return true;
    }

}

function pb_validate_numeric($string) {

    if (is_numeric($string)) {
        return true;
    } else {
        return false;
    }

}
function pb_validate_plain_text($string) {

    if (!preg_match("/^[a-zA-Z ]*$/",$string)) {
        return false;
    } else {
        return true;
    }

}

function pb_validate_required($string) {

    if (!empty($string)) {
        return true;
    } else {
        return false;
    }

}

function pb_validate_email($email) {

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    } else {
        return true;
    }

}


?>