<?php

namespace App\Controllers;

use AndikAryanto11\Datatables;
use App\Classes\Exception\EloquentException;
use App\Controllers\Base_Controller;
use App\Eloquents\M_communities;
use App\Libraries\Redirect;
use App\Libraries\Session;

class M_community extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_community', 'Read')) {

            $this->loadView('m_community/index', lang('Form.community'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_community', 'Write')) {
            $communities = new M_communities();
            $communities->EndService = get_formated_date(null, "d-m-Y");
            $communities->FoundOn = get_formated_date(null, "d-m-Y");
            $data = setPageData_paging($communities);
            $this->loadView('m_community/add', lang('Form.community'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_community', 'Write')) {

            $communities = new M_communities();
            $communities->parseFromRequest();
            try {

                $communities->validate();

                $communities->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mcommunity/add')->go();
            } catch (EloquentException $e) {
                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect('mcommunity/add')->with($communities)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_community', 'Write')) {

            $communities = M_communities::find($id);
            $communities->EndService = get_formated_date($communities->EndService, "d-m-Y");
            $communities->FoundOn = get_formated_date($communities->FoundOn, "d-m-Y");
            $data['model'] = $communities;
            $this->loadView('m_community/edit', lang('Form.community'), $data);
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_community', 'Write')) {

            $id = $this->request->getPost('Id');
            $communities = M_communities::find($id);
            $oldmodel = clone $communities;

            $communities->parseFromRequest();

            try {

                $communities->validate($oldmodel);

                $communities->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mcommunity')->go();
            } catch (EloquentException $e) {
                Session::setFlash('edit_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("mcommunity/edit/{$id}")->with($communities)->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_community', 'Delete')) {

            $model = M_communities::find($id);

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

        if ($this->hasPermission('m_community', 'Read')) {
            $params = [
                'join' => [
                    'm_subvillages' => [
                        [
                            'key' => 'm_communities.M_Subvillage_Id = m_subvillages.Id',
                            'type' => 'left',
                        ]
                    ]
                ]
            ];
            $datatable = new Datatables($params);

            $datatable->eloquent('App\\Eloquents\\M_communities');
            $datatable
                ->addDtRowClass("rowdetail")
                ->addColumn(
                    'm_communities.Id',
                    null,
                    function ($row) {
                        return $row->Id;
                    },
                    false,
                    false
                )->addColumn(
                    'm_communities.Name',
                    null,
                    function ($row) {
                        return
                            formLink($row->Name, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('mcommunity/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'm_subvillages.Name',
                    'M_Subvillages_Id',
                   
                )->addColumn(
                    'm_communities.Address',
                    null,
                    function ($row) {
                        return $row->Address;
                    }
                )->addColumn(
                    'm_communities.ServicePeriod',
                    null,
                    function ($row) {
                        return $row->ServicePeriod;
                    }
                )->addColumn(
                    'm_communities.EndService',
                    null,
                    function ($row) {
                        return get_formated_date($row->EndService, "d-M-Y");
                    }
                )->addColumn(
                    'm_communities.Phone',
                    null,
                    function ($row) {
                        return $row->Phone;
                    }
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

        $datatable = new Datatables();
        $datatable->eloquent('App\\Eloquents\\M_communities');
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
                'Name',
                null,
                function ($row) {
                    return $row->Name;
                }
            );

        echo json_encode($datatable->populate());
    }
}
