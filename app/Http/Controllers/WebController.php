<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class WebController extends Controller
{
    function random($type, $length)
    {
        $result = "";
        if ($type == 'char') {
            $char = 'ABCDEFGHJKLMNPRTUVWXYZ';
            $max        = strlen($char) - 1;
            for ($i = 0; $i < $length; $i++) {
                $rand = mt_rand(0, $max);
                $result .= $char[$rand];
            }
            return $result;
        } elseif ($type == 'num') {
            $char = '123456789';
            $max        = strlen($char) - 1;
            for ($i = 0; $i < $length; $i++) {
                $rand = mt_rand(0, $max);
                $result .= $char[$rand];
            }
            return $result;
        } elseif ($type == 'mix') {
            $char = 'ABCDEFGHJKLMNPRTUVWXYZ123456789';
            $max = strlen($char) - 1;
            for ($i = 0; $i < $length; $i++) {
                $rand = mt_rand(0, $max);
                $result .= $char[$rand];
            }
            return $result;
        }
    }

    public function login_attempt(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect('/dashboard');
        } else {
            Session::flash('failed');
            return redirect()->back()->withInput($request->all());
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function change_password(Request $request)
    {
        $cekPass = Hash::check($request->oldPass, Auth::user()->password);

        if ($cekPass === true) {
            User::where('id', Auth::user()->id)->update([
                "password" => bcrypt($request->newPass)
            ]);
            return response()->json([
                "response" => "success",
                "message" => "Password anda berhasil dirubah"
            ]);
        } else {
            return response()->json([
                "response" => "failed",
                "message" => "Password lama anda salah !"
            ]);
        }
    }

    public function check_role()
    {
        if (Auth::user()->role == "admin") {
            return redirect('/dashboard');
        } elseif (Auth::user()->role == "karyawan") {
            return redirect('/karyawan/dashboard');
        }
    }

    public function dashboard()
    {
        $karyawan = Karyawan::all();
        $karyawan = count($karyawan);

        $kriteria = Kriteria::all();
        $kriteria = count($kriteria);

        return view('dashboard', compact('karyawan', 'kriteria'));
    }

    public function get_data_karyawan()
    {
        $karyawan = Karyawan::all();
        $data = [];

        foreach ($karyawan as $k) {
            $data[] = [
                "id" => $k->id,
                "nama" => $k->nama,
                "username" => $k->user->username,
                "jenis_kelamin" => $k->jenis_kelamin,
                "tgl_lahir" => date('d F Y', strtotime($k->tgl_lahir)),
                "alamat" => $k->alamat
            ];
        }

        $response = [
            "data" => $data,
            "response" => "success",
        ];
        return response()->json($response);
    }

    public function input_data_karyawan(Request $request)
    {
        $cek = User::where('username', $request->username)->first();
        if ($cek) {
            $response = [
                "response" => "failed",
                "message" => "Akses Username sudah digunakan !"
            ];
            return response()->json($response);
        } else {
            $idKaryawan = 'K' . $this->random('num', 4);
            while (true) {
                $cek = Karyawan::where('id', $idKaryawan)->first();
                if ($cek) {
                    $idKaryawan = 'K' . $this->random('num', 4);
                } else {
                    break;
                }
            }

            Karyawan::create([
                'id' => $idKaryawan,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tgl_lahir' => $request->tgl_lahir,
                'alamat' => $request->alamat
            ]);

            User::create([
                'id_karyawan' => $idKaryawan,
                'name' => $request->nama,
                'username' => $request->username,
                'password' => bcrypt('12345'),
                'role' => 'karyawan'
            ]);

            $penilaian = Penilaian::all();
            $kriteria = Kriteria::all();

            $periodePenilaian = [];
            foreach ($penilaian as $p) {
                $cek = array_search($p->periode, $periodePenilaian);
                if ($cek === false) {
                    $periodePenilaian[] = $p->periode;
                }
            }

            foreach ($periodePenilaian as $periode) {
                foreach ($kriteria as $k) {
                    Penilaian::create([
                        'periode' => $periode,
                        'id_karyawan' => $idKaryawan,
                        'id_kriteria' => $k->id,
                        'nilai' => 0
                    ]);
                }
            }

            $response = [
                "response" => "success",
                "message" => "Data karyawan berhasil ditambahkan"
            ];
            return response()->json($response);
        }
    }

    public function update_data_karyawan(Request $request)
    {
        Karyawan::where('id', $request->id)->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat
        ]);

        $response = [
            "response" => "success",
            "message" => $request->nama . " berhasil di update"
        ];

        return response()->json($response);
    }

    public function delete_data_karyawan(Request $request)
    {
        Karyawan::where('id', $request->id)->delete();
        Penilaian::where('id_karyawan', $request->id)->delete();
        User::where('id_karyawan', $request->id)->delete();

        $response = [
            "response" => "success",
            "message" => "Berhasil menghapus data karyawan"
        ];
        return response()->json($response);
    }

    public function get_kriteria()
    {
        $kriteria = Kriteria::all();
        $response = [
            "data" => $kriteria,
            "response" => "success"
        ];

        return response()->json($response);
    }

    public function add_kriteria(Request $request)
    {
        $idKriteriaMax = Kriteria::all();
        $idKriteriaMax = count($idKriteriaMax) + 1;
        $idKriteria = $idKriteriaMax . $this->random('mix', 4);
        while (true) {
            $cek = Kriteria::where('id', $idKriteria)->first();
            if ($cek) {
                $idKriteriaMax = Kriteria::all();
                $idKriteriaMax = count($idKriteriaMax) + 1;
                $idKriteria = $idKriteriaMax . $this->random('mix', 4);
            } else {
                break;
            }
        }

        Kriteria::create([
            'id' => $idKriteria,
            'nama' => $request->nama,
            'bobot' => $request->bobot
        ]);

        $penilaian = Penilaian::all();
        $karyawan = Karyawan::all();

        $periodePenilaian = [];
        foreach ($penilaian as $p) {
            $cek = array_search($p->periode, $periodePenilaian);
            if ($cek === false) {
                $periodePenilaian[] = $p->periode;
            }
        }

        foreach ($periodePenilaian as $periode) {
            foreach ($karyawan as $k) {
                Penilaian::create([
                    'periode' => $periode,
                    'id_karyawan' => $k->id,
                    'id_kriteria' => $idKriteria,
                    'nilai' => 0
                ]);
            }
        }

        return response()->json(["response" => "success"]);
    }

    public function update_kriteria(Request $request)
    {
        Kriteria::where('id', $request->id)->update([
            "nama" => $request->nama,
            "bobot" => $request->bobot
        ]);

        return response()->json(["response" => "success"]);
    }

    public function delete_kriteria(Request $request)
    {
        Kriteria::where('id', $request->id)->delete();
        Penilaian::where('id_kriteria', $request->id)->delete();

        return response()->json(["response" => "success"]);
    }

    public function get_kriteria_normalisasi()
    {
        $maxBobot = Kriteria::sum('bobot');
        $kriteria = Kriteria::all();
        foreach ($kriteria as $normalisasi) {
            $normalisasi["bobot"] = $normalisasi->bobot / $maxBobot;
            $normalisasi["bobot"] = number_format((float)$normalisasi["bobot"], 2, '.', '');
        }
        return response()->json($kriteria);
    }

    public function get_penilaian_karyawan(Request $request)
    {
        $penilaian = Penilaian::where('periode', $request->periode)->get();
        if (count($penilaian) == 0) {
            return response()->json(["response" => false, "periode" => $request->periode]);
        } else {
            $karyawan = Karyawan::all();
            $kriteria = Kriteria::all();
            $data = [];

            foreach ($karyawan as $karyawanKey => $karyawanVal) {
                $data[$karyawanKey]["id_karyawan"] = $karyawanVal->id;
                $data[$karyawanKey]["nama"] = $karyawanVal->nama;

                foreach ($kriteria as $kriteriaKey => $kriteriaVal) {
                    foreach ($penilaian as $pKey => $pVal) {
                        if ($penilaian[$pKey]["id_karyawan"] == $karyawanVal->id && $penilaian[$pKey]["id_kriteria"] == $kriteriaVal->id) {
                            $data[$karyawanKey]["nilai"][] = [
                                "kriteria" => $penilaian[$pKey]["id_kriteria"],
                                "nilai" => $penilaian[$pKey]["nilai"]
                            ];
                        }
                    }
                }
            }

            $response = [
                "response" => true,
                "periode" => $request->periode,
                "data" => $data
            ];
            return response()->json($response);
        }
    }

    public function create_penilaian_karyawan(Request $request)
    {
        $kriteria = Kriteria::all();
        $karyawan = Karyawan::all();

        foreach ($kriteria as $kriteriaVal) {
            foreach ($karyawan as $karyawanVal) {
                Penilaian::create([
                    'periode' => $request->periode,
                    'id_karyawan' => $karyawanVal->id,
                    'id_kriteria' => $kriteriaVal->id,
                    'nilai' => 0
                ]);
            }
        }

        return response()->json(["response" => "success"]);
    }

    public function update_get_penilaian_karyawan(Request $request)
    {
        $penilaian = Penilaian::where('periode', $request->periode)->where('id_karyawan', $request->id_karyawan)->get();
        $data = [];
        foreach ($penilaian as $p) {
            $data[] = [
                "id_kriteria" => $p->kriteria->id,
                "kriteria" => $p->kriteria->nama,
                "nilai" => $p->nilai
            ];
        }

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function update_penilaian_karyawan(Request $request)
    {
        foreach ($request->kriteria as $key => $value) {
            Penilaian::where('periode', $request->periode)->where('id_karyawan', $request->id_karyawan)->where('id_kriteria', $value["id_kriteria"])->update([
                "nilai" => $value["nilai"]
            ]);
        }

        return response()->json(["response" => "success"]);
    }

    public function get_normalisasi_penilaian_karyawan(Request $request)
    {
        $penilaian = Penilaian::where('periode', $request->periode)->get();
        if (count($penilaian) == 0) {
            return response()->json(["response" => false, "periode" => $request->periode]);
        } else {
            $karyawan = Karyawan::all();
            $kriteria = Kriteria::all();
            $data = [];

            foreach ($karyawan as $karyawanKey => $karyawanVal) {
                $data[$karyawanKey]["id_karyawan"] = $karyawanVal->id;
                $data[$karyawanKey]["nama"] = $karyawanVal->nama;

                foreach ($kriteria as $kriteriaKey => $kriteriaVal) {
                    $maxVal = Penilaian::where('periode', $request->periode)->where('id_kriteria', $kriteriaVal->id)->max('nilai');
                    foreach ($penilaian as $pKey => $pVal) {
                        if ($penilaian[$pKey]["id_karyawan"] == $karyawanVal->id && $penilaian[$pKey]["id_kriteria"] == $kriteriaVal->id) {
                            $nilai = 0;
                            if ($maxVal > 0) {
                                $nilai = $penilaian[$pKey]["nilai"] / $maxVal;
                                $nilai = number_format((float)$nilai, 2, '.', '');
                            }
                            $data[$karyawanKey]["nilai"][] = [
                                "kriteria" => $penilaian[$pKey]["id_kriteria"],
                                "nilai" => $nilai
                            ];
                        }
                    }
                }
            }

            $response = [
                "response" => true,
                "periode" => $request->periode,
                "data" => $data
            ];
            return response()->json($response);
        }
    }

    public function get_final_result(Request $request)
    {
        $result = [];

        foreach ($request->np as $npKey => $npVal) {
            $result[] = [
                "id_karyawan" => $npVal["id_karyawan"],
                "nama" => $npVal["nama"]
            ];

            $nilai = 0;
            foreach ($npVal["nilai"] as $npNilai) {
                $bobot = 0;

                foreach ($request->nk as $nkKey => $nkVal) {
                    if ($nkVal["id"] == $npNilai["kriteria"]) {
                        $bobot = $nkVal["bobot"];
                    }
                }

                $nilai = $nilai + ($npNilai["nilai"] * $bobot);
            }
            $result[$npKey]["nilai"] = number_format((float)$nilai, 2, '.', '');
        }

        usort($result, function ($a, $b) {
            return $b['nilai'] <=> $a['nilai'];
        });

        return response()->json($result);
    }

    // ===== KARYAWAN =====
    public function karyawan_dashboard()
    {
        $penilaian = Penilaian::where('periode', date('Y-m'))->where('id_karyawan', Auth::user()->karyawan->id)->get();
        $data = [];
        foreach ($penilaian as $p) {
            $data[] = [
                "kriteria" => $p->kriteria->nama,
                "nilai" => $p->nilai
            ];
        }

        return response()->json($data);
    }
}
