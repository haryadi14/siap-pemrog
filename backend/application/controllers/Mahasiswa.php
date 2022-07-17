<?php
defined('BASEPATH') or exit('No direct script access allowed');

//import library dari Format dan RestController
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class Mahasiswa extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model');
        $this->methods['mhs_get']['limit'] = 10;
    }
    function mhs_get()
    {
        $data = $this->Mahasiswa_model->get_mahasiswa_data($this->get('npm'));
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

    function mhs_post()
    {
        $data = array(
            'npm' => $this->post('npm'),
            'nama' => $this->post('nama'),
            'jenis_kelamin' => $this->post('jenis_kelamin'),
            'alamat' => $this->post('alamat'),
            'agama' => $this->post('agama'),
            'no_hp' => $this->post('no_hp'),
            'email' => $this->post('email')
        );
        $duplikasi = $this->Mahasiswa_model->get_mahasiswa_data($data['npm']);
        if (
            $data['npm'] == NULL || $data['nama'] == NULL || $data['jenis_kelamin']
            == NULL || $data['alamat'] == NULL || $data['agama'] == NULL || $data['no_hp'] ==
            NULL || $data['email'] == NULL
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
        } elseif ($this->Mahasiswa_model->insertMahasiswa($data) > 0) {
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

    function mhs_delete()
    {
        $npm = $this->delete('npm');
        //Jika field npm tidak diisi
        if ($npm == NULL) {
            return $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'NPM Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Kondisi ketika OK
        } elseif ($this->Mahasiswa_model->deleteMahasiswa($npm) > 0) {
            return $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_OK,
                    'message' => 'Data Mahasiswa Dengan NPM ' . $npm . ' Berhasil Dihapus',
                ],
                RestController::HTTP_OK
            );
            //Kondisi gagal
        } else {
            return $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Mahasiswa Dengan NPM ' . $npm . ' Tidak Ditemukan',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    function mhs_put()
    {
        $npm = $this->put('npm');
        $data = array(
            'nama' => $this->put('nama'),
            'jenis_kelamin' => $this->put('jenis_kelamin'),
            'alamat' => $this->put('alamat'),
            'agama' => $this->put('agama'),
            'no_hp' => $this->put('no_hp'),
            'email' => $this->put('email')
        );
        //Jika field npm tidak diisi
        if ($npm == NULL) {
            return $this->response(
                [
                    'status' => $npm,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'NPM Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Jika data berhasil berubah
        } elseif ($this->Mahasiswa_model->updateMahasiswa($data, $npm) > 0) {
            return $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Mahasiswa Dengan NPM ' . $npm . ' Berhasil Diubah',
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
