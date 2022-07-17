<?php
defined('BASEPATH') or exit('No direct script access allowed');

//import library dari Format dan RestController
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class Dosen extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dosen_model');
        $this->methods['dosen_get']['limit'] = 10;
    }
    function dosen_get()
    {

        $data = $this->Dosen_model->get_dosen($this->get('id_dosen'));
        if (empty($data)) {
            return $this->response(
                array(
                    'data' => null,
                    'status' => 'Data Not Found',
                    'response_code' => RestController::HTTP_NOT_FOUND
                ),
                RestController::HTTP_NOT_FOUND
            );
        }
        return $this->response(
            array(
                'data' => $data,
                'status' => 'success',
                'response_code' => RestController::HTTP_OK
            ),
            RestController::HTTP_OK
        );
    }

    function dosen_post()
    {
        $data = array(
            'id_dosen' => $this->post('id_dosen'),
            'nama' => $this->post('nama'),
            'tgl_lahir' => $this->post('tgl_lahir'),
			'alamat' => $this->post('alamat'),
			'jk' => $this->post('jenis_kelamin'),
        );
        $duplikasi = $this->Mahasiswa_model->get_mahasiswa_data($data['npm']);
        if (
			array_search("", $data)
        ) {
            return $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Yang Dikirim Tidak Boleh Ada Yang Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        } elseif ($duplikasi) {
            return $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_NOT_ACCEPTABLE,
                    'message' => 'Data Duplikasi Terjadi',
                ],
                RestController::HTTP_NOT_ACCEPTABLE
            );
        } elseif ($this->Dosen_model->insert_dosen($data) > 0) {
            return $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Berhasil Ditambahkan',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            return $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Menambahkan Data',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    function dosen_delete()
    {
        $id_dosen = $this->delete('id_dosen');
        //Jika field npm tidak diisi
        if ($id_dosen == NULL) {
            return $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'NPM Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        } elseif ($this->Dosen_model->update_dosen($id_dosen) > 0) {
            return $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_OK,
                    'message' => 'Data Dosen Dengan ID ' . $id_dosen . ' Berhasil Dihapus',
                ],
                RestController::HTTP_OK
            );
        } else {
            return $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Mahasiswa Dengan NPM ' . $id_dosen . ' Tidak Ditemukan',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    function dosen_put()
    {
		$id_dosen = $this->post('id_dosen');
		$data = array(
			'nama' => $this->post('nama'),
			'tgl_lahir' => $this->post('tgl_lahir'),
			'alamat' => $this->post('alamat'),
			'jk' => $this->post('jenis_kelamin'),
		);
        if ($id_dosen == NULL) {
            return $this->response(
                [
                    'status' => $id_dosen,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'ID Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        } elseif ($this->Mahasiswa_model->updateMahasiswa($data, $id_dosen) > 0) {
            return $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Dosen Dengan ID ' . $id_dosen . ' Berhasil Diubah',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            return $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Mengubah Data',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }
}
