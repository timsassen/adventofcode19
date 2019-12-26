<?php

include_once __DIR__ . '/../vendor/autoload.php';
$code = file_get_contents(__DIR__ . '/input.txt');
$lines = explode(PHP_EOL, $code);

$nodes = [];
$oreNodes = [];
foreach ($lines as $line) {
    if (preg_match_all("/(?<qty>\d*) (?<chemical>[A-Z]{1,5})/", $line, $matches)) {
        $qtyResult = array_pop($matches['qty']);
        $nameResult = array_pop($matches['chemical']);
        $nodes[$nameResult] = [
            'name' => $nameResult,
            'qty' => $qtyResult,
            'children' => []
        ];

        foreach ($matches['chemical'] as $key => $name) {
            $nodes[$nameResult]['children'][] = [
                'name' => $name,
                'qty' => $matches['qty'][$key]
            ];
        }

    }
}

$dept = $nodes;
$dept = array_map(function ($node) {
    return 0;
}, $nodes);
$credit = $nodes;
$credit = array_map(function ($node) {
    return 0;
}, $nodes);

$credit['FUEL'] = 1;
foreach ($nodes['FUEL']['children'] as $node) {
    $dept[$node['name']] = $node['qty'];
}

$hasOnlyOre = function () use ($dept) {
    $deptContents = array_count_values(array_keys($dept));
    return (count($deptContents) == 1 && isset($dept['ORE']));
};

$show = function($dept, $credit) {
    echo "material|debt    |credit " . PHP_EOL;
    foreach (array_merge($dept, $credit) as $key => $item) {
        $debtRow = (isset($dept[$key])) ? $dept[$key] : "0";
        $creditRow = (isset($credit[$key])) ? $credit[$key] : "0";
        echo sprintf("%s|%s|%s", str_pad($key, 8, ' '), str_pad($debtRow, 8, ' '), str_pad($creditRow, 8, ' '));
        echo PHP_EOL;
    }
};


$takeOnDept = function ($toCredit, $qty) use ($nodes, &$credit, &$dept) {
    foreach ($nodes[$toCredit]['children'] as $node) {
        if (isset($dept[$node['name']])) {
            $dept[$node['name']] += (int)$node['qty'];
        } else {
            $dept[$node['name']] = (int)$node['qty'];
        }
        $credit[$toCredit] = (int)$nodes[$toCredit]['qty'];
    }
};

$show($dept, $credit);

while (!$hasOnlyOre()) {
    foreach ($dept as $deptItem => $deptQty) {
        if (isset($credit[$deptItem])) {
            if ($credit[$deptItem] > $deptQty) {
                // already enough in the bank, so minus debt from the the credit
                $credit[$deptItem] -= $deptQty;
            } elseif ($credit[$deptItem] == $deptQty) {
                //debt and credit cancel out
                $credit[$deptItem] = 0;
            } else {
                //not enough credit, so take on more debt
                $takeOnDept($deptItem, $deptQty);
            }
        } else {
            // no credit available, so take on more dept
            $takeOnDept($deptItem, $deptQty);
        }
        // resolve the dept
        $dept[$deptItem] = 0;
    }
//    break;
}

//$show($dept, $credit);

