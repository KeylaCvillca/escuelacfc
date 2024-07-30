<?php
namespace app\models;

use yii\base\Model;
use yii\helpers\Html;
use Yii;

class File extends Model
{
    public static function display($file)
    {
        // TODO Fix
        $path = Yii::getAlias('@web/uploads/' . basename($file));
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if ($extension === 'mp4') {
            return '
            <div class="row mt-5">
                <div class="col d-flex justify-content-center">
                    <video autoplay muted loop class="video-pasos" style="max-width: 100%;">
                        <source src="' . $path . '" type="video/mp4">
                        Tu navegador no admite el elemento <code>video</code>.
                    </video>
                </div>
            </div>';
        } else {
            return Html::img($path, ['style' => 'max-width: 100%;']);
        }
    }
}
