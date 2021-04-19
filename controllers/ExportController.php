<?php

namespace app\controllers;

use app\models\BalanceOfGoods;
use app\models\Orders;
use app\models\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ExportController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'orders','balance-of-goods-table','balance-of-goods-list'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return User::isUserAdmin(Yii::$app->user->identity->email);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Просмотр страницы с кнопками выбора отчёта
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    /**
     * Подготовка объекта Spreadsheet для вывода заказов
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function actionOrders()
    {
        $model = Orders::find()
            ->with('user', 'orderDetails', 'orderDetails.drugsCharacteristics', 'orderDetails.drugs')
            ->all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle('A:D')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A:D')->getAlignment()->setVertical('center');
        $sheet->getStyle('A:D')->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getStyle("A1:D1")->getFont()->setBold(true);

        $sheet->setCellValue('A1', '#');
        $sheet->setCellValue('B1', 'ФИО');
        $sheet->setCellValue('C1', 'Товары');
        $sheet->setCellValue('D1', 'Количество');

        $number = 1;
        $row = 2;
        foreach ($model as $value) {

            $cellIdStart = 'A' . $row;
            $cellNameStart = 'B' . $row;

            $sheet->setCellValue($cellIdStart, '#' . $number);
            $sheet->setCellValue($cellNameStart, $value['user']['surname'] . ' ' . $value['user']['name'] . ' ' . $value['user']['patronymic']);
            foreach ($value['orderDetails'] as $product) {
                $cellIdEnd = 'A' . $row;
                $cellNameEnd = 'B' . $row;
                $cellProducts = 'C' . $row;
                $cellCount = 'D' . $row;
                $nameProduct = $product['drugs']['trade_name'];
                $characteristicsProduct = $product['drugsCharacteristics']['form_of_issue'] . ' ' . $product['drugsCharacteristics']['dosage'];
                $sheet->setCellValue($cellProducts, $nameProduct . ', ' . $characteristicsProduct);
                $sheet->setCellValue($cellCount, $product['count']);
                $sheet->getRowDimension($row)->setRowHeight(50);
                $row++;
            }

            $sheet->mergeCells("$cellIdStart:$cellIdEnd");
            $sheet->mergeCells("$cellNameStart:$cellNameEnd");
            $number++;
        }
        $rangeBorder = 'A1:D' . $row;
        $sheet->getStyle($rangeBorder)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        return $this->outputFile('Excel', $spreadsheet, 'Заказы.xlsx');
    }

    /**
     * Подготовка объекта phpWord для вывода количества товара (таблицей)
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function actionBalanceOfGoodsTable()
    {
        $model = BalanceOfGoods::find()
            ->with('drugsDrugsCharacteristicsLink.drugs', 'drugsDrugsCharacteristicsLink.drugsCharacteristics', 'pharmacies')
            ->orderBy(['drugs_drugs_characteristics_link_id' => SORT_ASC, 'pharmacies_id' => SORT_ASC])
            ->all();

        $word = new \PhpOffice\PhpWord\PhpWord();

        $section = $word->addSection();
        $styleTable = array('borderSize' => 6, 'borderColor' => '999999', 'alignment' => 'center');
        $cellVCentered = array('align' => 'center',);
        $cellHCentered = array('valign' => 'center');
        $textBold = array('bold' => true);
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');

        $table = $section->addTable($styleTable);
        $table->addRow();
        $table->addCell(1000)->addText('#', $textBold, $cellVCentered);
        $table->addCell(2000)->addText('Наименование', $textBold, $cellVCentered);
        $table->addCell(2000)->addText('Аптека', $textBold, $cellVCentered);
        $table->addCell(2000)->addText('Количество', $textBold, $cellVCentered);

        $idDrug = null;
        $number = 1;

        foreach ($model as $value) {
            $table->addRow();
            if ($value['drugsDrugsCharacteristicsLink']['drugs_id'] != $idDrug) {
                $table->addCell(1000, $cellRowSpan)->addText('#' . $number, null, $cellVCentered);
                $table->addCell(2000, $cellRowSpan)->addText($value['drugsDrugsCharacteristicsLink']['drugs']['trade_name'] . ' ' . $value['drugsDrugsCharacteristicsLink']['drugsCharacteristics']['form_of_issue'] . ', ' . $value['drugsDrugsCharacteristicsLink']['drugsCharacteristics']['dosage'], null, $cellVCentered);
            } else {
                $table->addCell(null, $cellRowContinue);
                $table->addCell(null, $cellRowContinue);
            }
            $table->addCell(2000, $cellHCentered)->addText($value['pharmacies']['name'] . ', ' . $value['pharmacies']['address'], null, $cellVCentered);
            $table->addCell(2000, $cellHCentered)->addText($value['balance'], null, $cellVCentered);

            $idDrug = $value['drugsDrugsCharacteristicsLink']['drugs_id'];
            $number++;
        }

        return $this->outputFile('Word', $word, 'Наличие лекарств.docx');
    }

    /**
     * Подготовка объекта phpWord для вывода количества товара (списком)
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function actionBalanceOfGoodsList()
    {
        $model = BalanceOfGoods::find()
            ->with('drugsDrugsCharacteristicsLink.drugs', 'drugsDrugsCharacteristicsLink.drugsCharacteristics', 'pharmacies')
            ->orderBy(['drugs_drugs_characteristics_link_id' => SORT_ASC, 'pharmacies_id' => SORT_ASC])
            ->all();

        $word = new PHPWord();
        $section = $word->addSection();
        $idDrug = null;
        $idCharacteristicsOld = null;
        foreach ($model as $value) {
            if ($value['drugsDrugsCharacteristicsLink']['drugs_id'] != $idDrug) {
                $section->addTextBreak(1);
                $section->addText(
                    $value['drugsDrugsCharacteristicsLink']['drugs']['trade_name'],
                    array('bold' => true)
                );
                $idCharacteristicsOld = null;
            }
            if ($value['drugsDrugsCharacteristicsLink']['drugsCharacteristics']['id'] != $idCharacteristicsOld) {
                $section->addListItem($value['drugsDrugsCharacteristicsLink']['drugsCharacteristics']['form_of_issue'] . ', ' . $value['drugsDrugsCharacteristicsLink']['drugsCharacteristics']['dosage'], 0);
            }

            $idDrug = $value['drugsDrugsCharacteristicsLink']['drugs_id'];
            $idCharacteristicsOld = $value['drugsDrugsCharacteristicsLink']['drugsCharacteristics']['id'];
            $section->addListItem($value['pharmacies']['name'] . ', ' . $value['pharmacies']['address'] . ' - ' . $value['balance'] . ' шт.', 1);
        }

        return $this->outputFile('Word', $word, 'Наличие лекарств.docx');
    }

    /**
     * Функция вывовода файла пользователю
     * @param $type *Тип либо Word либо Excel
     * @param $object *объект phpOffice
     * @param $filename *имя файла
     * @return false|string
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function outputFile($type, $object, $filename)
    {
        switch ($type) {
            case 'Excel':
                $writer = new Xlsx($object);
                break;
            case 'Word':
                $writer = new Word2007($object);
                break;
            default:
                $word = new PHPWord();
                $section = $word->addSection();
                $section->addText("Системная ошибка выбора типа приложения");
                $writer = new Word2007($word);
        }

        $response = Yii::$app->getResponse();
        $headers = $response->getHeaders();
        $headers->set('Content-Disposition', 'attachment;filename=' . $filename . '');
        $headers->set('Cache-Control: max-age=0');
        ob_start();
        $writer->save("php://output");
        $content = ob_get_contents();
        ob_clean();

        return $content;
    }
}
