<?php

    use GNZ11\Core\Js;
    use GNZ11\Document\Document;
    use Joomla\CMS\Factory;
    use Joomla\CMS\Filesystem\File;
    use Joomla\CMS\Layout\LayoutHelper;
    use Joomla\CMS\MVC\View\HtmlView;
    use Joomla\CMS\Table\Table;
    use Joomla\CMS\Uri\Uri;
    use Joomla\Registry\Registry;

    defined('_JEXEC') or die('Restricted access');

    require_once(JPATH_SITE . DS . 'components' . DS . 'com_jshopping' . DS . "lib" . DS . "factory.php");
    require_once(JPATH_SITE . DS . 'components' . DS . 'com_jshopping' . DS . "lib" . DS . "functions.php");

    class ModMenuCategoriesShopHelper
    {
        /**
         * @var \Joomla\CMS\Application\CMSApplication|null
         * @since 3.9
         */
        public $app;
        /**
         * @var \JDatabaseDriver|null
         * @since 3.9
         */
        private $db;
        public static $instance;

        private $params ;

        public static $viewConfig = [
            'name' => 'category' ,
            'charset' => 'UTF-8' ,
            'template_plath' => null ,
        ];
        /**
         * @var Object jshopConfig конфигурация jshop
         * @since 3.9
         */
        public $jshopConfig;
        /**
         * @var  string Имя шаблона
         * @since 3.9
         */
        private $template;




        /**
         * helper constructor.
         *
         * @param array $options
         *
         * @throws Exception
         * @since 3.9
         */
        private function __construct( $options = array() )
        {
           /* JLoader::registerNamespace( 'GNZ11' , JPATH_LIBRARIES . '/GNZ11' , $reset = false , $prepend = false , $type = 'psr4' );
            JLoader::registerNamespace( 'MenuCategoriesShop\Helpers' , __DIR__ . '/helpers' , $reset = false , $prepend = false , $type = 'psr4' );
*/


            $this->params = $options ;
            $this->app = Factory::getApplication();
            $this->db = Factory::getDbo();

            $this->template = $this->app->getTemplate();


            $this->jshopConfig = JSFactory::getConfig();
            $this->jshopConfig->cur_lang = $this->jshopConfig->frontend_lang;

            # Создать задания для фронта
            $this->addTaskToFront();

            $this->setOtions();



            return $this;
        }#END FN



        /**
         * @param array $options
         *
         * @return ModMenuCategoriesShopHelper
         * @throws Exception
         * @since 3.9
         */
        public static function instance( $options = array() ): ModMenuCategoriesShopHelper
        {
            if ( self::$instance === null ){
                self::$instance = new self($options);
            }
            return self::$instance;
        }#END FN

        /**
         *
         * @param $options
         *
         * @return false|string
         * @throws Exception
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   08.04.2021 01:31
         *
         */
        public static  function ModuleInit($options)
        {
            $_self = \ModMenuCategoriesShopHelper::instance( $options ) ;
            $field_sort = $_self->params->get('sort', 'id');
            $ordering = $_self->params->get('ordering', 'asc');
            $show_image = $_self->params->get('show_image',0);

            $category_id = $_self->app->input->get('category_id' , 0 , 'INT');
            $category = JTable::getInstance('category', 'jshop');
            $category->load($category_id);
            $categories_id = $category->getTreeParentCategories();

            $categories_arr = self::getCatsArray($field_sort, $ordering, $category_id, $categories_id);
            $layout = $_self->params->get('layout', 'default');
            ob_start();
            $params = $_self->params ;
            echo '<div id="mod_menu_categories_shop-Data"></div>';
            echo '<template id="mod_menu_categories_shop-Template">';
            require(JModuleHelper::getLayoutPath('mod_menu_categories_shop', $layout));
            echo '</template>';
            $htmlData = ob_get_contents();
            ob_end_clean();


            return $htmlData ;
        }


        /**
         * Создать задания для фронта
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 12:26
         *
         */
        public function addTaskToFront(){
            $doc = Factory::getDocument();

            $__v =  $this->params->get('__v' , '0.0.3')  ;
            $__mv = '?'.md5($__v);


            if( $this->params->get('debug_on' , 0 ) )
            {
                $doc->addStyleSheet(Uri::root().'modules/mod_menu_categories_shop/assets/css/mod_menu_categories_shop.css'.$__mv );
                # TODO DEBUG
                $doc->addStyleSheet('/modules/mod_menu_categories_shop/assets/css/mod_menu_categories_shop.mobile.css?'.$__mv , [], ['media' => 'only screen and (max-width:480px)']);
            }#END IF

            // Добавить стили для кнопки в теле страницы
            # TODO - Вынести в шаблон !!
            $doc->addStyleDeclaration('
                button.button.button--black.button--medium.main-categories__toggle {
                        display: none;
                    }
                @media (max-width: 480px){
                    button.button.button--black.button--medium.main-categories__toggle {
                        display: block;
                        margin: 0 15px;
                        width: calc(100% - 30px);
                        font-size: 16px ;
                        color: #fff;
                    }
                    button.button.button--black.button--medium.main-categories__toggle svg {
                        position: absolute;
                        left: 25%;
                        top: 50%;
                        transform: translateY(-50%);
                        fill: #fff;
                    }
                }
            ');


            Js::addJproLoad(Uri::root().'modules/mod_menu_categories_shop/assets/js/mod_menu_categories_shop.js'.$__mv,   false ,   false );

            if ($doc->getType() == 'html') {
                $url = Uri::root() . 'modules/mod_menu_categories_shop/assets/css/mod_menu_categories_shop.css'.$__mv  ;
                $tag = '<link rel="preload" href="' . $url . '" as="style">';
                // custom tags are supported by HTML document type only
                $doc->addCustomTag($tag);

                $url = Uri::root() . 'modules/mod_menu_categories_shop/assets/css/mod_menu_categories_shop.mobile.css'.$__mv  ;
                $tag = '<link rel="preload" href="' . $url . '" as="style">';
                // custom tags are supported by HTML document type only
                $doc->addCustomTag($tag);


            }

            $data = [
                '__v' => $this->params->get('__v' , '0.0.3') ,
                '__mv' => $__mv ,
                '__name' => 'menu_categories_shop' ,
                '__type' => 'module' ,
                '__debug' => !$this->params->get('debug_on' , false ) ? false : true ,

            ] ;



            # Данные для обновление количества просмотров для категорий
            $option = $this->app->input->get('option' , false , 'CMD' );
            $category_id = $this->app->input->get('category_id' , false , 'INT' );
            if( $option == 'com_jshopping' || $category_id ) {
                $data['udpHits'] = [ 'category_id' => $category_id ] ;
            } #END IF

            $doc->addScriptOptions('mod_menu_categories_shop' , $data );

        }


        public function setOtions(){
            $doc = Factory::getDocument();
            $paramsData['selector_key'] = $this->params->get('selector_key' , '#fat-menu');
            $doc->addScriptOptions('mod_menu_categories_shop' , $paramsData );
        }

        /**
         * Получить верхний уровень категорий
         * @param     $order
         * @param     $ordering
         * @param     $category_id
         * @param     $categories_id
         * @param     $categories
         * @param int $level
         *
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   05.04.2021 07:13
         *
         */
        public static function getTreeCats($order, $ordering, $category_id, $categories_id, &$categories, $level=0){
            $cat = JTable::getInstance('category', 'jshop');
            $cat->category_parent_id = 0;
            $cats = $cat->getSisterCategories($order, $ordering);

            foreach($cats as $key=>$value){
                $cats[$key]->level = $level;
                $categories[] = $value;
                self::getTreeCats2($order, $ordering, $value->category_id, $categories_id, $categories, $level);
            }
        }

        public static function getTreeCats2($order, $ordering, $category_id, $categories_id, &$categories, $level){
            ++$level;
            $cats = self::getSubCategories( $category_id ,  $order , $ordering);
            foreach($cats as $key=>$value){
                $cats[$key]->level = $level;
                $categories[] = $value;
                self::getTreeCats2($order, $ordering, $value->category_id, $categories_id, $categories, $level);
            }
        }

        public static function getCatsArray($order, $ordering, $category_id, $categories_id = array()){
            $res_arr = array();
            self::getTreeCats($order, $ordering, $category_id, $categories_id, $res_arr, 0);

//            echo'<pre>';print_r( $res_arr );echo'</pre>'.__FILE__.' '.__LINE__ . PHP_EOL;

            return $res_arr;
        }


        /**
         * Перебрать потомков второго уровня
         * @param $item
         * @param $i
         * @param $categories_arr
         *
         * @return false|int
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 12:22
         *
         */
        public static function countHasChild($item , $i , $categories_arr ){
            $pId = $item->category_id ;

            if( $categories_arr[$i+1]->category_parent_id != $item->category_id )
            {
                return false;
            }#END IF
            
            
            $countChild = 0 ;
            for ($a = 1 ; $a < count( $categories_arr ); $a++ ){
                if( $categories_arr[$i+$a]->category_parent_id != $item->category_id )
                {
                    return $countChild;
                }#END IF
                $countChild++;

            }

            die(__FILE__ .' '. __LINE__ );


        }

        /**
         * Обновить hits У категории (Ajax)
         * @throws Exception
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 13:50
         *
         */
        public static function updateHitsCategoryAjax(){
           $app = \Joomla\CMS\Factory::getApplication();
           $db = JFactory::getDbo();
           $updData = $app->input->get('upd' , [] , 'ARRAY') ;

            $db->setQuery(
                'UPDATE #__jshopping_categories' .
                ' SET hits = hits + 1' .
                ' WHERE category_id = '.(int) $updData['category_id']
            );

            try
            {
                $db->query();
            }
            catch (Exception $e)
            {
                 echo new \Joomla\CMS\Response\JsonResponse($db->getErrorMsg() , '' , true ) ;
                 die();
            }
            echo new \Joomla\CMS\Response\JsonResponse( 'upd' , '' , false ) ;
            die();




        }



        public static function getSubCategories($parentId, $order = 'id', $ordering = 'asc', $publish = 0){
            $lang = JSFactory::getLang();
            $user = JFactory::getUser();
            $_db = \Joomla\CMS\Factory::getDbo();
            $add_where = ($publish)?(" AND category_publish = '1' "):("");
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $add_where .=' AND access IN ('.$groups.')';
            if ($order=="id") $orderby = "category_id";
            if ($order=="name") $orderby = "`".$lang->get('name')."`";
            if ($order=="ordering") $orderby = "ordering";
            if (!$orderby) $orderby = "ordering";

            $query = "SELECT `".$lang->get('name')."` as name,`"
                .$lang->get('description')."` as description,`"
                .$lang->get('short_description')."` as short_description,"
                ."hits,"
                ."category_parent_id,"
                ."category_id, category_publish, ordering, category_image FROM `#__jshopping_categories`
                   WHERE category_parent_id = '".$_db->escape($parentId)."' ".$add_where."
                   ORDER BY ".$orderby." ".$ordering;
            $_db->setQuery($query);
            $categories = $_db->loadObjectList();
            foreach($categories as $key=>$value){
                $categories[$key]->category_link = SEFLink('index.php?option=com_jshopping&controller=category&task=view&category_id='.$categories[$key]->category_id, 0);
            }
            return $categories;
        }


    }











