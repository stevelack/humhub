<?php

namespace humhub\modules\prize\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\prize\models\Prize;
use app\modules\prize\models\WonPrize;
use app\modules\coin\models\Coin;
use app\modules\coin\models\Wallet;
use humhub\modules\user\models\User;

/**
 * Evoke Tools Controller
 *
 */
class EvokeToolsController extends Controller
{
    public $max_prob = 1000;

    public function actionIndex()
    {
        $prizes = Prize::find()->all();
        $coin_id = Coin::find()->where(['name' => 'EvoCoin'])->one()->id;
        $wallet = Wallet::find()->where(['owner_id' => Yii::$app->user->id, 'coin_id' => $coin_id])->one();

        if (array_key_exists('results', $_GET)) {
          $results = $_GET['results'];
        } else {
          $results = null;
        }

        return $this->render('evoke_tools/index', array('prizes' => $prizes, 'wallet' => $wallet, 'results' => $results));
    }

    public function actionSearch()
    {
      $prizes = Prize::find()->where('quantity > :quantity', [':quantity' => '0'])->all();
      $coin_id = Coin::find()->where(['name' => 'EvoCoin'])->one()->id;
      $wallet = Wallet::find()->where(['owner_id' => Yii::$app->user->id, 'coin_id' => $coin_id])->one();

      $roll = mt_rand(0, $this->max_prob);
      $probabilities = [];
      $available_prizes = [];
      $prize_won = '';

      // minus the 5 evocoin this action costs
      $wallet->amount -= 5;
      $wallet->save();

      // workout the probabilities for each prize
      // this is tied to when the prize was set to be available
      // i.e. if the prize has been around for a while it is more likely to come up
      foreach ($prizes as $prize) {
        $date = $prize->week_of;
        // see how long the prize has been available - affects the probability of winning it
        $time_diff = date_diff(new \DateTime($date), new \DateTime());
        $diff = (int)$time_diff->format('%R%a'); // int of days

        if ($diff >= 0) { //prize not available yet if diff < 0
          $prize_prob = $prize->weight * ($diff + 1);
          $probabilities[] = $prize_prob;
          $available_prizes[] = $prize;
        }
      }

      // figure out if they won anything
      // done by counting down from the max prob and seeing if they scored a number above it
      $prob_checker = $this->max_prob; //here to keep track of where we are in the number line
      foreach ($probabilities as $key => $probability) {

        $prob_checker -= $probability;

        if ($roll >= $prob_checker) { // they won!
          $prize_won = $available_prizes[$key];
          $prize_won->quantity -= 1; // minus a quantity from the prize
          $prize_won->save();

          $won_prize = new WonPrize();
          $won_prize->prize_id = $prize_won->id;
          $won_prize->user_id = Yii::$app->user->id;
          $won_prize->save();

          $prize_won = $prize_won->name; // switch to string

          break;
        }
      }

      // if they didn't win a prize, check if they might have won some evocoin
      if ($prize_won === '') {
        if ($roll >= ($this->max_prob * 0.98)) {
          $prize_won = '50 Evocoin!';
          $wallet->amount += 50;
          $wallet->save();
        }
        elseif ($roll >= ($this->max_prob * 0.95)) {
          $prize_won = '20 Evocoin!';
          $wallet->amount += 20;
          $wallet->save();
        }
        elseif ($roll >= ($this->max_prob * 0.9)) {
          $prize_won = '10 Evocoin!';
          $wallet->amount += 10;
          $wallet->save();
        }
        elseif ($roll >= ($this->max_prob * 0.8)) {
          $prize_won = '5 Evocoin!';
          $wallet->amount += 5;
          $wallet->save();
        }
        else {
          $prize_won = Yii::t('PrizeModule.base', 'Sorry');
        }
      }

      $results = '<div><strong>' . $prize_won . '</strong></div>';

      return $this->redirect(['index', 'results' => $results]);
    }
}