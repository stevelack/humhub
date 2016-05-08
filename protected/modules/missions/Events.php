<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\missions;

use Yii;
use yii\helpers\Url;
use humhub\models\Setting;
// use humhub\modules\dashboard\widgets\ShareWidget;

/**
 * Description of Events
 *
 * @author luke
 */
class Events
{

    /**
     * On build of the TopMenu, check if module is enabled
     * When enabled add a menu item
     *
     * @param type $event
     */
    public static function onTopMenuInit($event)
    {

        // Is Module enabled on this workspace?
        $event->sender->addItem(array(
            'label' => Yii::t('MissionsModule.base', 'Missions'),
            'id' => 'missions',
            'icon' => '<i class="fa fa-th"></i>',
            'url' => Url::toRoute('/missions/missions'),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'missions'),
        ));
    }

    public static function onSidebarInit($event)
    {
        if (Setting::Get('enable', 'share') == 1) {
            if (Yii::$app->user->isGuest || Yii::$app->user->getIdentity()->getSetting("hideSharePanel", "share") != 1) {
                $event->sender->addWidget(ShareWidget::className(), array(), array('sortOrder' => 150));
            }
        }
    }
    
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => Yii::t('MissionsModule.base', 'Missions'),
            'url' => Url::to(['/missions/admin']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-th"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'missions' && Yii::$app->controller->id == 'admin'),
            'sortOrder' => 300,
        ));
    }
    
    public static function onSpaceAdminMenuInit($event)
    {
        $space = $event->sender->space;
        if ($space->isModuleEnabled('missions') && $space->isAdmin() && $space->isMember()) {
            $event->sender->addItem(array(
                'label' => Yii::t('MissionsModule.base', 'Missions'),
                'group' => 'admin',
                'url' => $space->createUrl('/missions/admin'),
                'icon' => '<i class="fa fa-th"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'missions' && Yii::$app->controller->id == 'container' && Yii::$app->controller->action->id != 'view'),
            ));
        }
    }

}
