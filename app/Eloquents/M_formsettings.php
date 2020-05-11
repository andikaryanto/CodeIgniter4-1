<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;

class M_formsettings extends BaseEloquent
{

    public $Id;
    public $M_Form_Id;
    public $TypeTrans;
    public $Value;
    public $Name;
    public $IntValue;
    public $StringValue;
    public $DecimalValue;
    public $DateTimeValue;
    public $BooleanValue;


    protected $table = "m_formsettings";
    static $primaryKey = "Id";

    public function __construct()
    {
        parent::__construct();
    }

    public static function getTDisasterReportFormat()
    {
        $forms = M_forms::findDataByName(form_paging()['t_disasterreport']);
        $params = array(
            'where' => array(
                'M_Form_Id' => $forms->Id,
                'Name' => 'NUMBERING_FORMAT'
            )
        );

        return static::findOne($params);
    }

    public static function getTDisasterOccurFormat()
    {

        $forms = M_forms::findDataByName(form_paging()['t_disasteroccur']);
        $params = array(
            'where' => array(
                'M_Form_Id' => $forms->Id,
                'Name' => 'NUMBERING_FORMAT'
            )
        );

        return static::findOne($params);
    }

    public static function getTInOutItemFormat()
    {

        $forms = M_forms::findDataByName(form_paging()['t_inoutitem']);
        $params = array(
            'where' => array(
                'M_Form_Id' => $forms->Id,
                'Name' => 'NUMBERING_FORMAT'
            )
        );

        return static::findOne($params);
    }

    public static function getMUserLocation()
    {

        $forms = M_forms::findDataByName(form_paging()['m_userlocation']);
        $params = array(
            'where' => array(
                'M_Form_Id' => $forms->Id,
                'Name' => 'TRACK_USER_LOCATION'
            )
        );

        return static::findOne($params);
    }

    public static function getImpactCompensation()
    {

        $forms = M_forms::findDataByName(form_paging()['m_impact']);
        $params = array(
            'where' => array(
                'M_Form_Id' => $forms->Id,
                'Name' => 'IMPACT_COMPENSATION_X_1M'
            )
        );

        return static::findOne($params);
    }
}
