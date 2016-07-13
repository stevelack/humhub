<?php

namespace humhub\modules\missions\controllers;

use Yii;
use app\modules\missions\models\Evokations;
use app\modules\missions\models\EvokationsSearch;
use app\modules\missions\models\EvokationCategories;
use app\modules\languages\models\Languages;
use app\modules\missions\models\Missions;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use humhub\modules\content\components\ContentContainerController;

/**
 * EvokationsController implements the CRUD actions for Evokations model.
 */
class EvokationsController extends ContentContainerController //extends Controller
{
    
    public function actions()
    {
        return array(
            'stream' => array(
                'class' => \humhub\modules\missions\components\EvokationStreamAction::className(),
                'mode' => \humhub\modules\missions\components\EvokationStreamAction::MODE_NORMAL,
                'contentContainer' => $this->contentContainer
             ),
        );
    }  
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    /**
     * Lists all Evokations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EvokationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Evokations model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'contentContainer' => $this->contentContainer,
            'model' => $this->findModel($id),
        ]);
    }

    public function actionSubmit(){
        
        return $this->render('create', [
            'contentContainer' => $this->contentContainer,
            'space' => $this->space
        ]);
    }
    
    /**
     * Creates a new Evokations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!$this->contentContainer->permissionManager->can(new \humhub\modules\missions\permissions\CreateEvokation())) {
            throw new HttpException(400, 'Access denied!');
        }
        
        $evokation = new Evokations();
        $evokation->scenario = Evokations::SCENARIO_CREATE;
        $evokation->title = Yii::$app->request->post('title');
        $evokation->description = Yii::$app->request->post('description');
        $evokation->youtube_url = Yii::$app->request->post('youtube_url');
        $evokation->gdrive_url = Yii::$app->request->post('gdrive_url');
            
        if(!Yii::$app->request->post('title')){
            AlertController::createAlert("Error!", Yii::t('MissionsModule.base', 'Title cannot be blank.'));
        } else if(!Yii::$app->request->post('description')){
            AlertController::createAlert("Error!", Yii::t('MissionsModule.base', 'Description cannot be blank.'));
        } else if(!Yii::$app->request->post('youtube_url')){
            AlertController::createAlert("Error!", Yii::t('MissionsModule.base', 'YouTube URL cannot be blank.'));
        } else if(!Yii::$app->request->post('gdrive_url')){
            AlertController::createAlert("Error!", Yii::t('MissionsModule.base', 'Google Drive URL cannot be blank.'));
        }

        return \humhub\modules\missions\widgets\WallCreateEvokationForm::create($evokation, $this->contentContainer);
    }

    /**
     * Updates an existing Evokations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Evokations::SCENARIO_EDIT;
        
        $edited = false;
        
        if (!$model->content->canWrite()) {
            throw new HttpException(403, Yii::t('MissionsModule.controllers_PollController', 'Access denied!'));
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'sguid' => $this->contentContainer->guid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
            //return $this->renderAjax('update', ['model' => $model, 'edited' => $edited]);
        }
    }

    /**
     * Deletes an existing Evokations model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Evokations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Evokations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Evokations::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Custom actions
    */
    public function actionHome()
    {   
        $categories = EvokationCategories::find()
        ->with([
            'activities.mission.missionTranslations' => function ($query) {
                $lang = Languages::findOne(['code' => Yii::$app->language]);
                $query->andWhere(['language_id' => $lang->id]);
            },
            'activities.activityTranslations' => function ($query) {
                $lang = Languages::findOne(['code' => Yii::$app->language]);
                $query->andWhere(['language_id' => $lang->id]);
            },
            // 'activities.evidences' => function($query){
            //     $query->andWhere([$this->contentContainer->id]);
            // }
        ])->all();
        
        $missions = Missions::find()
        ->where(['locked' => 0])
        ->all();
                
        return $this->render('home', array('categories' => $categories, 'missions' => $missions, 'contentContainer' => $this->contentContainer));
    }
    
    public function actionMissions()
    {   

        //$missions = Missions::find()->all();
        
        $missions = Missions::find()->with([
            'missionTranslations' => function ($query) {
                $lang = Languages::findOne(['code' => Yii::$app->language]);
                $query->andWhere(['language_id' => $lang->id]);
            },
        ])->all();
        
        return $this->render('missions', array('missions' => $missions, 'contentContainer' => $this->contentContainer));
    }


    public function portfolio(){
        return $this->render('portfolio', []);
    }

}