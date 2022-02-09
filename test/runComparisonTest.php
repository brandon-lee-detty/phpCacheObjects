<?php

namespace BrandonLeeDetty\PhpCacheObjects;

require_once $_composer_autoload_path ?? __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/displayHelpers.php';

define('BrandonLeeDetty\PhpCacheObjects\TEST_SIZE', 10 ** 5);

function testArrays(
    string $object_type,
    bool $set_unexpected_property = false,
    bool $do_post_gc = true
) {
    $generator = __NAMESPACE__ . '\\' . "${object_type}Generator";
    $store = [];
    gc_collect_cycles();
    $start_mem = memory_get_usage();
    for ($i = 0; $i < TEST_SIZE; ++$i) {
        $store[] = $generator::getArray();
        if ($set_unexpected_property) {
            $store[$i]['unexpected'] = true;
        }
    }
    if ($do_post_gc) {
        gc_collect_cycles();
    }
    echo formatBytes(memory_get_usage() - $start_mem) . ' w/arrays' . PHP_EOL;
}

function testCacheObjects(
    string $object_type,
    bool $set_unexpected_property = false,
    bool $do_post_gc = true
) {
    $generator = __NAMESPACE__ . '\\' . "${object_type}Generator";
    $store = [];
    gc_collect_cycles();
    $start_mem = memory_get_usage();
    for ($i = 0; $i < TEST_SIZE; ++$i) {
        $store[] = $generator::getObject();
        if ($set_unexpected_property) {
            $store[$i]->unexpected = true;
        }
    }
    if ($do_post_gc) {
        gc_collect_cycles();
    }
    echo formatBytes(memory_get_usage() - $start_mem) . ' w/objects' . PHP_EOL;
}

function testCacheObjectsFromArrays(
    string $object_type,
    bool $set_unexpected_property = false,
    bool $do_post_gc = true
) {
    $object_class = __NAMESPACE__ . '\\' . $object_type;
    $generator = "${object_class}Generator";
    $store = [];
    gc_collect_cycles();
    $start_mem = memory_get_usage();
    for ($i = 0; $i < TEST_SIZE; ++$i) {
        $store[] = new $object_class($generator::getArray());
        if ($set_unexpected_property) {
            $store[$i]->unexpected = true;
        }
    }
    if ($do_post_gc) {
        gc_collect_cycles();
    }
    echo formatBytes(memory_get_usage() - $start_mem)
        . ' w/objects from arrays' . PHP_EOL;
}

function compare(
    string $object_type,
    bool $set_unexpected_property,
    bool $do_post_gc
) {
    echo checkedStr($set_unexpected_property, 'unexpected properties')
        . checkedStr($do_post_gc, 'gc after populating data');

    $start_time = hrtime(true);
    testCacheObjects($object_type, $set_unexpected_property, $do_post_gc);
    displayTimeDiff($start_time);

    $start_time = hrtime(true);
    testCacheObjectsFromArrays(
        $object_type,
        $set_unexpected_property,
        $do_post_gc
    );
    displayTimeDiff($start_time);

    $start_time = hrtime(true);
    testArrays($object_type, $set_unexpected_property, $do_post_gc);
    displayTimeDiff($start_time);
}

echo "TESTING MUNICIPALITY OBJECTS" . PHP_EOL;
// gc_collect_cycles() after generating objects proved to be immaterial
// compare('Municipality', false, true);
// compare('Municipality', true, true);
compare('Municipality', true, false);
compare('Municipality', false, false);

echo PHP_EOL . "TESTING PERSON OBJECTS" . PHP_EOL;
// gc_collect_cycles() after generating objects proved to be immaterial
// / compare('Person', false, true);
// / compare('Person', true, true);
compare('Person', true, false);
compare('Person', false, false);
