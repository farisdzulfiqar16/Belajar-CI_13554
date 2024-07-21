<?php

namespace App\Controllers;

use App\Database\Migrations\TransactionDetail;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

use App\Models\UserModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;


class ApiController extends ResourceController
{

    protected $apiKey = 'ef635XbLi09420MgcvNp00';
    protected $transaction;
    protected $user;

    public function __construct()
    {
        $this->transaction = new \App\Models\TransactionModel();
        $this->user = new \App\Models\UserModel();
    }

    public function monthly()
    {
        $data = [
            'query' => [],
            'results' => [],
            'status' => ["code" => 401, "description" => "Unauthorized"]
        ];

        $headers = $this->request->getHeaders();
        $postData = $this->request->getPost();

        $data['query'] = $postData;

        // Convert headers to array
        $headersArray = [];
        foreach ($headers as $key => $header) {
            $headersArray[$key] = $header->getValue();
        }

        if (isset($headersArray["Key"]) && $headersArray["Key"] == $this->apiKey) {
            $tahun = $postData['tahun'] ?? null;
            $bulan = $postData['bulan'] ?? null;
            $type = $postData['type'] ?? null;

            if ($tahun && $type) {
                if ($type == 'transaction') {
                    $dateCondition = $bulan ? $tahun . '-' . $bulan . '%' : $tahun . '%';
                    $result = $this->transaction->select('COUNT(*) as jml')->like('created_at', $dateCondition, 'after')->first();
                } elseif ($type == 'earning') {
                    $dateCondition = $bulan ? $tahun . '-' . $bulan . '%' : $tahun . '%';
                    $result = $this->transaction->select('SUM(total_harga) as jml')->like('created_at', $dateCondition, 'after')->first();
                } elseif ($type == 'user') {
                    $dateCondition = $bulan ? $tahun . '-' . $bulan . '%' : $tahun . '%';
                    $result = $this->user->select('COUNT(*) as jml')->like('created_at', $dateCondition, 'after')->first();
                }

                $data['results'] = $result;
                $data['status'] = ["code" => 200, "description" => "OK"];
            }
        }

        return $this->respond($data);
    }

    public function yearly()
    {
        $data = [
            'query' => [],
            'results' => [],
            'status' => ["code" => 401, "description" => "Unauthorized"]
        ];

        $headers = $this->request->getHeaders();
        $postData = $this->request->getPost();

        $data['query'] = $postData;

        // Convert headers to array
        $headersArray = [];
        foreach ($headers as $key => $header) {
            $headersArray[$key] = $header->getValue();
        }

        if (isset($headersArray["Key"]) && $headersArray["Key"] == $this->apiKey) {
            $tahun = $postData['tahun'] ?? null;
            $type = $postData['type'] ?? null;

            if ($tahun && $type) {
                if ($type == 'transaction') {
                    $result = $this->transaction->select('COUNT(*) as jml')->like('created_at', $tahun . '%', 'after')->first();
                } elseif ($type == 'earning') {
                    $result = $this->transaction->select('SUM(total_harga) as jml')->like('created_at', $tahun . '%', 'after')->first();
                } elseif ($type == 'user') {
                    $result = $this->user->select('COUNT(*) as jml')->like('created_at', $tahun . '%', 'after')->first();
                }

                $data['results'] = $result;
                $data['status'] = ["code" => 200, "description" => "OK"];
            }
        }

        return $this->respond($data);
    }




    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
