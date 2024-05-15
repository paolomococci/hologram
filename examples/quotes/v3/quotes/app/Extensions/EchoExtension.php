<?php

namespace App\Extensions;

class EchoExtension
{
    /**
     * echoInteger
     * This is a simple interface that adapts data to and from the shared library function written in C language.
     *
     * @param integer $value
     * @return integer
     */
    public static function echoInteger(int $value): int {
        try {
            // send and receive value
            $val = \FFI::new('int');
            $valRec = \FFI::new('int');
            $val->cdata = $value;
            $echoInteger = \FFI::cdef(
                "int echoInteger(int value);",
                "/opt/share/lib/echo.so"
            );
            $valRec->cdata = $echoInteger->echoInteger($val->cdata);
            $valReceived = (int)$valRec->cdata;
            return $valReceived;
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}
