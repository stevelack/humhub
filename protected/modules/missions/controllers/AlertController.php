<?php

namespace humhub\modules\missions\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AlertController extends Controller
{

    public static function createAlert($title, $message){
        $popup = array_fill_keys(array('title', 'message'),"");
        $popup['title'] = $title;
        $popup['message'] = $message;

        $popup_array = Yii::$app->session->getFlash('popup');

        if($popup_array){
            array_push($popup_array, $popup);
        }else{
            $popup_array = array($popup);
        }

        Yii::$app->session->setFlash('popup', $popup_array);
    }

    public function actionAlert(){
        $popup = null;

        if (!Yii::$app->request->isAjax) {
            //throw new HttpException('403', 'Forbidden access.');
        }

        $popup_array = Yii::$app->session->getFlash('popup');

        //if popup_array exists and has content
        if ($popup_array && sizeof($popup_array) > 0) {

            //remove first one
            $popup = array_shift($popup_array);
            //save to flash remaining
            Yii::$app->session->setFlash('popup', $popup_array);
            //encode
            $popup = json_encode($popup);

            //send
            header('Content-Type: application/json; charset="UTF-8"');
            echo $popup;
            Yii::$app->end();
        }

        
    }        
}
