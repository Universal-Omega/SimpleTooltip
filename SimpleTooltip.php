<?php
$wgSimpleTooltipSubmitText = 'NEW';

$wgExtensionCredits['other'][] = [
   'path'           => __FILE__,
   'name'           => 'SimpleTooltip',
   'author'         => [ 'Simon Heimler' ],
   'version'        => '1.1.0',
   'url'            => 'https://www.mediawiki.org/wiki/Extension:SimpleTooltip',
   'descriptionmsg' => 'simpletooltip-desc',
   'license-name'   => 'MIT'
];

$wgResourceModules['ext.SimpleTooltip'] = [
   'scripts' => [
      'lib/jquery.tooltipster.js',
      'lib/SimpleTooltip.js',
   ],
   'styles' => [
      'lib/tooltipster.css',
      'lib/SimpleTooltip.css',
   ],
   'localBasePath' => __DIR__,
   'remoteExtPath' => 'SimpleTooltip',
];

$wgMessagesDirs['SimpleTooltip'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['SimpleTooltipMagic'] = __DIR__ . '/SimpleTooltip.i18n.magic.php';

$wgAutoloadClasses['SimpleTooltipHooks'] = __DIR__ . '/src/SimpleTooltipHooks.php';

$wgHooks['BeforePageDisplay'][] = 'SimpleTooltipHooks::onBeforePageDisplay';
$wgHooks['ParserFirstCallInit'][] = 'SimpleTooltipHooks::onParserFirstCallInit';
