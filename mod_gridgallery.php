<?php
/**
 * @version    3.0.x
 * @package    GridGallery
 * @author     SPEDI srl http://www.spedi.it
 * @copyright  Copyright (c) Spedi srl.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

JLoader::register('ModGridGallery', __DIR__ . '/helper.php');

// params
$jquery       = $params->get('jquery-load');
$magnific     = $params->get('magnific');
// $masonry      = $params->get('masonry');
$catid        = $params->get('catid', array());
$description  = $params->get('description');
$image        = $params->get('image');
$num_line     = $params->get('num-line');
$container    = $params->get('container');
$height       = $params->get('photo-height');
$limit        = $params->get('limit');
$margin       = $params->get('margin');
$imgOverlay   = $params->get('image-overlay-color');
$imgText      = $params->get('image-text-color');
$shuffle      = $params->get('shuffle');
$linkYN       = $params->get('link-yn');
$link         = $params->get('link');
$link_text    = $params->get('link-text');

// gallery id
$gal_id = substr(md5($module->id.$module->title), 1, 5);

$list      = ModGridGallery::category($catid, $image);
$col       = $num_line;
$container = ($container) ? '-fluid' : '';

$document = JFactory::getDocument();
$tmpl     = JFactory::getApplication()->getTemplate();

if($jquery)
  JHtml::_('jquery.framework');
/* style */
switch ($params->get('layout')) {
  case '_:grid':
    $document->addStyleSheet(JUri::base(true).'/modules/'.$module->module.'/css/grid-gallery.min.css?v=1.0.0');
    break;
  case '_:grid-masonry':
    $document->addStyleSheet(JUri::base(true).'/modules/'.$module->module.'/css/grid-gallery-masonry.min.css?v=1.0.0');
    // masonry
    $extensionPath = '/templates/'.$tmpl.'/dist/masonry/';
    if(file_exists(JPATH_SITE.$extensionPath)){
    	$document->addScript(JUri::base(true).'/templates/'.$tmpl.'/dist/masonry/masonry.min.js');
    	$document->addScript(JUri::base(true).'/templates/'.$tmpl.'/dist/masonry/lazyload.min.js');
    } else{
    	$document->addScript(JUri::base(true).'/modules/'.$module->module.'/dist/masonry/masonry.min.js');
    	$document->addScript(JUri::base(true).'/modules/'.$module->module.'/dist/masonry/lazyload.min.js');
    }
    // $document->addScript(JUri::base(true).'/templates/'.$tmpl.'/dist/masonry/masonry.min.js');
    // $document->addScript(JUri::base(true).'/templates/'.$tmpl.'/dist/masonry/lazyload.min.js');
    break;
  case '_:isotope':
    $document->addStyleSheet(JUri::base(true).'/modules/'.$module->module.'/css/isotope.min.css?v=1.0.0');
    // isotope
    $extensionPath = '/templates/'.$tmpl.'/dist/isotope/';
    if(file_exists(JPATH_SITE.$extensionPath)){
    	$document->addScript(JUri::base(true).'/templates/'.$tmpl.'/dist/isotope/isotope.min.js');
    } else{
    	$document->addScript(JUri::base(true).'/modules/'.$module->module.'/dist/isotope/isotope.min.js');
    }
    // lazyload
    $extensionPath = '/templates/'.$tmpl.'/dist/masonry/';
    if(file_exists(JPATH_SITE.$extensionPath)){
    	$document->addScript(JUri::base(true).'/templates/'.$tmpl.'/dist/masonry/lazyload.min.js');
    } else{
    	$document->addScript(JUri::base(true).'/modules/'.$module->module.'/dist/masonry/lazyload.min.js');
    }
    break;

  case '_:slide-auto':
    $document->addStyleSheet(JUri::base(true).'/modules/'.$module->module.'/css/slide-auto.min.css?v=1.0.0');
    // isotope
    $extensionPath = '/templates/'.$tmpl.'/dist/swiper/';
    if(file_exists(JPATH_SITE.$extensionPath)){
    	$document->addStyleSheet(JUri::base(true).'/templates/'.$tmpl.'/dist/swiper/swiper.min.css');
      $document->addScript(JUri::base(true).'/templates/'.$tmpl.'/dist/swiper/swiper.min.js');
    } else{
      $document->addStyleSheet(JUri::base(true).'/modules/'.$module->module.'/dist/swiper/swiper.min.css');
    	$document->addScript(JUri::base(true).'/modules/'.$module->module.'/dist/swiper/swiper.min.js');
    }
    break;


}

/* script */
if($magnific){
  $extensionPath = '/templates/'.$tmpl.'/dist/magnific/';
  if(file_exists(JPATH_SITE.$extensionPath)){
    $document->addStyleSheet(JUri::base(true).'/templates/'.$tmpl.'/dist/magnific/magnific-popup.min.css');
    $document->addScript(JUri::base(true).'/templates/'.$tmpl.'/dist/magnific/jquery.magnific-popup.min.js');
  } else{
    $document->addStyleSheet(JUri::base(true).'/modules/'.$module->module.'/dist/magnific/magnific-popup.min.css');
    $document->addScript(JUri::base(true).'/modules/'.$module->module.'/dist/magnific/jquery.magnific-popup.min.js');
  }
  // $document->addStyleSheet(JUri::base(true).'/templates/'.$tmpl.'/dist/magnific/magnific-popup.min.css');
  // $document->addScript(JUri::base(true).'/templates/'.$tmpl.'/dist/magnific/jquery.magnific-popup.min.js');
}

/* layout */
require JModuleHelper::getLayoutPath($module->module, $params->get('layout'));
