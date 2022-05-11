<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PostTypeModel;


class PostType extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        $model = new PostTypeModel();
        $data['post_type'] = $model->orderBy('id', 'ASC')->findAll();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $model = new PostTypeModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $model = new PostTypeModel();
        $json = $this->request->getJSON();
        if ($json) {
            $data = [
                'jenis' => $json->jenis,
                'type' => $json->type
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'jenis' => $input['jenis'],
                'type' => $input['type']
            ];
        }
        $model->save($data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'data berhasil ditambahkan'
            ]
        ];
        return $this->respond($response);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {


        $model = new PostTypeModel();
        $json = $this->request->getJSON();
        if ($json) {
            $data = [
                'jenis' => $json->jenis,
                'type' => $json->type
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'jenis' => $input['jenis'],
                'type' => $input['type']
            ];
        }
        $model->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'data berhasil diubah'
            ]
        ];
        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new PostTypeModel();
        $data = $model->find($id);
        if ($data) {
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data Deleted'
                ]
            ];

            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }
}
