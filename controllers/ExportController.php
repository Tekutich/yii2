<?php

namespace app\controllers;

use app\models\Orders;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use Yii;
use yii\helpers\VarDumper;

class ExportController extends \yii\web\Controller
{
    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionOrders()
    {

        $model = Orders::find()
            ->with('user', 'orderDetails', 'orderDetails.drugsCharacteristics', 'orderDetails.drugs')
            ->all();
        $i = 2;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle('A:D')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A:D')->getAlignment()->setVertical('center');
        $sheet->getStyle('A:D')->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getStyle("A1:D1")->getFont()->setBold( true );

        $sheet->setCellValue('A1', '#');
        $sheet->setCellValue('B1', 'ФИО');
        $sheet->setCellValue('C1', 'Товары');
        $sheet->setCellValue('D1', 'Количество');

        foreach ($model as $value) {

            $cellIdStart = 'A' . $i;
            $cellNameStart = 'B' . $i;

            $sheet->setCellValue($cellIdStart, '#' . $value['id']);
            $sheet->setCellValue($cellNameStart, $value['user']['surname'] . ' ' . $value['user']['name'] . ' ' . $value['user']['patronymic']);
            foreach ($value['orderDetails'] as $product) {
                $cellIdEnd = 'A' . $i;
                $cellNameEnd = 'B' . $i;
                $cellProducts = 'C' . $i;
                $cellCount = 'D' . $i;
                $nameProduct = $product['drugs']['trade_name'];
                $characteristicsProduct = $product['drugsCharacteristics']['form_of_issue'] . ' ' . $product['drugsCharacteristics']['dosage'];
                $sheet->setCellValue($cellProducts, $nameProduct . ', ' . $characteristicsProduct);
                $sheet->setCellValue($cellCount, $product['count']);
                $sheet->getRowDimension($i)->setRowHeight(50);
                $i++;
            }

            $sheet->mergeCells("$cellIdStart:$cellIdEnd");
            $sheet->mergeCells("$cellNameStart:$cellNameEnd");
        }
        $rangeBorder='A1:D'.$i;
        $sheet->getStyle($rangeBorder)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $writer = new Xlsx($spreadsheet);

        $response = Yii::$app->getResponse();
        $headers = $response->getHeaders();
        $headers->set('Content-Type', 'application/vnd.ms-excel');
        $headers->set('Content-Disposition', 'attachment;filename="Заказы.xlsx"');
        $headers->set('Cache-Control: max-age=0');
        ob_start();
        $writer->save("php://output");
        $content = ob_get_contents();
        ob_clean();

        return $content;
    }

    public function actionAvailabilityOfGoodsFormOne()
    {
        $word = new PHPWord();

        $section = $word->addSection();

        $section->addText(
            '"Learn from yesterday, live for today, hope for tomorrow. '
            . 'The important thing is not to stop questioning." '
            . '(Albert Einstein)'
        );

        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($word, 'Word2007');

        $response = Yii::$app->getResponse();
        $headers = $response->getHeaders();
        $headers->set('Content-Type', 'application/vnd.ms-office');
        $headers->set('Content-Disposition', 'attachment;filename="Наличие.docx"');
        $headers->set('Cache-Control: max-age=0');
        ob_start();
        $writer->save("php://output");
        $content = ob_get_contents();
        ob_clean();

        return $content;
    }
}
