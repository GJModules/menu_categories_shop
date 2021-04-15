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


    /**
     * Для правильной работы модуля требуется библиотека GNZ11
     * Скачать можно по ссылке :
     * https://github.com/Gartes-JoomShopping/mod_jshopping_random_m/archive/refs/heads/main.zip
     *
     * Установка через Менеджер установки (Рекомендуется - для получения обновлений)
     * или просто распаковать в  директорию  /libraries
     *
     */
    try
    {
        $GNZ11_path =  JPATH_LIBRARIES . '/GNZ11' ;
        JLoader::registerNamespace( 'GNZ11' , $GNZ11_path , $reset = false , $prepend = false , $type = 'psr4' );
        $GNZ11_js =  \GNZ11\Core\Js::instance();
    }
    catch( Exception $e )
    {
        $app = \Joomla\CMS\Factory::getApplication();
        if( !\Joomla\CMS\Filesystem\Folder::exists( $GNZ11_path )  )
        {
            $app->enqueueMessage('Для работы модуля '.$module->module.'('.$module->title.')'.'  Должна быть установлена библиотека GNZ11' , 'error');
        }#END IF
    }


    JLoader::registerNamespace( 'MenuCategoriesShop\Helpers' , __DIR__ . '/helpers' , $reset = false , $prepend = false , $type = 'psr4' );






//    $categories_arr = ModMenuCategoriesShopHelper::ModuleInit($params);


    try
    {
        // Code that may throw an Exception or Error.
        $cacheParams = new stdClass;
        $cacheParams->cachemode = 'static'/*'id'*/ ;
        $cacheParams->class = 'ModMenuCategoriesShopHelper';
        $cacheParams->method = 'ModuleInit';
        $cacheParams->methodparams = $params;
        $cacheParams->modeparams = array('id' => 'int' /*, 'module_type' => $module_type*/);
        $params->set('filters' , []);
        echo JModuleHelper::moduleCache($module , $params , $cacheParams);

//         throw new \Exception('Code Exception '.__FILE__.':'.__LINE__) ;
    }
    catch (\Error $e)
    {
        // Executed only in PHP 5, will not be reached in PHP 7
        echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
        echo'<pre>';print_r( $e );echo'</pre>'.__FILE__.' '.__LINE__;
        die(__FILE__ .' '. __LINE__ );
    }


//    echo'<pre>';print_r( $categories_arr );echo'</pre>'.__FILE__.' '.__LINE__ . PHP_EOL;
//
//    die(__FILE__ .' '. __LINE__ );







    /*echo'<pre>';print_r( $categories_arr );echo'</pre>'.__FILE__.' '.__LINE__ . PHP_EOL;
    die(__FILE__ .' '. __LINE__ );*/

















