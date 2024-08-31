<?php

namespace app\models;

use yii\base\Model;
use yii\data\ArrayDataProvider;

class FileSearch extends Model
{
    public $name;
    public $extension;
    public $path;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'extension', 'path'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ArrayDataProvider
     */
    public function search($params)
    {
        // Obtener todos los archivos
        $files = File::findAllFiles();

        // Crear el DataProvider con todos los archivos
        $dataProvider = new ArrayDataProvider([
            'allModels' => $files,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['name', 'extension', 'path'],
                'defaultOrder' => ['name' => SORT_ASC], // Orden por defecto
            ],
        ]);

        // Cargar los parámetros de búsqueda
        $this->load($params);

        // Filtrar los archivos
        $filteredFiles = array_filter($files, function ($file) {
            /** @var File $file */
            return (
                (!$this->name || stripos($file->name, $this->name) !== false) &&
                (!$this->extension || stripos($file->extension, $this->extension) !== false) &&
                (!$this->path || stripos($file->path, $this->path) !== false)
            );
        });

        // Aplicar la ordenación según el DataProvider
        $sort = $dataProvider->sort;
        $sortAttribute = $sort->attributes ? array_key_first($sort->attributes) : 'name';
        $sortDirection = $sort->defaultOrder[$sortAttribute] ?? SORT_ASC;

        usort($filteredFiles, function ($a, $b) use ($sortAttribute, $sortDirection) {
            $valueA = $a->{$sortAttribute};
            $valueB = $b->{$sortAttribute};

            if ($valueA == $valueB) {
                return 0;
            }

            $result = ($valueA < $valueB) ? -1 : 1;
            return $sortDirection === SORT_DESC ? -$result : $result;
        });

        // Aplicar la paginación manualmente
        $pagination = $dataProvider->pagination;
        $pageSize = $pagination->pageSize;
        $currentPage = $pagination->page;

        $dataProvider->allModels = array_slice($filteredFiles, $currentPage * $pageSize, $pageSize);

        return $dataProvider;
    }
}
