<?php
    /*******************************************************************************************************************
     *     ╔═══╗ ╔══╗ ╔═══╗ ╔════╗ ╔═══╗ ╔══╗        ╔══╗  ╔═══╗ ╔╗╔╗ ╔═══╗ ╔╗   ╔══╗ ╔═══╗ ╔╗  ╔╗ ╔═══╗ ╔╗ ╔╗ ╔════╗
     *     ║╔══╝ ║╔╗║ ║╔═╗║ ╚═╗╔═╝ ║╔══╝ ║╔═╝        ║╔╗╚╗ ║╔══╝ ║║║║ ║╔══╝ ║║   ║╔╗║ ║╔═╗║ ║║  ║║ ║╔══╝ ║╚═╝║ ╚═╗╔═╝
     *     ║║╔═╗ ║╚╝║ ║╚═╝║   ║║   ║╚══╗ ║╚═╗        ║║╚╗║ ║╚══╗ ║║║║ ║╚══╗ ║║   ║║║║ ║╚═╝║ ║╚╗╔╝║ ║╚══╗ ║╔╗ ║   ║║
     *     ║║╚╗║ ║╔╗║ ║╔╗╔╝   ║║   ║╔══╝ ╚═╗║        ║║─║║ ║╔══╝ ║╚╝║ ║╔══╝ ║║   ║║║║ ║╔══╝ ║╔╗╔╗║ ║╔══╝ ║║╚╗║   ║║
     *     ║╚═╝║ ║║║║ ║║║║    ║║   ║╚══╗ ╔═╝║        ║╚═╝║ ║╚══╗ ╚╗╔╝ ║╚══╗ ║╚═╗ ║╚╝║ ║║    ║║╚╝║║ ║╚══╗ ║║ ║║   ║║
     *     ╚═══╝ ╚╝╚╝ ╚╝╚╝    ╚╝   ╚═══╝ ╚══╝        ╚═══╝ ╚═══╝  ╚╝  ╚═══╝ ╚══╝ ╚══╝ ╚╝    ╚╝  ╚╝ ╚═══╝ ╚╝ ╚╝   ╚╝
     *------------------------------------------------------------------------------------------------------------------
     *
     * @author     Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date       30.11.2020 08:19
     * @copyright  Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
     * @license    GNU General Public License version 2 or later;
     ******************************************************************************************************************/

    use Joomla\CMS\Factory;
    use Joomla\CMS\Helper\ModuleHelper;
    use Joomla\CMS\Table\Table;
    use Joomla\CMS\Uri\Uri;

    defined('_JEXEC') or die('Restricted access');
    /**
     * @var stdClass                 $module Объект модуля
     * @var Joomla\Registry\Registry $params Настройки модуля
     */
    require_once dirname(__FILE__) . '/helper.php';

    $doc = \Joomla\CMS\Factory::getDocument();
    $doc->addStyleSheet('/modules/mod_menu_categories_shop/assets/css/mod_menu_categories_shop.css');
    $doc->addScript('/modules/mod_menu_categories_shop/assets/js/mod_menu_categories_shop.js');
    $Helper = ModMenuCategoriesShopHelper::instance($params);



    $field_sort = $params->get('sort', 'id');
    $ordering = $params->get('ordering', 'asc');
    $show_image = $params->get('show_image',0);

    $category_id = JRequest::getInt('category_id');
    $category = JTable::getInstance('category', 'jshop');
    $category->load($category_id);
    $categories_id = $category->getTreeParentCategories();
    $categories_arr = $Helper::getCatsArray($field_sort, $ordering, $category_id, $categories_id);


    JLoader::import('categories', JPATH_ROOT.'/administrator/components/com_jshopping/models');
    $_categories = JSFactory::getModel("categories");
    $categories_arr = $_categories->getTreeAllCategories( ['category_publish'=>1] , "ordering" ,  "asc" );


    /*echo'<pre>';print_r( $categories_arr );echo'</pre>'.__FILE__.' '.__LINE__ . PHP_EOL;
    die(__FILE__ .' '. __LINE__ );*/





    $jshopConfig = JSFactory::getConfig();

    $layout = $params->get('layout', 'default');
    require(JModuleHelper::getLayoutPath('mod_menu_categories_shop', $layout));

    /*echo'<pre>';print_r( $categories_arr );echo'</pre>'.__FILE__.' '.__LINE__ . PHP_EOL;
    die(__FILE__ .' '. __LINE__ );*/

















