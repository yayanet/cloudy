<?php

function p_string($from, $key = NULL)
{
    if (is_string($from)) {
        return $from;
    }
    else if (is_array($from)) {
        if (isset($key) && isset($from[$key])) {
            return p_string($from[$key]);
        }
        else {
            return '';
        }
    }
    else if (is_object($from)) {
        return '';
    }
    
    return strval($from);
}