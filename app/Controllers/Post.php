<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PostTypeModel;
use App\Models\PostModel;

class Post extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        $this->db = db_connect();
        // $model = new PostModel();
        $builder = $this->db->table("post");
        $builder->select('*');
        $builder->join('post_type', 'post.post_type = post_type.id');
        $data = $builder->get()->getResult();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        // $model = new PostModel();
        $this->db = db_connect();
        // $model = new PostModel();
        $builder = $this->db->table("post");
        $builder->select('*');
        $builder->join('post_type', 'post.post_type = post_type.id');
        $builder->where('post.id', $id);
        $data = $builder->get()->getResult();
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
        $model = new PostModel();
        $json = $this->request->getJSON();
        if ($json) {
            $data = [
                'title' => $json->title,
                'description' => $json->description,
                'post_type' => $json->post_type,
                'user' => $json->user,
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'title' => $input['title'],
                'description' => $input['description'],
                'post_type' => $input['post_type'],
                'user' => $input['user'],
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
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $model = new PostModel();
        $json = $this->request->getJSON();
        if ($json) {
            $data = [
                'title' => $json->title,
                'description' => $json->description,
                'post_type' => $json->post_type,
                'user' => $json->user,
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'title' => $input['title'],
                'description' => $input['description'],
                'post_type' => $input['post_type'],
                'user' => $input['user'],
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
        $model = new PostModel();
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
