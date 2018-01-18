<?php
/**
 * @version    3.0.x
 * @package    GridGallery
 * @author     SPEDI srl http://www.spedi.it
 * @copyright  Copyright (c) Spedi srl.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_gridgallery
 *
 * @since 1.0
 */
class ModGridGallery
{
	/**
	 * Conversione da esadecimale a rgb
	 * @param string $catid
	 * @return array $image
	 */
	public static function category($catid, $image = NULL){

		// Get a db connection.
		$db = JFactory::getDbo();

		// ciclo sulle categorie selezionate
		for ($i=0; $i < count($catid); $i++) {
			$queryCatid[] = 'p.catid = '.$catid[$i];
		}
		$queryCatid = " (".implode(' OR ', $queryCatid).") ";
		//var_dump($queryCatid);

		// ciclo sulle eventuali foto selezionate
		if(!is_null($image)){
			$temp = explode(',', $image);

			for ($i=0; $i < count($temp); $i++) {
				$queryImage[] = 'p.id = '.$temp[$i];
			}
			$queryImage = " (".implode(' OR ', $queryImage).") ";
			//var_dump($queryImage);
		}

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user profile table where key begins with "custom.".
		// Order it by the ordering field.
		$query->select($db->quoteName(array('p.title', 'p.filename', 'p.catid', 'pc.alias')));
		$query->select($db->quoteName('pc.title', 'category_title'));
		$query->from($db->quoteName('#__phocagallery', 'p'));
		$query->join('INNER', $db->quoteName('#__phocagallery_categories', 'pc') . ' ON (' . $db->quoteName('p.catid') . ' = ' . $db->quoteName('pc.id') . ')');
		//$query->where($db->quoteName('catid') . ' = '. $db->quote($catid[0]));
		$query->where($queryCatid);
		if(!is_null($image))
			$query->where($queryImage);
		$query->order('p.ordering ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();

		return $results;
	}
}
