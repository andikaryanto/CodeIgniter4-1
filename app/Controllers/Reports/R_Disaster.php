<?php

namespace App\Controllers\Reports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yidas\phpSpreadsheet\Helper as ExcelHelper;
use App\Controllers\Base_Controller;
use App\Enums\ReportType;
use App\Models\M_villages;
use App\Models\M_enumdetails;
use App\Models\T_disasteroccurs;
use App\Models\M_impacts;

class R_Disaster extends Base_Controller
{
    public function viewdisaster()
    {
        if ($this->hasReportPermission('Disaster', 'Read')) {

            $this->loadView("reports/disaster", lang('Form.report') . " " . lang("Form.disaster"), array());
        }
    }
    public function printreport()
    {
        if ($this->hasReportPermission('Disaster', 'Read')) {
            $type = $this->request->post("Type");
            if ($type == ReportType::SUMMARY){
                $this->summary();
            } else {
                $this->detail();
            }
            redirect("report")->go();

        }
    }

    private function detail()
    {
        $from = get_formated_date($this->request->post("DateFrom"), "Y-m-d");
        $to = get_formated_date($this->request->post("DateTo"), "Y-m-d");

        $datefrom =  $from . " 00:00:00";
        $dateto = $to . " 23:59:59";

        $where = [
            'where' => [
                'DateOccur >=' => $datefrom,
                'DateOccur <=' => $dateto,
                'M_Village_Id' => $this->request->post("M_Village_Id")
            ],
            'whereIn' => [
                'M_Disaster_Id' => $this->request->post("Disaster"),
                'Status' => $this->request->post("Status")
            ]
        ];

        $model = T_disasteroccurs::getAll($where);
        $title = "";
        if ($this->request->post("M_Disaster_Id") && count($this->request->post("M_Disaster_Id")) > 1)
            $title = "Rekap Dampak Bencana";
        else
            $title = "Rekap Dampak {$model[0]->get_M_Disaster()->Name}";

        $date = "Periode : $from ~ $to";


        $location = "Lokasi : ";
        if ($this->request->post("M_Village_Id")) {
            $loc = M_villages::get($this->request->post("M_Village_Id"));

            $location = "Lokasi : $loc->Name ," . $loc->get_M_Subdistrict()->Name . ", " . $loc->get_M_Subdistrict()->get_M_District()->Name . ", " . $loc->get_M_Subdistrict()->get_M_District()->get_M_Province()->Name;
        }

        $status = "Status : ";

        if ($this->request->post("Status")) {
            foreach ($this->request->post("Status") as $stat) {
                $status .= M_enumdetails::getEnumName("DisasterOccurStatus", $stat) . ", ";
            }
        }

        $header = [
            ["value" => "No", "col" => 3, 'width' => 40, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.date"), 'width' => 30, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.status"), 'width' => 15, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.village"), 'width' => 15, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.subdistrict"), 'width' => 15, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.district"), 'width' => 15, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.province"), 'width' => 15, 'style' => [
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

        $impactcol = [
            ["value" => ""],
            ["value" => ""],
            ["value" => lang("Form.impact"), "col" => 1, 'width' => 15, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ]
            ]],
            ["value" => lang("Form.qty"), "col" => 1, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ]
            ]]
        ];

        $victimcol = [
            ["value" => ""],
            ["value" => ""],
            ["value" => lang("Form.familycard"), "col" => 1, 'width' => 15, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ]
            ]],
            ["value" => lang("Form.name"), "col" => 1, 'width' => 30, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ]
            ]],
            ["value" => "NIK", "col" => 1, 'width' => 30, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ]
            ]],
            ["value" => lang("Form.gender"), "col" => 1, 'width' => 30, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ]
            ]],
            ["value" => lang("Form.religion"), "col" => 1, 'width' => 30, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ]
            ]],
        ];

        $spreadsheet = ExcelHelper::newSpreadsheet();
        $spreadsheet->addRow([$title]);
        $spreadsheet->addRow([$date]);
        $spreadsheet->addRow([$location]);
        $spreadsheet->addRow([$status]);

        $i = 1;
        $detail = [];
        foreach ($model as $data) {
            $spreadsheet->addRow(["value" => ""]);
            $spreadsheet->addRow($header);
            $det = [
                ["value" => "", "width" => 3],
                ["value" => $data->TransNo . " ~ " . $data->get_M_Disaster()->Name, "col" => 2, "width" => 35],
                $data->DateOccur,
                M_enumdetails::getEnumName("DisasterOccurStatus", $data->Status),
                $data->get_M_Subvillage()->Name . " RT : {$data->RT} RW : {$data->RW} ," . $data->get_M_Subvillage()->get_M_Village()->Name,
                $data->get_M_Subvillage()->get_M_Village()->get_M_Subdistrict()->Name,
                $data->get_M_Subvillage()->get_M_Village()->get_M_Subdistrict()->get_M_District()->Name,
                $data->get_M_Subvillage()->get_M_Village()->get_M_Subdistrict()->get_M_District()->get_M_Province()->Name,
            ];

            $spreadsheet->addRow($det);
            $impacts = $data->get_list_T_Disasteroccurimpact();
            $victims = $data->get_list_T_Disasteroccurvictim();

            if (count($impacts) > 0) {
                $preimpact = [
                    ["value" => ""],
                    [
                        "value" => lang("Form.impact"), 'style' => [
                            'font' => [
                                'bold' => true,
                                'color' => ['argb' => '000']
                            ]
                        ]
                    ]
                ];
                $spreadsheet->addRow($preimpact);
                $spreadsheet->addRow($impactcol);
                foreach ($impacts as $impact) {
                    $impactdata = [
                        "",
                        ["value" => "", "width" => 3],
                        ["value" => $impact->get_M_Impact()->Name, "width" => 25],
                        $impact->Quantity
                    ];

                    $spreadsheet->addRow($impactdata);
                }
            }

            if (count($victims) > 0) {

                $previctim = [
                    ["value" => ""],
                    [
                        "value" => lang("Form.victim"), 'style' => [
                            'font' => [
                                'bold' => true,
                                'color' => ['argb' => '000']
                            ]
                        ]
                    ]
                ];
                $spreadsheet->addRow($previctim);
                $spreadsheet->addRow($victimcol);
                foreach ($victims as $victim) {
                    $familycard = $victim->get_M_Familycard();
                    $victimdata = [
                        "",
                        ["value" => "", "width" => 3],
                        ["value" => $familycard->FamilyCardNo . " " . $familycard->getHeadFamily(), "width" => 25],
                        $victim->Name,
                        $victim->NIK,
                        M_enumdetails::getEnumName("Gender", $victim->Gender),
                        M_enumdetails::getEnumName("Religion", $victim->Religion),

                    ];

                    $spreadsheet->addRow($victimdata);
                }
            }

            if (count($impacts) || count($victims) > 0) {
                $spreadsheet->addRow(["value" => ""]);
            }
            $i++;
        }


        $spreadsheet->output('Laporan Kejadian Detil ' . $date, "Xls");
    }

    private function summary()
    {
        $from = get_formated_date($this->request->post("DateFrom"), "Y-m-d");
        $to = get_formated_date($this->request->post("DateTo"), "Y-m-d");

        $datefrom =  $from . " 00:00:00";
        $dateto = $to . " 23:59:59";

        $where = [
            'where' => [
                'DateOccur >=' => $datefrom,
                'DateOccur <=' => $dateto,
                'M_Village_Id' => $this->request->post("M_Village_Id")
            ],
            'whereIn' => [
                'M_Disaster_Id' => $this->request->post("Disaster"),
                'Status' => $this->request->post("Status")
            ]
        ];

        $model = T_disasteroccurs::getAll($where);
        $title = "";
        if ($this->request->post("M_Disaster_Id") && count($this->request->post("M_Disaster_Id")) > 1)
            $title = "Rekap Dampak Bencana";
        else
            $title = "Rekap Dampak {$model[0]->get_M_Disaster()->Name}";

        $date = "Periode : $from ~ $to";


        $location = "Lokasi : ";
        if ($this->request->post("M_Village_Id")) {
            $loc = M_villages::get($this->request->post("M_Village_Id"));

            $location = "Lokasi : $loc->Name ," . $loc->get_M_Subdistrict()->Name . ", " . $loc->get_M_Subdistrict()->get_M_District()->Name . ", " . $loc->get_M_Subdistrict()->get_M_District()->get_M_Province()->Name;
        }

        $status = "Status : ";

        if ($this->request->post("Status")) {
            foreach ($this->request->post("Status") as $stat) {
                $status .= M_enumdetails::getEnumName("DisasterOccurStatus", $stat) . ", ";
            }
        }
        $header = [
            ["value" => "No", 'width' => 40, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.date"), 'width' => 30, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.status"), 'width' => 15, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.address"), 'width' => 60, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => "NIR", 'width' => 15, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.reportername"), 'width' => 15, 'style' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '279d06'],
                ]
            ]],
            ["value" => lang("Form.disasterreport"), 'width' => 15, 'style' => [
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
        $spreadsheet->addRow([$date]);
        $spreadsheet->addRow([$location]);
        $spreadsheet->addRow([$status]);
        $spreadsheet->addRow(["value" => ""]);
        $spreadsheet->addRow($header);

        foreach ($model as $data) {
            $det = [
                ["value" => $data->TransNo . " ~ " . $data->get_M_Disaster()->Name, "width" => 35],
                $data->DateOccur,
                M_enumdetails::getEnumName("DisasterOccurStatus", $data->Status),
                $data->get_M_Subvillage()->Name . " RT : {$data->RT} RW : {$data->RW} ," . $data->get_M_Subvillage()->get_M_Village()->Name . ", " .
                    $data->get_M_Subvillage()->get_M_Village()->get_M_Subdistrict()->Name . ", " .
                    $data->get_M_Subvillage()->get_M_Village()->get_M_Subdistrict()->get_M_District()->Name . ", " .
                    $data->get_M_Subvillage()->get_M_Village()->get_M_Subdistrict()->get_M_District()->get_M_Province()->Name,
                $data->NIR,
                $data->ReporterName,
                $data->get_T_Disasterreport()->ReportNo,

            ];
            $spreadsheet->addRow($det);
        }

        $spreadsheet->output('Laporan Kejadian Rekap ' . $date, "Xls");
    }
}
