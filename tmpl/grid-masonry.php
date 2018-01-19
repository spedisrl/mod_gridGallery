<?php
/**
 * @version    3.0.x
 * @package    GridGallery
 * @author     SPEDI srl http://www.spedi.it
 * @copyright  Copyright (c) Spedi srl.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

// if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if (!JComponentHelper::isEnabled('com_phocagallery', true)) {
	return JFactory::getApplication()->enqueueMessage(JText::_('Phoca Gallery is not installed on your system'), 'error');
}
if (! class_exists('PhocaGalleryLoader')) {
    require_once( JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_phocagallery'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'loader.php');
}
phocagalleryimport('phocagallery.path.path');
phocagalleryimport('phocagallery.path.route');
phocagalleryimport('phocagallery.library.library');
// phocagalleryimport('phocagallery.text.text');
// phocagalleryimport('phocagallery.access.access');
// phocagalleryimport('phocagallery.file.file');
// phocagalleryimport('phocagallery.file.filethumbnail');
// phocagalleryimport('phocagallery.image.image');
// phocagalleryimport('phocagallery.image.imagefront');
// phocagalleryimport('phocagallery.render.renderfront');
// phocagalleryimport('phocagallery.render.renderdetailwindow');
// phocagalleryimport('phocagallery.ordering.ordering');
// phocagalleryimport('phocagallery.picasa.picasa');
?>
<?php if($list) : ?>
<section class="gallery-module grid-masonry-layout wrapper gid-<?php echo $gal_id ?>">
	<?php if($module->showtitle) : ?>
		<div class="container">
			<div class="row">
				<div class="col-12 title-section">
					<h2><?php echo $module->title ?></h2>
					<?php if($description) : ?>
						<p><?= $description ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="container<?php echo $container ?>">
		<div class="row grid-gallery">
			<div class="col-6 col-sm-6 col-md-4 col-lg-<?php echo $col ?> col-xl-<?php echo $col ?> image grid-sizer"></div>
			<?php if($shuffle) : ?>
				<?php shuffle($list) ?>
			<?php endif; ?>
			<?php foreach($list as $k => $item) : ?>

				<?php if($k >= $limit) : ?>
					<?php break; ?>
				<?php endif; ?>

				<?php if($magnific) : ?>
					<?php $flink = JUri::base(true)."/images/phocagallery/".$item->filename; ?>
				<?php else: ?>
					<?php $flink = JRoute::_(PhocaGalleryRoute::getCategoryRoute($item->catid, $item->alias)); ?>
				<?php endif; ?>

				<?php $hidden = ''; ?>
				<?php if($k > 10) : ?>
					<?php $hidden = 'd-none'; ?>
				<?php endif; ?>

				<div class="col-6 col-sm-6 col-md-4 col-lg-<?php echo $col ?> col-xl-<?php echo $col ?> image <?php echo $hidden ?> grid-item">
					<figure style="margin:<?php echo $margin ?>px">
						<a class="magnific-overlay" title="<?php echo $item->title ?>" href="<?php echo $flink ?>">
							<img src="<?php echo JUri::base(true)."/images/phocagallery/".$item->filename; ?>" class="img-fluid" alt="">
							<figcaption class="d-flex justify-content-center align-items-center" style="background-color:<?= $imgOverlay ?>">
								<p class="mb-0 text-center" style="color:<?= $imgText ?>"><?php echo $item->title ?></p>
							</figcaption>
						</a>
					</figure>
				</div>
			<?php endforeach; ?>
		</div>

		<?php if($linkYN) : ?>
			<div class="row">
				<div class="col-12 d-flex align-items-center justify-content-center py-5">
					<p class="mb-0"><a href="<?php echo $link ?>" title="<?php echo $link_text ?>" class="btn btn-primary"><?php echo $link_text ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a></p>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php

$document->addScriptDeclaration("
  jQuery(document).ready(function($){

    $('.grid-masonry-layout.gid-".$gal_id." .grid-gallery').magnificPopup({
	    delegate:'a.magnific-overlay',
	    type:'image',
	    gallery:{enabled:true}
	  })

  });
");

$document->addScriptDeclaration("
	jQuery(document).ready(function($){
		if($('.grid-masonry-layout.gid-".$gal_id." .grid-gallery').length){
			var grid = $('.grid-masonry-layout.gid-".$gal_id." .grid-gallery').masonry({
				itemSelector: '.grid-item',
				columnWidth: '.grid-sizer',
				percentPosition: true
			});

			grid.imagesLoaded().progress( function() {
				grid.masonry('layout');
			});
		}
	})
");
 ?>
<?php endif; ?>
