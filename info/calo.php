<?php
function calo($height, $weight, $age, $gender)
{
    if ($gender == "Male") {
        $calo = [(13.397 * $weight) + (4.799 * $height) - (5.677 * $age) + 88.362];
//        var_dump($calo);
        return $calo;
    } else if ($gender == 'Female') {
        $calo = [(9.247 * $weight) + (3.098 * $height) - (4.330 * $age) + 447.593];
//        var_dump($calo);
        return $calo;
    }
}

?>