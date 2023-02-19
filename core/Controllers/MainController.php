<?php

namespace Core\Controllers;

use Core\Models\AppTopModel;
use Core\Tools\CurlClass;
use Core\Tools\ParserCategories;
use DateTime;
use VVF\Controllers\Controller;
use VVF\ErrorHandler\ErrorHandler;

class MainController extends Controller
{
    private ?AppTopModel $appTop = null;
    private string $date = '';

    public function index(): void
    {
        $this->render('Main.index');
    }

    public function appTopCategory(): void
    {
        $this->dateValidate();

        $this->appTop = new AppTopModel();
        $dateInBd = $this->appTop->select(['category', 'position'])->where('date', '=',  $this->date)->get();

        if (!$dateInBd) {
            $top = $this->getAppTopAndSave();
        } else {
            $top = ParserCategories::convertDbTopToJson($dateInBd);
        }

        echo json_encode($top);
    }



    private function getAppTopAndSave(): array
    {
        $categories = json_decode($this->getCategoriesSite(), true);
        
        if($categories['status_code'] != 200){
            return $categories;
        }

        $categoriesPrepare = ParserCategories::prepareCategories($categories);
        $this->appTop->saveInDbCategories($categoriesPrepare, $this->date);

        if (empty($categoriesPrepare)) {
            $json['status'] = false;
        }

        $json['status'] = true;
        $json['categories'] = $categoriesPrepare;

        return $json;
    }

    private function getCategoriesSite(): string
    {

        $dateFrom = DateTime::createFromFormat('Y-m-d', $this->date)->format('Y-m-d');
        $dateTo = DateTime::createFromFormat('Y-m-d', $this->date)->modify('+1 day')->format('Y-m-d');
        $conf = require $_SERVER['DOCUMENT_ROOT'] . '\conf.php';
        $link = $conf['api.test']['apptica'];
        $content = CurlClass::getSiteContent("$link?date_from=$dateFrom&date_to=$dateTo&B4NKGg=fVN5Q9KVOlOHDx9mOsKPAQsFBlEhBOwguLkNEDTZvKzJzT3l");
        return $content;
    }

    private function dateValidate(): void
    {
        if (empty($_GET['date'])) {
            $this->redirect();
        }

        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_GET['date'])) {
            throw new ErrorHandler('Неизвестный формат даты');
        }

        $this->date = $_GET['date'];
    }
}
