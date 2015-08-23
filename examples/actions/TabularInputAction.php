<?php

/**
 * @link https://github.com/unclead/yii2-multiple-input
 * @copyright Copyright (c) 2014 unclead
 * @license https://github.com/unclead/yii2-multiple-input/blob/master/LICENSE.md
 */

namespace unclead\widgets\examples\actions;

use Yii;
use unclead\widgets\examples\models\Item;
use yii\base\Action;
use yii\base\Model;
use yii\bootstrap\ActiveForm;
use yii\web\Response;

/**
 * Class TabularInputAction
 * @package unclead\widgets\examples\actions
 */
class TabularInputAction extends Action
{
    public function run()
    {
        Yii::setAlias('@unclead-examples', realpath(__DIR__ . '/../'));

        $models = [new Item()];
        $request = Yii::$app->getRequest();
        if ($request->isPost && $request->post('ajax') !== null) {
            $data = Yii::$app->request->post('Item', []);
            foreach (array_keys($data) as $index) {
                $models[$index] = new Item();
            }
            Model::loadMultiple($models, Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = ActiveForm::validateMultiple($models);
            return $result;
        }

        if (Model::loadMultiple($models, Yii::$app->request->post())) {
            // your magic
        }


        return $this->controller->render('@unclead-examples/views/tabular-input.php', ['models' => $models]);
    }
}