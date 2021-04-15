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
     * @date       04.04.2021 15:37
     * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
     * @license    GNU General Public License version 2 or later;
     ******************************************************************************************************************/

    use Joomla\CMS\Uri\Uri;

    defined('_JEXEC') or die; // No direct access to this file

    /**
     * @var \Joomla\Registry\Registry   $params         - Параметры модуля
     * @var ModMenuCategoriesShopHelper $Helper         - объект Helper модуля
     * @var array                       $categories_arr - массив категорий
     */

    try
    {
        $HelperDom = \MenuCategoriesShop\Helpers\Dom::instance($params) ;
    } catch ( Exception $e )
    {
    }

?>

<div class="menu-wrapper menu-wrapper_state_animated" style="display: none;">
    <?php # заголовок для мобильного меню  ?>
    <div _ngcontent-rz-client-c39="" class="modal__header">
        <h3 _ngcontent-rz-client-c39="" class="modal__heading"> Каталог товаров </h3><!---->
        <button _ngcontent-rz-client-c39="" class="modal__close" type="button" aria-label="Закрыть модальное окно">
            <svg _ngcontent-rz-client-c39="" height="16" pointer-events="none" width="16">
                <use _ngcontent-rz-client-c39="" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-close-modal"></use>
            </svg>
        </button>
    </div>
    <button _ngcontent-rz-client-c38="" class="menu__back button button--medium button--white" type="button">
        <svg _ngcontent-rz-client-c38="" aria-hidden="true">
            <use _ngcontent-rz-client-c38="" href="#icon-chevron-down"></use>
        </svg>
        <span _ngcontent-rz-client-c38=""> Все категории </span>
    </button>
    <a href="#" class="menu__all-product">Все товары
        <svg _ngcontent-rz-client-c38="" aria-hidden="true">
            <use _ngcontent-rz-client-c38="" href="#icon-chevron-down"></use>
        </svg>
        </a>
    <!---->
    <ul class="menu-categories"><!---->

        <?php
            $oldLevel = 0 ;
            $openLevel1 = false ;
            $openLevel2 = false ;

            $countColumn = 0 ;                                          # Счетчик количества столбцов
            $countColumnMax = $params->get( 'count_column_max' , 3 ) ;  # Максимальное количества столбцов в меню
            $openColumn = false ;                                       # открытая колонка
            $counterElementInCol = 0 ;                                  # Количество элементов столбце
            $waitLevel0 = false ;                                       # Ждать уровень 0 ( для ограничения количества столбцов )
            $categories__item = '';






            foreach ($categories_arr as $a => $item)
            {
                $item->category_link =  SEFLink('index.php?option=com_jshopping&controller=category&task=view&category_id='.$item->category_id ,1 ) ;

                if( $item->level == 0 )
                {
                    $HelperDom->addLevel0( $item  );
                }

                if( $item->level == 1 )
                {
//                    $countChild = $Helper::countHasChild( $item , $a , $categories_arr ) ;

                    $HelperDom->addLevel1( $item   );

                }#END IF

                if( $item->level == 2 )
                {
                    $HelperDom->addLevel2( $item );
                }#END IF

                # Если следующи уровень 0 - Закрываем список с суб категориями
                if( $categories_arr[$a + 1]->level == 0 )
                {
                    echo $HelperDom->saveDomElem();
                }
            }#END FOREACH
        ?>



    </ul>
</div>