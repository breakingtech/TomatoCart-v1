<?php
/*
  $Id: store.php $
  TomatoCart Open Source Shopping Cart Solutions
  http://www.tomatocart.com

  Copyright (c) 2009 TomatoCart;  Copyright (c) 2006 osCommerce

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License v2 (1991)
  as published by the Free Software Foundation.
*/

class toC_Store_Admin {
	/**
	 * List the store
	 *
	 * @access public static
	 * @return array
	 */
	function listStores() {
		global $osC_Database;
		
		$Qstores = $osC_Database->query('select * from :table_store order by store_id');
		$Qstores->bindTable(':table_store', TABLE_STORE);
		$Qstores->execute();
		
		$stores = array();
		if ($Qstores->numberOfRows() > 0) {
			while ($Qstores->next()) {
				$stores[] = array(
						'store_id' => $Qstores->ValueInt('store_id'),
						'store_name' => $Qstores->Value('store_name'),
						'url_address' => $Qstores->Value('url_address'),
						'ssl_url_address' => $Qstores->Value('ssl_url_address'),
				);
			}
		}
		
		return $stores;
	}
	
	/**
	 * Delete the store
	 * 
	 * @access public static
	 * @param int store id
	 * @return boolean
	 */
	function deleteStore($id) {
		global $osC_Database;
		
		//delete store settings
		$Qdelete_settings = $osC_Database->query('delete from :table_configuration where store_id = :store_id');
		$Qdelete_settings->bindTable(':table_configuration', TABLE_CONFIGURATION);
		$Qdelete_settings->bindInt(':store_id', $id);
		$Qdelete_settings->execute();
		
		//delete store
		$Qdelete_store = $osC_Database->query('delete from :table_store where store_id = :store_id');
		$Qdelete_store->bindTable(':table_store', TABLE_STORE);
		$Qdelete_store->bindInt(':store_id', $id);
		$Qdelete_store->execute();
		
		if ($Qdelete_store->affectedRows() > 0) {
		  return true;
		}
		
		return false;
	}
	
	/**
	 * Get installed templates
	 *
	 * @access public static
	 * @return array
	 */
	function getTemplates() {
		global $osC_Database;
		
		$Qtemplates = $osC_Database->query('select code, title from :table_templates');
		$Qtemplates->bindTable(':table_templates', TABLE_TEMPLATES);
		$Qtemplates->execute();
		
		$templates = array();
		if ($Qtemplates->numberOfRows() > 0) {
		  while ($Qtemplates->next()) {
		  	$templates[] = array('code' => $Qtemplates->value('code'), 'title' => $Qtemplates->value('title'));
		  }
		}
		
		$Qtemplates->freeResult();
		
		return $templates;
	}
	
	/**
	 * Get installed languages
	 *
	 * @access public static
	 * @return array
	 */
	function getLanguages() {
		global $osC_Database;
		
		$Qlanguages = $osC_Database->query('select code, name from :table_languages');
		$Qlanguages->bindTable(':table_languages', TABLE_LANGUAGES);
		$Qlanguages->execute();
		
		$languages = array();
		if ($Qlanguages->numberOfRows() > 0) {
			while ($Qlanguages->next()) {
				$languages[] = array('code' => $Qlanguages->value('code'), 'name' => $Qlanguages->value('name'));
			}
		}
		
		$Qlanguages->freeResult();
		
		return $languages;
	}
	
	/**
	 * Get installed currencies
	 *
	 * @access public static
	 * @return array
	 */
	function getCurrencies() {
		global $osC_Database;
	
		$Qcurrencies = $osC_Database->query('select code, title from :table_currencies');
		$Qcurrencies->bindTable(':table_currencies', TABLE_CURRENCIES);
		$Qcurrencies->execute();
	
		$currencies = array();
		if ($Qcurrencies->numberOfRows() > 0) {
			while ($Qcurrencies->next()) {
				$currencies[] = array('code' => $Qcurrencies->value('code'), 'title' => $Qcurrencies->value('title'));
			}
		}
	
		$Qcurrencies->freeResult();
	
		return $currencies;
	}
}