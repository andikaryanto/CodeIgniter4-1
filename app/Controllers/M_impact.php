<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_impacts;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\Session;
use AndikAryanto11\Datatables;

class M_impact extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        $res = $this->hasPermission('m_impact', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $this->loadView('m_impact/index', lang('Form.impact'));
    }

    public function add()
    {
        $res = $this->hasPermission('m_impact', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $impacts = new M_impacts();
        $data = setPageData_paging($impacts);
        $this->loadView('m_impact/add', lang('Form.impact'), $data);
        
    }

    public function addsave()
    {

        $res = $this->hasPermission('m_impact', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $impacts = new M_impacts();
        $impacts->parseFromRequest();

        try {
            $impacts->validate();

            $impacts->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect('mimpact/add')->go();
        } catch (EloquentException $e) {

            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("mimpact/add")->with($impacts)->go();
        }
        
    }

    public function edit($id)
    {
        $res = $this->hasPermission('m_impact', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $impacts = M_impacts::find($id);

        $data['model'] = $impacts;
        $this->loadView('m_impact/edit', lang('Form.impact'), $data);
        
    }

    public function editsave()
    {
        $res = $this->hasPermission('m_impact', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $id = $this->request->getPost('Id');

        $impacts = M_impacts::find($id);
        $oldmodel = clone $impacts;

        $impacts->parseFromRequest();

        try {
            $impacts->validate($oldmodel);

            $impacts->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect('mimpact')->go();
        } catch (EloquentException $e) {

            Session::setFlash('edit_warning_msg', array(0 => $e->message));
            return Redirect::redirect("mimpactedit/edit/{$id}")->with($impacts)->go();
        }
        
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        $res = $this->hasPermission('m_impact', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {
            $model = M_impacts::find($id);

            $result = $model->delete();
            if (!is_bool($result)) {
                $deletemsg = getDeleteErrorMessage();
                echo json_encode(deleteStatus($deletemsg, FALSE));
            } else {
                if ($result) {
                    $deletemsg = getDeleteMessage();
                    echo json_encode(deleteStatus($deletemsg));
                }
            }
        } 
    }

    public function getAllData()
    {

        if ($this->hasPermission('m_impact', 'Read')) {

            $datatableparams = [
                'join' => [
                    'm_impactcategories' => [
                        [
                            'key' => 'm_impacts.M_Impactcategory_Id = m_impactcategories.Id',
                            'type' => 'left'
                        ]
                    ]
                ]
            ];

            $datatable = new Datatables($datatableparams);
            $datatable->eloquent('App\\Eloquents\\M_impacts');
            $datatable
                ->addDtRowClass("rowdetail")
                ->addColumn(
                    'Id',
                    null,
                    function ($row) {
                        return $row->Id;
                    },
                    false,
                    false
                )->addColumn(
                    'm_impacts.Name',
                    null,
                    function ($row) {
                        return
                            formLink($row->Name, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('mimpact/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'm_impactcategories.Name',
                    null,
                    
                )->addColumn(
                    'm_impacts.UoM',
                    null,
                )->addColumn(
                    'm_impacts.Description',
                    null,
                )->addColumn(
                    'm_impacts.Created',
                    null,
                    null,
                    false
                )->addColumn(
                    'Action',
                    null,
                    function ($row) {
                        return
                            formLink("<i class='fa fa-trash'></i>", array(
                                "href" => "#",
                                "class" => "btn-just-icon link-action delete",
                                "rel" => "tooltip",
                                "title" => lang('Form.delete')
                            ));
                    },
                    false,
                    false
                );

            echo json_encode($datatable->populate());
        }
    }
    public function getDataModal()
    {
        $datatableparams = [
            'join' => [
                'm_impactcategories' => [
                    [
                        'key' => 'm_impacts.M_Impactcategory_Id = m_impactcategories.Id',
                        'type' => 'left'
                    ]
                ]
            ]
        ];
        $datatable = new Datatables($datatableparams);
        $datatable->eloquent('App\\Eloquents\\M_impacts');
        $datatable
            ->addDtRowClass("rowdetail")
            ->addColumn(
                'm_impacts.Id',
                null,
                function ($row) {
                    return $row->Id;
                },
                false,
                false
            )->addColumn(
                'm_impacts.Name',
                null,
                null,
            )
            ->addColumn(
                'm_impactcategories.Name',
                'M_Impactcategory_Id',
                null,
                null,
            );

        echo json_encode($datatable->populate());
    }
}
