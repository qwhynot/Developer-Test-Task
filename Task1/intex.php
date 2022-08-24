<?
//#1
function myArrowFunc($length) {
    $str = '';
    for ($i = 0; $i < $length; $i++)
        $str .= '<';
    for ($i = 0; $i < $length; $i++)
        $str .= '>';

    return $str;
}

echo myArrowFunc(9);