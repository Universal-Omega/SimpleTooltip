<?php
/**
 * SimpleTooltip Parser Functions
 *
 * @file
 * @ingroup Extensions
 */
class SimpleTooltipHooks {
	/**
	 * Add libraries to resource loader
	 */
	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		// Add as ResourceLoader Module
		$out->addModules( 'ext.SimpleTooltip' );
	}

	/**
	 * Register parser hooks
	 *
	 * See also http://www.mediawiki.org/wiki/Manual:Parser_functions
	 */
	public static function onParserFirstCallInit( &$parser ) {
		// Register parser functions
		$parser->setFunctionHook( 'simple-tooltip', 'SimpleTooltipParserFunction::inlineTooltip' );
		$parser->setFunctionHook( 'tip-text', 'SimpleTooltipParserFunction::inlineTooltip' );

		$parser->setFunctionHook( 'simple-tooltip-info', 'SimpleTooltipParserFunction::infoTooltip' );
		$parser->setFunctionHook( 'tip-info', 'SimpleTooltipParserFunction::infoTooltip' );

		$parser->setFunctionHook( 'simple-tooltip-img', 'SimpleTooltipParserFunction::imgTooltip' );
		$parser->setFunctionHook( 'tip-img', 'SimpleTooltipParserFunction::imgTooltip' );
	}

	/**
	 * Parser function handler for {{#tip-text: inline-text | tooltip-text }}
	 *
	 * @param Parser $parser
	 * @param string $arg
	 *
	 * @return string: HTML to insert in the page.
	 */
	public static function inlineTooltip( $parser, $value ) {
		$args = array_slice( func_get_args(), 2 );
		$title = $args[0];

		$content = Sanitizer::removeHTMLtags( $title );
		$content = $parser->recursiveTagParseFully( $content );
		$content = str_replace( '"', "'", $content );
		$content = trim( $content );
		$content = htmlspecialchars( $content );

		$html = '<span class="simple-tooltip simple-tooltip-inline"';

		$html .= ' data-simple-tooltip="' . $content . '"';
		$html .= '>' . htmlspecialchars( $value ) . '</span>';

		return [
			$html,
			'noparse' => true,
			'isHTML' => true,
			'markerType' => 'nowiki'
		];
	}

	/**
	 * Parser function handler for {{#tip-info: tooltip-text }}
	 *
	 * @param Parser $parser
	 * @param string $arg
	 *
	 * @return string: HTML to insert in the page.
	 */
	public static function infoTooltip( $parser, $value ) {
		$html = '<span class="simple-tooltip simple-tooltip-info"';

		$html .= ' data-simple-tooltip="' . htmlspecialchars( Sanitizer::removeHTMLtags( $value ) ) . '"></span>';

		return [
			$html,
			'noparse' => true,
			'isHTML' => true,
			'markerType' => 'nowiki'
		];
	}

	/**
	 * Parser function handler for {{#tip-img: image-url | tooltip-text }}
	 *
	 * @param Parser $parser
	 * @param string $arg
	 *
	 * @return string: HTML to insert in the page.
	 */
	public static function imgTooltip( $parser, $value ) {
		$args = array_slice( func_get_args(), 2 );
		$title = $args[0];
		$imgUrl = htmlspecialchars( $value );

		$html = '<img class="simple-tooltip simple-tooltip-img"';

		$html .= ' data-simple-tooltip="' . htmlspecialchars( Sanitizer::removeHTMLtags( $title ) ) . '"';
		$html .= ' src="' . $imgUrl . '"></img>';

		return [
			$html,
			'noparse' => true,
			'isHTML' => true,
			'markerType' => 'nowiki'
		];
	}
}
