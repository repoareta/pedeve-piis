<?php

namespace App\Http\Controllers\SdmPayroll;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use DB;
use Illuminate\Http\Request;

class AbsensiKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ip = "192.168.16.201";
        $key = "0";
        $data_absensi = DB::table('absensi as a')
        ->leftJoin('sdm_master_pegawai as b', 'a.userid', '=', 'b.noabsen')
        ->select('a.userid','b.nama','b.noabsen')
        ->orderBy('tanggal', 'desc')
        ->get();

        $data_pegawai = DB::table('sdm_master_pegawai')
        ->where('noabsen', null)
        ->orderBy('tglentry', 'desc')
        ->get();
        return view('absensi_karyawan.index', compact('ip', 'key', 'data_absensi', 'data_pegawai'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson()
    {
        $absensi_list = DB::table('absensi as a')
        ->leftJoin('sdm_master_pegawai as b', 'a.userid', '=', 'b.noabsen')
        ->select('a.*','b.nama','b.noabsen')
        ->orderBy('tanggal', 'desc')
        ->get();
        
        return datatables()->of($absensi_list)
        ->addColumn('pegawai', function ($absensi_list) {
            if($absensi_list->noabsen == null){
                $radio = $absensi_list->userid;
            }else{
                $radio = $absensi_list->nama;
            }
            return $radio;
        })
        ->rawColumns(['pegawai'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request)
    {
        $ip = $request->ip_address;
        $key = $request->comm_key;

        $Connect = fsockopen($ip, "80", $errno, $errstr, 1);
        if ($Connect) {
            $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
            $newLine="\r\n";
            fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
            fputs($Connect, "Content-Type: text/xml".$newLine);
            fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
            fputs($Connect, $soap_request.$newLine);
            $buffer="";
            while ($Response=fgets($Connect, 1024)) {
                $buffer=$buffer.$Response;
            }
        } else {
            return "Koneksi Gagal";
        }

        $buffer=$this->parseData($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
        $buffer=explode("\r\n", $buffer);

        for ($a=0; $a < count($buffer); $a++) {
            $data = $this->parseData($buffer[$a], "<Row>", "</Row>");
            $PIN = $this->parseData($data, "<PIN>", "</PIN>");
            $DateTime = $this->parseData($data, "<DateTime>", "</DateTime>");
            $Verified = $this->parseData($data, "<Verified>", "</Verified>");
            $Status = $this->parseData($data, "<Status>", "</Status>");

            if ($PIN <> '') {
                $absensi = Absensi::where('userid', $PIN)
                ->where('tanggal', $DateTime)
                ->get();

                if ($absensi->count() == '0') {
                    // LAKUKAN INSERT
                    $absensi = new Absensi();
                    $absensi->userid = $PIN;
                    $absensi->tanggal  = $DateTime;
                    $absensi->verifikasi = $Verified;
                    $absensi->status = $Status;

                    $absensi->save();
                }
            }
        }

        return view('absensi_karyawan.index', compact('ip', 'key'));
    }

    public function parseData($data, $p1, $p2)
    {
        $data=" ".$data;
        $hasil="";
        $awal=strpos($data, $p1);
        if ($awal!="") {
            $akhir=strpos(strstr($data, $p1), $p2);
            if ($akhir!="") {
                $hasil=substr($data, $awal+strlen($p1), $akhir-strlen($p1));
            }
        }
        return $hasil;
    }

    public function mapping(Request $request)
    {
        DB::table('sdm_master_pegawai')
        ->where('nopeg', $request->nopeg)
        ->update([
        'noabsen' => $request->noabsen
        ]);
        return redirect()->route('absensi_karyawan.index');
    }
}
