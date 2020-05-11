<?php

namespace App\Controllers\Reports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yidas\phpSpreadsheet\Helper as ExcelHelper;
use App\Controllers\Base_Controller;
use App\Models\M_villages;
use Core\Database\DBBuilder;
use App\Models\M_livestocks;
use App\Models\M_familycards;
use App\Models\M_subvillages;

class R_Population extends Base_Controller
{
    public function viewpopulation()
    {
        if ($this->hasReportPermission('Population', 'Read')) {
            $this->loadView("reports/population", lang('Form.report') . " " . lang("Form.population"), array());
        }
    }
    public function printreport()
    {
        if ($this->hasReportPermission('Population', 'Read')) {
            $type = !empty($this->request->post("M_Subvillage_Id")) ? $this->request->post("M_Subvillage_Id") : 0;
            $builder = new DBBuilder();
            $cond="";
            if($type)
                $cond = "WHERE a.M_Subvillage_Id = {$type}";

            $sql = "SELECT a.M_Subvillage_Id ,
            a.RW, COUNT(a.RW) KK, 
            male.Male, 
            female.Female, 
            IFNULL(a1.a1, 0) a1, 
            IFNULL(a5.a5, 0) a5, 
            IFNULL(a10.a10, 0) a10,
            IFNULL(a55.a55, 0) a55,
            IFNULL(lansia.lansia, 0) lansia
            FROM m_familycards a
            LEFT JOIN (
            SELECT a.M_Subvillage_Id ,RW, Gender, COUNT(Gender) Male
            FROM m_familycards a
            INNER JOIN m_familycardmembers c ON c.M_Familycard_Id = a.Id
            WHERE Gender  = 1
            GROUP BY a.M_Subvillage_Id, RW, Gender
            ) male ON male.M_Subvillage_Id = a.M_Subvillage_Id
            LEFT JOIN (
            SELECT a.M_Subvillage_Id ,RW, Gender, COUNT(Gender) Female
            FROM m_familycards a
            INNER JOIN m_familycardmembers c ON c.M_Familycard_Id = a.Id
            WHERE Gender  = 2
            GROUP BY a.M_Subvillage_Id, RW, Gender
            )female ON female.M_Subvillage_Id = a.M_Subvillage_Id
            LEFT JOIN (
            SELECT a.M_Subvillage_Id ,RW, COUNT(c.Id) a1
            FROM m_familycards a
            INNER JOIN m_familycardmembers c ON c.M_Familycard_Id = a.Id
            WHERE YEAR(CURDATE()) - YEAR(birthdate) <= 1
            GROUP BY a.M_Subvillage_Id, RW
    
            )a1 ON a1.M_Subvillage_Id = a.M_Subvillage_Id
            LEFT JOIN (
            SELECT a.M_Subvillage_Id ,RW, COUNT(c.Id) a5
            FROM m_familycards a
            INNER JOIN m_familycardmembers c ON c.M_Familycard_Id = a.Id
            WHERE YEAR(CURDATE()) - YEAR(birthdate) <= 5 AND YEAR(CURDATE()) - YEAR(birthdate) > 1
            GROUP BY a.M_Subvillage_Id, RW
    
            )a5 ON a5.M_Subvillage_Id = a.M_Subvillage_Id
            LEFT JOIN (
            SELECT a.M_Subvillage_Id ,RW, COUNT(c.Id) a10
            FROM m_familycards a
            INNER JOIN m_familycardmembers c ON c.M_Familycard_Id = a.Id
            WHERE YEAR(CURDATE()) - YEAR(birthdate) <= 10 AND YEAR(CURDATE()) - YEAR(birthdate) > 5
            GROUP BY a.M_Subvillage_Id, RW
    
            )a10 ON a10.M_Subvillage_Id = a.M_Subvillage_Id
            LEFT JOIN (
            SELECT a.M_Subvillage_Id ,RW, COUNT(c.Id) a55
            FROM m_familycards a
            INNER JOIN m_familycardmembers c ON c.M_Familycard_Id = a.Id
            WHERE YEAR(CURDATE()) - YEAR(birthdate) <= 55 AND YEAR(CURDATE()) - YEAR(birthdate) > 10
            GROUP BY a.M_Subvillage_Id, RW
    
            )a55 ON a55.M_Subvillage_Id = a.M_Subvillage_Id
            LEFT JOIN (
            SELECT a.M_Subvillage_Id ,RW, COUNT(c.Id) lansia
            FROM m_familycards a
            INNER JOIN m_familycardmembers c ON c.M_Familycard_Id = a.Id
            WHERE YEAR(CURDATE()) - YEAR(birthdate) > 55
            GROUP BY a.M_Subvillage_Id, RW
    
            )lansia ON lansia.M_Subvillage_Id = a.M_Subvillage_Id
            {$cond}
            GROUP BY a.M_Subvillage_Id, RW, male, female, a1, a5, a10, a55, lansia";

            $results = $builder->query($sql)->fetchObject();
            $title = "Data Penduduk";
            $location = "Lokasi : ";
            if ($this->request->post("M_Subvillage_Id")) {
                $loc = M_subvillages::get($this->request->post("M_Subvillage_Id"));

                $location = "Lokasi : $loc->Name ," . $loc->get_M_Village()->Name . ", ". $loc->get_M_Village()->get_M_Subdistrict()->Name . ", " . $loc->get_M_Village()->get_M_Subdistrict()->get_M_District()->Name . ", " . $loc->get_M_Village()->get_M_Subdistrict()->get_M_District()->get_M_Province()->Name;
            }


            $spreadsheet = ExcelHelper::newSpreadsheet();
            $spreadsheet->addRow([$title]);
            $spreadsheet->addRow([$location]);

            $header = [
                ["value" => "No", 'width' => 10, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => '279d06'],
                    ]
                ]],
                ["value" => lang("Form.address"), 'width' => 30, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => '279d06'],
                    ]
                ]],
                ["value" => "Jumlah KK", 'width' => 15, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => '279d06'],
                    ]
                ]],
                ["value" => lang("Form.male"), 'width' => 15, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => '279d06'],
                    ]
                ]],
                ["value" => lang("Form.female"), 'width' => 15, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => '279d06'],
                    ]
                ]],
                ["value" => "Bayi 0 - 12 bl", 'width' => 15, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => '279d06'],
                    ]
                ]],
                ["value" => "Balita 1-5 thn", 'width' => 15, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => '279d06'],
                    ]
                ]],
                ["value" => "Balita 1-5 thn", 'width' => 15, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => '279d06'],
                    ]
                ]],
                ["value" => "Anak 5-10 thn", 'width' => 15, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => '279d06'],
                    ]
                ]],
                ["value" => "Dewasa 10-55 thn", 'width' => 15, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => '279d06'],
                    ]
                ]],
                ["value" => "Lansia", 'width' => 15, 'style' => [
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

            $collivetock = [
                ["value" => "", 'width' => 3, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ]
                ]],
                ["value" => lang("Form.livestock"), 'width' => 30, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ]
                ]],
                ["value" => lang("Form.qty"), 'width' => 15, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ]
                ]],
            ];



            $spreadsheet->addRow(["value" => ""]);
            $spreadsheet->addRow($header);

            $i = 1;
            $alllivestock = array();
            foreach ($results as $data) {
                $subvillage = M_subvillages::get($data->M_Subvillage_Id);
                $det = [
                    ["value" => $i, "width" => 10],
                    $subvillage->Name . " RW : {$data->RW} " .
                        $subvillage->get_M_Village()->get_M_Subdistrict()->Name . " " .
                        $subvillage->get_M_Village()->get_M_Subdistrict()->get_M_District()->Name . " " .
                        $subvillage->get_M_Village()->get_M_Subdistrict()->get_M_District()->get_M_Province()->Name,
                    $data->KK,
                    $data->Male,
                    $data->Female,
                    $data->a1,
                    $data->a5,
                    $data->a10,
                    $data->a55,
                    $data->lansia



                ];

                $spreadsheet->addRow($det);
                $params = [
                    'where' => [
                        'M_Subvillage_Id' => $data->M_Subvillage_Id,
                        "RW" =>  $data->RW
                    ]
                ];
                $familycards = M_familycards::getAll($params);


                $livestocks = array();
                foreach ($familycards as $familycard) {

                    foreach ($familycard->get_list_M_Familycardlivestock() as $livestock) {
                        $animal = M_livestocks::get($livestock->M_Livestock_Id);
                        // $live = [
                        //     $animal->Name => $livestock->Qty
                        // ];
                        if (!array_key_exists($animal->Name, $livestocks)) {
                            $livestocks[$animal->Name] = $livestock->Qty;
                        } else {
                            foreach ($livestocks as $key => $livestockexist) {
                                if ($key == $animal->Name) {
                                    $livestocks[$key] += $livestock->Qty;
                                }
                            }
                        }


                        if (!array_key_exists($animal->Name, $alllivestock)) {
                            $alllivestock[$animal->Name] = $livestock->Qty;
                        } else {
                            foreach ($alllivestock as $key => $livestockexist) {
                                if ($key == $animal->Name) {
                                    $alllivestock[$key] += $livestock->Qty;
                                }
                            }
                        }
                    }
                }

                if (count($livestocks) > 0) {
                    $spreadsheet->addRow($collivetock);
                    foreach ($livestocks as $key => $qty) {

                        $det = [
                            ["value" => "", "width" => 3],
                            $key,
                            $qty
                        ];
                        $spreadsheet->addRow($det);
                    }

                    $spreadsheet->addRow(["value" => ""]);
                }
                // 
                $i++;
            }

            $colltotalivetocks = [
                ["value" => "Jumlah Total Ternak", 'col' => 3, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'e7eb00'],
                    ]
                ]],
            ];
            $colltotalivetock = [
                ["value" => "", 'width' => 3, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'e7eb00'],
                    ]
                ]],
                ["value" => lang("Form.livestock"), 'width' => 30, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'e7eb00'],
                    ]
                ]],
                ["value" => lang("Form.qty"), 'width' => 15, 'style' => [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'e7eb00'],
                    ]
                ]],
            ];
            if (count($alllivestock) > 0) {
                $spreadsheet->addRow($colltotalivetocks);
                $spreadsheet->addRow($colltotalivetock);
                foreach ($alllivestock as $key => $qty) {

                    $det = [
                        ["value" => "", "width" => 3],
                        $key,
                        $qty
                    ];
                    $spreadsheet->addRow($det);
                }

                $spreadsheet->addRow(["value" => ""]);
            }

            $spreadsheet->output('Laporan Data Penduduk', 'Xls');
        }
    }
}
