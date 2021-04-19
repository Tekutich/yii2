<?php

namespace app\controllers;

use app\models\BalanceOfGoods;
use app\models\Orders;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;
use Yii;

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
        $sheet->getStyle("A1:D1")->getFont()->setBold(true);

        $sheet->setCellValue('A1', '#');
        $sheet->setCellValue('B1', 'ФИО');
        $sheet->setCellValue('C1', 'Товары');
        $sheet->setCellValue('D1', 'Количество');

        foreach ($model as $value) {

            $cellIdStart = 'A' . $i;
            $cellNameStart = 'B' . $i;

            $sheet->setCellValue($cellIdStart, '#' . $value[ 'id' ]);
            $sheet->setCellValue($cellNameStart, $value[ 'user' ][ 'surname' ] . ' ' . $value[ 'user' ][ 'name' ] . ' ' . $value[ 'user' ][ 'patronymic' ]);
            foreach ($value[ 'orderDetails' ] as $product) {
                $cellIdEnd = 'A' . $i;
                $cellNameEnd = 'B' . $i;
                $cellProducts = 'C' . $i;
                $cellCount = 'D' . $i;
                $nameProduct = $product[ 'drugs' ][ 'trade_name' ];
                $characteristicsProduct = $product[ 'drugsCharacteristics' ][ 'form_of_issue' ] . ' ' . $product[ 'drugsCharacteristics' ][ 'dosage' ];
                $sheet->setCellValue($cellProducts, $nameProduct . ', ' . $characteristicsProduct);
                $sheet->setCellValue($cellCount, $product[ 'count' ]);
                $sheet->getRowDimension($i)->setRowHeight(50);
                $i++;
            }

            $sheet->mergeCells("$cellIdStart:$cellIdEnd");
            $sheet->mergeCells("$cellNameStart:$cellNameEnd");
        }
        $rangeBorder = 'A1:D' . $i;
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

    public function actionBalanceOfGoodsTable()
    {
//        $word = new PHPWord();
//
//        $section = $word->addSection();
//
//        $section->addText(
//            '"Learn from yesterday, live for today, hope for tomorrow. '
//            . 'The important thing is not to stop questioning." '
//            . '(Albert Einstein)'
//        );

        $word = new \PhpOffice\PhpWord\PhpWord();

        $section = $word->addSection();
        $styleTable = array('borderSize' => 6, 'borderColor' => '999999');
        $table = $section->addTable($styleTable);
        $table->addRow();
        $cellVCentered = array('align' => 'center','valign' => 'center');
        $textBold=array('bold' => true);
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');


        $table->addCell(2000)->addText('#',$textBold,$cellVCentered);
        $table->addCell(2000)->addText('Наименование',$textBold,$cellVCentered);
        $table->addCell(2000)->addText('Форма выпуска',$textBold,$cellVCentered);
        $table->addCell(2000)->addText('Количество',$textBold,$cellVCentered);

//        //цикл
//        $table->addRow();
//        $table->addCell(2000,$cellRowSpan)->addText('1',array('bold' => false,'align' => 'center'),$cellVCentered);
//        $table->addCell(2000,$cellRowSpan)->addText('цетрин',array('bold' => false,'align' => 'center'),$cellVCentered);
//        $table->addCell(2000)->addText('таблетки',array('bold' => false,'align' => 'center'),$cellVCentered);
//        $table->addCell(2000)->addText('1',array('bold' => false,'align' => 'center'),$cellVCentered);
//
//        $table->addRow();
//        $table->addCell(null, $cellRowContinue);
//        $table->addCell(null, $cellRowContinue);
//        $table->addCell(2000)->addText('спрей',array('bold' => false,'align' => 'center'),$cellVCentered);
//        $table->addCell(2000)->addText('2',array('bold' => false,'align' => 'center'),$cellVCentered);

        $model = BalanceOfGoods::find()
            ->with('drugsDrugsCharacteristicsLink.drugs', 'drugsDrugsCharacteristicsLink.drugsCharacteristics', 'pharmacies')
            ->orderBy(['drugs_drugs_characteristics_link_id' => SORT_ASC, 'pharmacies_id' => SORT_ASC])
            ->all();

        $idDrug=null;

        foreach ($model as $value) {
            if ($value[ 'drugsDrugsCharacteristicsLink' ][ 'drugs_id' ] != $idDrug) {
                $table->addRow();
                $table->addCell(2000, $cellRowSpan)->addText($value[ 'id' ], null, $cellVCentered);
                $table->addCell(2000, $cellRowSpan)->addText($value[ 'drugsDrugsCharacteristicsLink' ][ 'drugs' ][ 'trade_name' ] . ' ' . $value[ 'drugsDrugsCharacteristicsLink' ][ 'drugsCharacteristics' ][ 'form_of_issue' ] . ', ' . $value[ 'drugsDrugsCharacteristicsLink' ][ 'drugsCharacteristics' ][ 'dosage' ], null, $cellVCentered);
            }
            $table->addRow();
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(2000)->addText($value['pharmacies']['name'] . ', ' . $value['pharmacies']['address'],array('bold' => false,'align' => 'center'),$cellVCentered);
            $table->addCell(2000)->addText($value[ 'balance' ],array('bold' => false,'align' => 'center'),$cellVCentered);

            $idDrug = $value[ 'drugsDrugsCharacteristicsLink' ][ 'drugs_id' ];
        }


        $writer = new Word2007($word);
        $response = Yii::$app->getResponse();
        $headers = $response->getHeaders();
        $headers->set('Content-Type', 'application/vnd.ms-office');
        $headers->set('Content-Disposition', 'attachment;filename="Наличие лекарств.docx"');
        $headers->set('Cache-Control: max-age=0');
        ob_start();
        $writer->save("php://output");
        $content = ob_get_contents();
        ob_clean();

        return $content;
    }

    public function actionBalanceOfGoodsList()
    {
        $model = BalanceOfGoods::find()
            ->with('drugsDrugsCharacteristicsLink.drugs', 'drugsDrugsCharacteristicsLink.drugsCharacteristics', 'pharmacies')
            ->orderBy(['drugs_drugs_characteristics_link_id' => SORT_ASC, 'pharmacies_id' => SORT_ASC])
            ->all();

        $word = new PHPWord();
        $section = $word->addSection();
        $idDrug=null;
        $idCharacteristicsOld=null;
        foreach ($model as $value) {
            if ($value[ 'drugsDrugsCharacteristicsLink' ][ 'drugs_id' ] != $idDrug) {
                $section->addTextBreak(1);
                $section->addText(
                    $value[ 'drugsDrugsCharacteristicsLink' ][ 'drugs' ][ 'trade_name' ],
                    array('bold' => true)
                );
                $idCharacteristicsOld = null;
            }
            if ($value[ 'drugsDrugsCharacteristicsLink' ][ 'drugsCharacteristics' ][ 'id' ] != $idCharacteristicsOld) {
                $section->addListItem($value[ 'drugsDrugsCharacteristicsLink' ][ 'drugsCharacteristics' ][ 'form_of_issue' ] . ', ' . $value[ 'drugsDrugsCharacteristicsLink' ][ 'drugsCharacteristics' ][ 'dosage' ], 0);
            }

            $idDrug = $value[ 'drugsDrugsCharacteristicsLink' ][ 'drugs_id' ];
            $idCharacteristicsOld = $value[ 'drugsDrugsCharacteristicsLink' ][ 'drugsCharacteristics' ][ 'id' ];
            $section->addListItem($value[ 'pharmacies' ][ 'name' ] . ', ' . $value[ 'pharmacies' ][ 'address' ] . ' - ' . $value[ 'balance' ] . ' шт.', 1);
        }

        $writer = IOFactory::createWriter($word, 'Word2007');

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
