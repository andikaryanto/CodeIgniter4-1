<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Controllers\Base_Controller;
use App\Eloquents\M_disasters;
use App\Libraries\Redirect;
use App\Libraries\ResponseCode;
use App\Libraries\Session;
use App\Libraries\File;
use AndikAryanto11\Datatables;

class M_disaster extends Base_Controller
{

    public function __construct()
    {
        // 
    }

    public function index()
    {
        $res = $this->hasPermission('m_disaster', 'Read');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $this->loadView('m_disaster/index', lang('Form.disaster'));
        
    }

    public function add()
    {
        $res = $this->hasPermission('m_disaster', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $disasters = new M_disasters();
        $data = setPageData_paging($disasters);
        $this->loadView('m_disaster/add', lang('Form.disaster'), $data);
        
    }

    public function addsave()
    {

        $res = $this->hasPermission('m_disaster', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $disasters = new M_disasters();
        $disasters->parseFromRequest();
        try {
            $file = $this->request->getFile('photo');
            $photo = new File("assets/upload/disaster/icon", ["jpg", "jpeg", "png"]);
            $result = $photo->upload($file);
            if ($result) {
                $disasters->Icon = $photo->getFileUrl();
                $disasters->validate();
                $disasters->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mdisaster/add')->go();
            } else {

                throw new EloquentException($photo->getErrorMessage(), $disasters, ResponseCode::INVALID_DATA);
            }
        } catch (EloquentException $e) {
            Session::setFlash('add_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("mdisaster/add")->with($e->getEntity())->go();
        }
    
    }

    public function edit($id)
    {
        $res = $this->hasPermission('m_disaster', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $disasters = M_disasters::find($id);
        $data['model'] = $disasters;
        $this->loadView('m_disaster/edit', lang('Form.disaster'), $data);
        
    }

    public function editsave()
    {

        $res = $this->hasPermission('m_disaster', 'Write');
        if($res instanceof \CodeIgniter\HTTP\RedirectResponse){
            return $res;
        }

        $id = $this->request->getPost('Id');

        $disasters = M_disasters::find($id);
        $oldmodel = clone $disasters;

        $disasters->parseFromRequest();

        try {
            $disasters->validate($oldmodel);
            $file = $this->request->getFile('photo');
            $photo = new File("assets/upload/disaster/icon", ["jpg", "jpeg", "png"]);
            $result = $photo->upload($file);
            if ($result) {
                if ($disasters->Icon)
                    unlink(FCPATH  . $oldmodel->Icon);

                $disasters->Icon = $photo->getFileUrl();
                $disasters->save();
                Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                return Redirect::redirect('mdisaster')->go();
            } else {
                throw new EloquentException($photo->getErrorMessage(), $disasters);
            }
        } catch (EloquentException $e) {
            Session::setFlash('edit_warning_msg', array(0 => $e->getMessages()));
            return Redirect::redirect("mdisaster/edit/{$id}")->with($disasters)->go();
        }
    
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        $res = $this->hasPermission('m_disaster', 'Delete');

        if(!$res){
            echo json_encode(deleteStatus(lang("Info.no_access_delete"), FALSE, TRUE));
        } else {

            $model = M_disasters::find($id);

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

        if ($this->hasPermission('m_disaster', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_disasters');
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
                                "href" => baseUrl('mdisaster/edit/' . $row->Id),
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

        $datatable = new Datatables();
        $datatable->eloquent('App\\Eloquents\\M_disasters');
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
