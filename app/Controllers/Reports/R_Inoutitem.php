<?php

namespace App\Controllers\Reports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yidas\phpSpreadsheet\Helper as ExcelHelper;
use App\Controllers\Base_Controller;
use App\Enums\ReportIonoutItemType;
use App\Models\T_inoutitemdetails;
use App\Models\M_enumdetails;
use App\Models\T_inoutitems;

class R_Inoutitem extends Base_Controller
{
    public function viewinoutitem()
    {
        if ($this->hasReportPermission('InOutItem', 'Read')) {
            $this->loadView("reports/inoutitem", lang('Form.report') . " " . lang("Form.item"), array());
        }
    }

    public function printreport()
    {
        
        if($this->hasReportPermission('InOutItem','Read'))
        {
            $type = $this->request->post("Type");
            if ($type == ReportIonoutItemType::MOVEMENT)
                $this->movement();
            else
                $this->summary();
        }
    }

    public function movement()
    {

        $warehouse = $this->request->post("Warehouse");
        $item = $this->request->post("Item");

        $params = [
            'whereIn' => [
                'M_Warehouse_Id' => $warehouse,
                'M_Item_Id' => $item
            ]
        ];

        // $parent = T_inoutitems::getAll();

        $title = "Laporan Keluar Masuk Barang";
        $header = [
            ["value" => lang("Form.item"), "col" => 1, 'width' => 40, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.status"), 'width' => 20, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.qty"), 'width' => 15, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.uom"), 'width' => 15, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.warehouse"), 'width' => 15, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.recipient"), 'width' => 15, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.description"), 'width' => 15, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
        ];

        $spreadsheet = ExcelHelper::newSpreadsheet();
        $spreadsheet->addRow([$title]);

        $params = [
            'whereIn' => [
                'M_Warehouse_Id' => $warehouse,
                'M_Item_Id' => $item
            ],
            'order' => [
                'T_Inoutitem_Id' => "ASC"
            ]
        ];
        // foreach ($parent as $data) {
        $itemid = 0;
        foreach (T_inoutitemdetails::getAll($params) as $detail) {
            $parent = T_inoutitems::get($detail->T_Inoutitem_Id );
            if ($detail->T_Inoutitem_Id  != $itemid) {

                $parentdata = [
                    'value' => $parent->TransNo . " - Tanggal : " . get_formated_date($parent->Date,  "d-m-Y")
                ];
                $spreadsheet->addRow(["value" => ""]);
                $spreadsheet->addRow($parentdata);
                $spreadsheet->addRow($header);
                $itemid = $detail->T_Inoutitem_Id ;
                // echo json_encode($parent);
            }

            $item = $detail->get_M_Item();
            $det = [
                ["value" => $item->Name],
                ["value" => M_enumdetails::getEnumName("InOutItemType",  $parent->TransType), "width" => 15],
                $detail->Qty,
                $item->get_M_Uom()->Name,
                $detail->get_M_Warehouse()->Name,
                $detail->Recipient,
                $detail->Description
            ];
            $spreadsheet->addRow($det);
        }

        $spreadsheet->output('Laporan Pergerakan Keluar Masuk Barang  ', "Xls");
    }

    private function summary()
    { }
}
