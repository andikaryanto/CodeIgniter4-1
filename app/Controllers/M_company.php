<?php

namespace App\Controllers;

use AndikAryanto11\Datatables;
use App\Classes\Exception\EloquentException;
use App\Controllers\Base_Controller;
use App\Eloquents\M_companies;
use App\Libraries\Redirect;
use App\Libraries\Session;
use App\Libraries\File;

class M_company extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        $res = $this->hasPermission('m_company', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $this->loadView('m_company/index', lang('Form.company'));
        
    }

    public function add()
    {
        $res = $this->hasPermission('m_company', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $companies = M_companies::findOne();
        if ($companies == null)
            $companies = new M_companies();
        $data = setPageData_paging($companies);
        // echo json_encode($data);
        $this->loadView('m_company/add', lang('Form.company'), $data);
        
    }

    public function addsave()
    {
        $res = $this->hasPermission('m_company', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $companies = new M_companies();
        $companies->parseFromRequest();
        try {
            // echo json_encode($companies);
            $companies->validate();
            $companies->save();
            Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
            return Redirect::redirect('mcompany')->go();
        } catch (EloquentException $e) {
            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            // echo json_encode($e);
            return Redirect::redirect("mcompany")->go();
        }
    
    }

    public function edit($id)
    {
        $res = $this->hasPermission('m_company', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $companies = M_companies::find($id);
        $data['model'] = $companies;
        $this->loadView('m_company/edit', lang('Form.company'), $data);
       
    }

    public function editsave()
    {
        $res = $this->hasPermission('m_company', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }
        $id = $this->request->getPost('Id');

        $companies = M_companies::find($id);
        $oldmodel = clone $companies;

        $companies->parseFromRequest();

        try {
            $companies->validate($oldmodel);
            $file = $this->request->getFileMultiple('photo');
            $photo = new File("assets/upload/company/icon", ["jpg", "jpeg", "png"]);
            $result = $photo->upload($file);
            if ($result) {
                if ($companies->Icon)
                    unlink(FCPATH  . $oldmodel->Icon);

                $companies->Icon = $photo->getFileUrl();
                $companies->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mcompany')->go();
            } else {
                throw new EloquentException($photo->getErrorMessage(), $companies);
            }
        } catch (EloquentException $e) {
            Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("mcompany/edit/{$id}")->with($companies)->go();
        }
    
    }


    public function delete()
    {
        $id = $this->request->getPost("id");
        $res = $this->hasPermission('m_company', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {

            $model = M_companies::find($id);

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

        if ($this->hasPermission('m_company', 'Read')) {

            $datatable = new Datatables('M_companies');
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
                        return
                            formLink($row->Name, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('mcompany/edit/' . $row->Id),
                                "class" => "text-muted"
                            ));
                    }
                )->addColumn(
                    'Description',
                    null,
                    function ($row) {
                        return $row->Description;
                    }
                )->addColumn(
                    'Created',
                    null,
                    function ($row) {
                        return $row->Created;
                    },
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

        $datatable = new Datatables('M_companies');
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
