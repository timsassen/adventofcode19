<?php

include_once 'vendor/autoload.php';
ini_set('xdebug.max_nesting_level', 500);

$input = file_get_contents(__DIR__ . '/input.txt');
$txtOrbits = explode("\n", $input);

foreach ($txtOrbits as $orbit) {
    list($parent, $child) = explode(")", $orbit);
    $childNode = new \BlueM\Tree\Node($child, null);
    $nodes[$childNode->getId()] = $childNode;
}

/**
 * @param $nodes
 * @param $id
 * @return \BlueM\Tree\Node
 */
function getNode($nodes, $id)
{
    $parentNode = array_filter($nodes, function ($node) use ($id) {
        return $node->getId() == $id;
    });

    return (count($parentNode) === 1) ? current($parentNode) : new \BlueM\Tree\Node($id, null);
}


foreach ($txtOrbits as $orbit) {
    list($parent, $child) = explode(")", $orbit);
    /** @var \BlueM\Tree\Node $childNode */
    $childNode = getNode($nodes, $child);
    /** @var \BlueM\Tree\Node $parentNode */
    $parentNode = getNode($nodes, $parent);

    $parentNode->addChild($childNode);
    $nodes[$parentNode->getId()] = $parentNode;
    $nodes[$childNode->getId()] = $childNode;
}

$me = getNode($nodes, "YOU");
$santa = getNode($nodes, "SAN");


$mePath = array_map(function (\BlueM\Tree\Node $node) {
    return $node->getId();
}, $me->getAncestors());

$santaPath = array_map(function (\BlueM\Tree\Node $node) {
    return $node->getId();
}, $santa->getAncestors());

$mePathCount = count(array_diff($mePath, $santaPath));
$santaPathCount = count(array_diff($santaPath, $mePath));

var_dump($mePathCount + $santaPathCount);
exit;