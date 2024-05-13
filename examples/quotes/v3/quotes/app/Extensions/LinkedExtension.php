<?php

namespace App\Extensions;

class LinkedExtension
{
    /**
     * insert above value to labels linked list
     *
     * @param integer $value
     * @return void
     */
    public static function handleInsertAbove(int $value)
    {
        $val = \FFI::new('int' . $value);
        $insertAbove = \FFI::cdef(
            "void insertAbove(int value);",
            "/opt/share/lib/linked.so"
        );
        $insertAbove->insertAbove($val);
    }

    /**
     * show the value on top of linked list
     *
     * @return integer
     */
    public static function handleShowValueOfLabelAbove(): int
    {
        $showValueOfLabelAbove = \FFI::cdef(
            "int showValueOfLabelAbove();",
            "/opt/share/lib/linked.so"
        );
        $value = $showValueOfLabelAbove->showValueOfLabelAbove();
        return $value;
    }

    /**
     * drop the label on top of linked list
     *
     * @return void
     */
    public static function handleDropAbove()
    {
        $dropAbove = \FFI::cdef(
            "void dropAbove();",
            "/opt/share/lib/linked.so"
        );
        $dropAbove->dropAbove();
    }
}
