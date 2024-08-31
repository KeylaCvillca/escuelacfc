<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FileSearch represents the model behind the search form of `app\models\File`.
 */
class FileSearch extends Model
{
    public $name;
    public $extension;
    public $path;

    private $files = [];

    public function rules()
    {
        return [
            [['name', 'extension', 'path'], 'safe'],
        ];
    }

    public function search($params)
    {
        // Load file data from the filesystem
        $this->files = $this->loadFiles(); // Method to load files from the filesystem

        $dataProvider = new ActiveDataProvider([
            'query' => $this->getQuery(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $dataProvider->setModels([]); // No results if validation fails
            return $dataProvider;
        }

        // Apply filters
        $models = array_filter($this->files, function ($file) {
            return (!$this->name || stripos($file['name'], $this->name) !== false) &&
                   (!$this->extension || stripos($file['extension'], $this->extension) !== false) &&
                   (!$this->path || stripos($file['path'], $this->path) !== false);
        });

        // Apply sorting
        usort($models, function ($a, $b) {
            foreach ($this->sortAttributes() as $attribute) {
                if (isset($a[$attribute]) && isset($b[$attribute])) {
                    $result = strcmp($a[$attribute], $b[$attribute]);
                    if ($result !== 0) {
                        return $result;
                    }
                }
            }
            return 0;
        });

        // Set the filtered and sorted results
        $dataProvider->setModels($models);

        return $dataProvider;
    }

    private function loadFiles()
    {
        $files = [];
        $directories = [
            \Yii::getAlias('@webroot/imagenes'),
            \Yii::getAlias('@webroot/videos'),
            \Yii::getAlias('@webroot/excel'),
        ];

        foreach ($directories as $directory) {
            $files = array_merge($files, $this->scanDirectory($directory));
        }

        return $files;
    }

    private function scanDirectory($directory)
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $files[] = [
                    'name' => $file->getBasename(),
                    'extension' => $file->getExtension(),
                    'path' => str_replace(\Yii::getAlias('@webroot'), '', $file->getPathname()),
                ];
            }
        }
        return $files;
    }

    private function getQuery()
    {
        return new \yii\data\ArrayDataProvider([
            'allModels' => $this->files,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

    private function sortAttributes()
    {
        return ['name', 'extension', 'path'];
    }
}
