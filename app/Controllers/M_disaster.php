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
        if ($this->hasPermission('m_disaster', 'Read')) {

            $this->loadView('m_disaster/index', lang('Form.disaster'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_disaster', 'Write')) {
            $disasters = new M_disasters();
            $data = setPageData_paging($disasters);
            $this->loadView('m_disaster/add', lang('Form.disaster'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_disaster', 'Write')) {

            $disasters = new M_disasters();
            $disasters->parseFromRequest();
            try {
                $disasters->validate();
                $file = $this->request->getFileMultiple('photo');
                $photo = new File("assets/upload/disaster/icon", ["jpg", "jpeg", "png"]);
                $result = $photo->upload($file);
                if ($result) {
                    $disasters->Icon = $photo->getFileUrl();
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
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_disaster', 'Write')) {

            $disasters = M_disasters::find($id);
            $data['model'] = $disasters;
            $this->loadView('m_disaster/edit', lang('Form.disaster'), $data);
        } else {

            return Redirect::redirect("Forbidden");
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_disaster', 'Write')) {

            $id = $this->request->getPost('Id');

            $disasters = M_disasters::find($id);
            $oldmodel = clone $disasters;

            $disasters->parseFromRequest();

            try {
                $disasters->validate($oldmodel);
                $file = $this->request->getFileMultiple('photo');
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
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_disaster', 'Delete')) {

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
        } else {
            echo json_encode(deleteStatus("", FALSE, TRUE));
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
