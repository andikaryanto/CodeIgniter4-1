<?php

namespace App\Controllers;

use App\Classes\Exception\EloquentException;
use App\Eloquents\M_pocketbooks;
use App\Eloquents\M_accessroles;
use App\Controllers\Base_Controller;
use App\Libraries\Redirect;
use App\Libraries\ResponseCode;
use App\Libraries\Session;
use App\Libraries\File;
use AndikAryanto11\Datatables;

class M_pocketbook extends Base_Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if ($this->hasPermission('m_pocketbook', 'Read')) {

            $this->loadView('m_pocketbook/index', lang('Form.pocketbook'));
        }
    }

    public function add()
    {
        if ($this->hasPermission('m_pocketbook', 'Write')) {
            $pocketbooks = new M_pocketbooks();
            $data = setPageData_paging($pocketbooks);
            $this->loadView('m_pocketbook/add', lang('Form.pocketbook'), $data);
        }
    }

    public function addsave()
    {

        if ($this->hasPermission('m_pocketbook', 'Write')) {

            $pocketbooks = new M_pocketbooks();
            $pocketbooks->parseFromRequest();
            try {
                $pocketbooks->validate();
                $file = $this->request->getFiles('photo');
                $photo = new File("assets/upload/pocketbook", ["pdf"]);
                $result = $photo->upload($file);
                if ($result) {
                    $pocketbooks->FileUrl = $photo->getFileUrl();
                    $pocketbooks->save();
                    Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                    return Redirect::redirect('mpocketbook/add')->go();
                } else {

                    throw new EloquentException($photo->getErrorMessage(), $pocketbooks, ResponseCode::INVALID_DATA);
                }
            } catch (EloquentException $e) {
                Session::setFlash('add_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("mpocketbook/add")->with($e->data)->go();
            }
        }
    }

    public function edit($id)
    {
        if ($this->hasPermission('m_pocketbook', 'Write')) {

            $pocketbooks = M_pocketbooks::find($id);
            $data['model'] = $pocketbooks;
            $this->loadView('m_pocketbook/edit', lang('Form.pocketbook'), $data);
        } else {

            return Redirect::redirect("Forbidden");
        }
    }

    public function editsave()
    {

        if ($this->hasPermission('m_pocketbook', 'Write')) {

            $id = $this->request->getPost('Id');

            $pocketbooks = M_pocketbooks::find($id);
            $oldmodel = clone $pocketbooks;

            $pocketbooks->parseFromRequest();

            try {
                $pocketbooks->validate($oldmodel);
                $file = $this->request->getFiles('photo');
                $photo = new File("assets/upload/pocketbook", ["jpg", "jpeg", "png"]);
                $result = $photo->upload($file);
                if ($result) {
                    if ($pocketbooks->FileUrl)
                        unlink(FCPATH  . $oldmodel->FileUrl);

                    $pocketbooks->FileUrl = $photo->getFileUrl();
                    $pocketbooks->save();
                    Session::setFlash('success_msg', array(0 => lang('Form.datasaved')));
                    return Redirect::redirect('mpocketbook')->go();
                } else {
                    throw new EloquentException($photo->getErrorMessage(), $pocketbooks);
                }
            } catch (EloquentException $e) {
                Session::setFlash('edit_warning_msg', array(0 => $e->messages));
                return Redirect::redirect("mpocketbook/edit/{$id}")->with($pocketbooks)->go();
            }
        }
    }


    public function delete()
    {

        $id = $this->request->getPost("id");
        if ($this->hasPermission('m_pocketbook', 'Delete')) {

            $model = M_pocketbooks::find($id);

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

        if ($this->hasPermission('m_pocketbook', 'Read')) {

            $datatable = new Datatables();
            $datatable->eloquent('App\\Eloquents\\M_pocketbooks');
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
                    'Title',
                    null,
                    function ($row) {
                        return
                            formLink($row->Title, array(
                                "id" => $row->Id . "~a",
                                "href" => baseUrl('mpocketbook/edit/' . $row->Id),
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
        $datatable->eloquent('App\\Eloquents\\M_pocketbooks');
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
                'Title',
                null,
                function ($row) {
                    return $row->Title;
                }
            );

        echo json_encode($datatable->populate());
    }
}
