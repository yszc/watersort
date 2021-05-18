<?php

ini_set('memory_limit', '2048M');

$init = [
    [],
    ['a','b','c','b'],
    ['a','a','b','c'],
    ['a','c','b','c']
];

// $init = [
//     ['a','b','c','d'],
//     ['c','e','e','e'],
//     ['e','f','g','b'],
//     ['h','a','f','i'],
//     ['i','h','a','a'],
//     ['b','d','i','j'],
//     ['b','j','g','g'],
//     ['c','j','f','d'],
//     ['i','j','g','c'],
//     ['d','f','h','h'],
//     [],
//     [],
// ];

function checkComplete($cups){
    $res = true;
    foreach ($cups as $key => $cup) {
        list($topColor, $topLen) = getTop($cup);
        if ($topLen>0 && $topLen<4){
            return false;
        }
    }
    return $res;
}

function getTop($cup){
    $topColor = $cup[0];
    $topLen = 0;
    foreach ($cup as $block) {
        if($block == $topColor){
            $topLen++;
        }else{
            break;
        }
    }
    return [$topColor, $topLen];
}

$queue = [[$init, []]];
while(1){
    if(empty($queue)){
        var_dump("no solution!");
        break;
    }
    list($cups, $actions) = array_shift($queue);
    foreach ($cups as $i => $cup) {
        $space = 4 - count($cup);
        if ($space == 4){
            continue;
        }
        list($topColor, $topLen) = getTop($cup);
        foreach ($cups as $j => $_cup) {
            if($i == $j){
                continue;
            }
            $_space = 4 - count($_cup);
            if($_space == 4 || $_cup[0] == $topColor && $_space >= $topLen){
                $step = $cups;
                $step[$i] = array_slice($cups[$i], $topLen); 
                $step[$j] = array_merge(array_slice($cups[$i], 0, $topLen), $step[$j]);
                array_push($actions, sprintf("%s %d=>%d", $cups[$i][0], $i, $j));
                if (checkComplete($step)) {
                    print_r($actions);
                    print_r($step);
                    var_dump('complete!');
                    die;
                }else{
                    array_push($queue, [$step, $actions]);
                }
            }
        }
    }
}
