<?php
abstract class NewsForm {
	/**
	 * Gets the headline for this form
	 * @param $content the content in the headline
	 */
	abstract function getHeadline($content);
	
	/**
	 * Gets the formatted publish info
	 * Enter description here ...
	 * @param string $author the author
	 * @param boolean $anon whether the author is anonymous
	 * @param string $accepted who accepted an anonymous submission
	 * @param string $date the publish date
	 */
	abstract function getPublishInfo($author, $anon, $accepted, $date);
	
	/**
	 * Gets the formatted intro text with optional image
	 * @param string $intro
	 * @param string $img_url
	 */
	abstract function getIntro($intro, $img_url);
	
	/**
	 * Returns the CSS class for this form
	 */
	abstract function getCSSClass();
}
?>