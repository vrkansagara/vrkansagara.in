<?php
if (!isset($_SERVER['REQUEST_URI'])) {
    return;
}

$rewriteTable = array(
    '/vrkansagara'         => '/',
    '/me'         => '/',
    '/vk'         => '/',
    '/cms'         => '/',
    '/admin'         => '/',
    '/backend'         => '/',
);

$rewriteRegexes = array(
//    '#^/zf2/blog/entry/(?P<id>[^/]+)#' => '/blog/%id%.html',
//    '#^/manual/(?P<version>1\.1\d)/(?P<lang>[a-z]{2}(_[a-zA-Z]+)?)/index\.html$#' => function ($uri, array $matches) {
//        return sprintf('/manual/%s/%s/manual.html', $matches['version'], $matches['lang']);
//    },
//    '#^/manual/(?P<lang>[a-z]{2}(_[a-zA-Z]+)?)/(?P<page>.*)$#' => function ($uri, array $matches) {
//        if (strpos($matches['lang'], 'current') === 0) {
//            return false;
//        }
//        return sprintf('/manual/1.12/%lang%%page%', $matches['lang'], $matches['page']);
//    },
//    '#^/manual(/(?P<version>\d+\.\d+)(/(?P<lang>[a-z]{2}(_[a-zA-Z]+)?)(/)?)?)?$#' => function ($uri, array $matches) {
//        if (! isset($matches['version'])) {
//            $matches['version'] = 'current';
//        }
//
//        $lang    = isset($matches['lang'])    ? $matches['lang']    : 'en';
//        $version = $matches['version'];
//        if ('1.1' === substr($version, 0, 3)) {
//            $file = 'manual.html';
//        } else {
//            $file = 'index.html';
//        }
//        return sprintf('/manual/%s/%s/%s', $version, $lang, $file);
//    },
//    '#^/community*#' => '/participate',
//    '#^/releases/(?P<path>[^?]+\.(?:zip|tar.gz|tgz))#' => 'http://packages.zendframework.com/releases/%path%',
);

$rewrite = function ($uri) {
    header(sprintf('Location: %s', $uri), true, 301);
    exit(0);
};

$test = function () use ($rewriteTable, $rewriteRegexes, $rewrite) {
    $uri = $_SERVER['REQUEST_URI'];
    $uri = parse_url($uri, PHP_URL_PATH);
    $uri = rtrim($uri, '/');

    if (!$uri) {
        return;
    }

    if (isset($rewriteTable[strtolower($uri)])) {
        $rewriteTo = $rewriteTable[strtolower($uri)];
        if (is_callable($rewriteTo)) {
            $rewriteTo = $rewriteTo();
        }
        $rewrite($rewriteTo);
        return;
    }

    foreach ($rewriteRegexes as $regex => $rewriteUri) {
        $matches = array();
        if (!preg_match($regex, $uri, $matches)) {
            continue;
        }

        if (is_callable($rewriteUri)) {
            $rewriteUri = $rewriteUri($uri, $matches);
            if (false !== $rewriteUri) {
                $rewrite($rewriteUri);
            }
            return;
        }

        foreach ($matches as $key => $value) {
            if (is_int($key) || is_numeric($key)) {
                continue;
            }
            $rewriteUri = str_replace(sprintf('%%%s%%', $key), $value, $rewriteUri);
        }
        $rewrite($rewriteUri);
        return;
    }
};
$test();
unset($rewriteTable, $rewriteRegexes, $rewrite, $test);
