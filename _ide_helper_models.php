<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\AardPayroll
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AardPayroll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AardPayroll newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AardPayroll query()
 */
	class AardPayroll extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Absensi
 *
 * @property int $id
 * @property string $userid
 * @property string $tanggal
 * @property string $verifikasi
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Absensi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Absensi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Absensi query()
 * @method static \Illuminate\Database\Eloquent\Builder|Absensi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absensi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absensi whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absensi whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absensi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absensi whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absensi whereVerifikasi($value)
 */
	class Absensi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Account
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 */
	class Account extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Agama
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Agama newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agama newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agama query()
 */
	class Agama extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Akta
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Akta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Akta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Akta query()
 */
	class Akta extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AnggaranDetail
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranDetail query()
 */
	class AnggaranDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AnggaranMain
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranMain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranMain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranMain query()
 */
	class AnggaranMain extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AnggaranSubMain
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranSubMain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranSubMain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranSubMain query()
 */
	class AnggaranSubMain extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BulanKontroller
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BulanKontroller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BulanKontroller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BulanKontroller query()
 */
	class BulanKontroller extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CashJudex
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CashJudex newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashJudex newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashJudex query()
 */
	class CashJudex extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DetailUmk
 *
 * @property int $no
 * @property string|null $keterangan
 * @property string|null $account
 * @property string|null $nilai
 * @property string|null $cj
 * @property string|null $jb
 * @property string|null $bagian
 * @property string|null $pk
 * @property string $no_umk
 * @property-read \App\Models\Umk $umk
 * @method static \Illuminate\Database\Eloquent\Builder|DetailUmk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailUmk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailUmk query()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailUmk whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailUmk whereBagian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailUmk whereCj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailUmk whereJb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailUmk whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailUmk whereNilai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailUmk whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailUmk whereNoUmk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailUmk wherePk($value)
 */
	class DetailUmk extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DftMenu
 *
 * @property string|null $menuid
 * @property string|null $menunm
 * @property string|null $userap
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|DftMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DftMenu newQuery()
 * @method static \Illuminate\Database\Query\Builder|DftMenu onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DftMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|DftMenu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DftMenu whereMenuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DftMenu whereMenunm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DftMenu whereUserap($value)
 * @method static \Illuminate\Database\Query\Builder|DftMenu withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DftMenu withoutTrashed()
 */
	class DftMenu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Direksi
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Direksi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Direksi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Direksi query()
 */
	class Direksi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DtlDepositoTest
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DtlDepositoTest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DtlDepositoTest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DtlDepositoTest query()
 */
	class DtlDepositoTest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Fiosd201
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Fiosd201 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fiosd201 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fiosd201 query()
 */
	class Fiosd201 extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GajiPokok
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GajiPokok newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GajiPokok newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GajiPokok query()
 */
	class GajiPokok extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GcgCoc
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GcgCoc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgCoc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgCoc query()
 */
	class GcgCoc extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GcgCoi
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GcgCoi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgCoi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgCoi query()
 */
	class GcgCoi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GcgFungsi
 *
 * @property int $id
 * @property string $nama
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GcgFungsi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgFungsi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgFungsi query()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgFungsi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GcgFungsi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GcgFungsi whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GcgFungsi whereUpdatedAt($value)
 */
	class GcgFungsi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GcgGratifikasi
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GcgGratifikasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgGratifikasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgGratifikasi query()
 */
	class GcgGratifikasi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GcgJabatan
 *
 * @property int $id
 * @property string $nama
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GcgJabatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgJabatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgJabatan query()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgJabatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GcgJabatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GcgJabatan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GcgJabatan whereUpdatedAt($value)
 */
	class GcgJabatan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GcgLhkpn
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GcgLhkpn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgLhkpn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgLhkpn query()
 */
	class GcgLhkpn extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GcgSosialisasi
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GcgSosialisasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgSosialisasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GcgSosialisasi query()
 */
	class GcgSosialisasi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GolonganGaji
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GolonganGaji newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GolonganGaji newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GolonganGaji query()
 */
	class GolonganGaji extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HistoryOb
 *
 * @method static \Illuminate\Database\Eloquent\Builder|HistoryOb newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HistoryOb newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HistoryOb query()
 */
	class HistoryOb extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\JenisBiaya
 *
 * @method static \Illuminate\Database\Eloquent\Builder|JenisBiaya newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JenisBiaya newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JenisBiaya query()
 */
	class JenisBiaya extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\JurumDoc
 *
 * @method static \Illuminate\Database\Eloquent\Builder|JurumDoc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JurumDoc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JurumDoc query()
 */
	class JurumDoc extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\JurumLine
 *
 * @method static \Illuminate\Database\Eloquent\Builder|JurumLine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JurumLine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JurumLine query()
 */
	class JurumLine extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Kasdoc
 *
 * @property string $docno
 * @property string|null $thnbln
 * @property string|null $jk
 * @property string|null $store
 * @property string|null $ci
 * @property string|null $voucher
 * @property string|null $kepada
 * @property string|null $debet
 * @property string|null $kredit
 * @property string|null $rekap
 * @property string|null $rekapdate
 * @property string|null $original
 * @property string|null $originaldate
 * @property string|null $approved
 * @property string|null $approveddate
 * @property string|null $approvedpwd
 * @property string|null $verified
 * @property string|null $verifieddate
 * @property string|null $paid
 * @property string|null $paiddate
 * @property string|null $posted
 * @property string|null $posteddate
 * @property string|null $inputdate
 * @property string|null $inputpwd
 * @property string|null $updatedate
 * @property string|null $updatepwd
 * @property string|null $anggaran
 * @property string|null $keterangan
 * @property string|null $mrs_no
 * @property string|null $rate
 * @property string|null $asal
 * @property string|null $rate_pajak
 * @property string|null $asal_date
 * @property string|null $nilai_dok
 * @property string|null $dok_penutup
 * @property string|null $kd_kepada
 * @property string|null $jenis_kepada
 * @property string|null $verifiedby
 * @property string|null $originalby
 * @property string|null $postedby
 * @property string|null $paidby
 * @property string|null $tgl_kurs
 * @property string|null $flag_voucher
 * @property string|null $ref_no
 * @property string|null $ket1
 * @property string|null $ket2
 * @property string|null $ket3
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Kasline[] $kasline
 * @property-read int|null $kasline_count
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc query()
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereApproveddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereApprovedpwd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereAsal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereAsalDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereCi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereDebet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereDocno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereDokPenutup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereFlagVoucher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereInputdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereInputpwd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereJenisKepada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereJk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereKdKepada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereKepada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereKet1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereKet2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereKet3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereKredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereMrsNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereNilaiDok($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereOriginalby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereOriginaldate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc wherePaidby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc wherePaiddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc wherePosted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc wherePostedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc wherePosteddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereRatePajak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereRefNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereRekap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereRekapdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereStore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereTglKurs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereThnbln($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereUpdatedate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereUpdatepwd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereVerifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereVerifieddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasdoc whereVoucher($value)
 */
	class Kasdoc extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Kasline
 *
 * @property string $docno
 * @property int $lineno
 * @property string|null $account
 * @property string|null $area
 * @property string|null $lokasi
 * @property string|null $bagian
 * @property string|null $pk
 * @property string|null $jb
 * @property string|null $cj
 * @property string|null $totprice
 * @property string|null $keterangan
 * @property string|null $verified
 * @property string|null $verifieddate
 * @property string|null $verifiedpwd
 * @property string|null $inputdate
 * @property string|null $inputpwd
 * @property string|null $updatedate
 * @property string|null $updatepwd
 * @property string|null $voucher
 * @property string|null $pau
 * @property string|null $penutup
 * @property string|null $paudate
 * @property string|null $paupwd
 * @property string|null $nopajak
 * @property string|null $tglpajak
 * @property string|null $thnbln
 * @property string|null $rekap
 * @property string|null $totpricerp
 * @property string|null $ref_no
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline query()
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereBagian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereCj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereDocno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereInputdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereInputpwd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereJb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereLineno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereLokasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereNopajak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline wherePau($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline wherePaudate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline wherePaupwd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline wherePenutup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline wherePk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereRefNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereRekap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereTglpajak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereThnbln($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereTotprice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereTotpricerp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereUpdatedate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereUpdatepwd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereVerifieddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereVerifiedpwd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kasline whereVoucher($value)
 */
	class Kasline extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Keluarga
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Keluarga newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Keluarga newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Keluarga query()
 */
	class Keluarga extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\KodeBagian
 *
 * @property string $kode
 * @property string $nama
 * @method static \Illuminate\Database\Eloquent\Builder|KodeBagian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KodeBagian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KodeBagian query()
 * @method static \Illuminate\Database\Eloquent\Builder|KodeBagian whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KodeBagian whereNama($value)
 */
	class KodeBagian extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\KodeJabatan
 *
 * @property string $kdbag
 * @property string $kdjab
 * @property string $keterangan
 * @property string|null $goljob
 * @property string|null $tunjangan
 * @property-read \App\Models\KodeBagian $kode_bagian
 * @method static \Illuminate\Database\Eloquent\Builder|KodeJabatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KodeJabatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KodeJabatan query()
 * @method static \Illuminate\Database\Eloquent\Builder|KodeJabatan whereGoljob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KodeJabatan whereKdbag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KodeJabatan whereKdjab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KodeJabatan whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KodeJabatan whereTunjangan($value)
 */
	class KodeJabatan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Komisaris
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Komisaris newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Komisaris newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Komisaris query()
 */
	class Komisaris extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\KoreksiGaji
 *
 * @method static \Illuminate\Database\Eloquent\Builder|KoreksiGaji newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KoreksiGaji newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KoreksiGaji query()
 */
	class KoreksiGaji extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Kursus
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Kursus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kursus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kursus query()
 */
	class Kursus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Lokasi
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Lokasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lokasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lokasi query()
 */
	class Lokasi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MainAccount
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MainAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MainAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MainAccount query()
 */
	class MainAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterBebanPerusahaan
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MasterBebanPerusahaan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterBebanPerusahaan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterBebanPerusahaan query()
 */
	class MasterBebanPerusahaan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterHutang
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MasterHutang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterHutang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterHutang query()
 */
	class MasterHutang extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterInsentif
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MasterInsentif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterInsentif newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterInsentif query()
 */
	class MasterInsentif extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterThr
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MasterThr newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterThr newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterThr query()
 */
	class MasterThr extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterUpah
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MasterUpah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterUpah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterUpah query()
 */
	class MasterUpah extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MtrDeposito
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MtrDeposito newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MtrDeposito newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MtrDeposito query()
 */
	class MtrDeposito extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PPanjarDetail
 *
 * @property int $no
 * @property string $no_ppanjar
 * @property string|null $keterangan
 * @property string|null $nilai
 * @property string|null $mulai
 * @property string|null $sampai
 * @property string|null $total
 * @property string $nopek
 * @property string|null $qty
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarDetail whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarDetail whereMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarDetail whereNilai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarDetail whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarDetail whereNoPpanjar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarDetail whereNopek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarDetail whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarDetail whereSampai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarDetail whereTotal($value)
 */
	class PPanjarDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PPanjarHeader
 *
 * @property string $no_ppanjar
 * @property string|null $no_panjar
 * @property string|null $keterangan
 * @property string|null $tgl_ppanjar
 * @property string $nopek
 * @property string|null $jmlpanjar
 * @property string|null $pangkat
 * @property string|null $gol
 * @property string|null $nama
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\PanjarHeader|null $panjar_header
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PPanjarDetail[] $ppanjar_detail
 * @property-read int|null $ppanjar_detail_count
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarHeader newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarHeader newQuery()
 * @method static \Illuminate\Database\Query\Builder|PPanjarHeader onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarHeader query()
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarHeader whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarHeader whereGol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarHeader whereJmlpanjar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarHeader whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarHeader whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarHeader whereNoPanjar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarHeader whereNoPpanjar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarHeader whereNopek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarHeader wherePangkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPanjarHeader whereTglPpanjar($value)
 * @method static \Illuminate\Database\Query\Builder|PPanjarHeader withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PPanjarHeader withoutTrashed()
 */
	class PPanjarHeader extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PUmkDetail
 *
 * @property int $no
 * @property string|null $keterangan
 * @property string|null $account
 * @property string|null $nilai
 * @property string|null $cj
 * @property string|null $jb
 * @property string|null $bagian
 * @property string|null $pk
 * @property string $no_pumk
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkDetail whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkDetail whereBagian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkDetail whereCj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkDetail whereJb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkDetail whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkDetail whereNilai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkDetail whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkDetail whereNoPumk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkDetail wherePk($value)
 */
	class PUmkDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PUmkHeader
 *
 * @property string|null $tgl_pumk
 * @property string|null $app_sdm
 * @property string|null $app_sdm_oleh
 * @property string|null $app_sdm_tgl
 * @property string|null $app_pbd_oleh
 * @property string|null $app_pbd_tgl
 * @property string|null $no_kas
 * @property string|null $bulan_buku
 * @property string|null $keterangan
 * @property string|null $app_pbd
 * @property string $no_umk
 * @property string $no_pumk
 * @property string|null $nopek
 * @property string|null $nama
 * @property string|null $eselon
 * @property-read \App\Models\Pekerja|null $pekerja
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PUmkDetail[] $pumk_detail
 * @property-read int|null $pumk_detail_count
 * @property-read \App\Models\UmkHeader $umk_header
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader query()
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereAppPbd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereAppPbdOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereAppPbdTgl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereAppSdm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereAppSdmOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereAppSdmTgl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereBulanBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereEselon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereNoKas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereNoPumk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereNoUmk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereNopek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PUmkHeader whereTglPumk($value)
 */
	class PUmkHeader extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PajakInput
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PajakInput newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PajakInput newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PajakInput query()
 */
	class PajakInput extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PanjarDetail
 *
 * @property int $no
 * @property string $no_panjar
 * @property string|null $keterangan
 * @property string|null $nopek
 * @property string|null $nama
 * @property string|null $jabatan
 * @property string|null $status
 * @property string|null $panjar
 * @property-read \App\Models\PanjarHeader $panjar_header
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarDetail whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarDetail whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarDetail whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarDetail whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarDetail whereNoPanjar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarDetail whereNopek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarDetail wherePanjar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarDetail whereStatus($value)
 */
	class PanjarDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PanjarHeader
 *
 * @property string $no_panjar
 * @property string|null $dari
 * @property string|null $app_sdm
 * @property string|null $app_sdm_oleh
 * @property string|null $app_sdm_tgl
 * @property string|null $keterangan
 * @property string|null $jenis_dinas
 * @property string $mulai
 * @property string $sampai
 * @property string $nopek
 * @property string|null $tujuan
 * @property string|null $atasan
 * @property string|null $kendaraan
 * @property string|null $ditanggung_oleh
 * @property string|null $nama
 * @property string|null $pangkat
 * @property string|null $gol
 * @property string|null $jabatan
 * @property string|null $eselon
 * @property string|null $ktp
 * @property string|null $menyetujui
 * @property string|null $menyetujui_keu
 * @property string|null $jum_panjar
 * @property string|null $tgl_panjar
 * @property string|null $no_umk
 * @property string|null $atasan_jab
 * @property string|null $menyetujui_jab
 * @property string|null $personalia
 * @property string|null $personalia_jab
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PanjarDetail[] $panjar_detail
 * @property-read int|null $panjar_detail_count
 * @property-read \App\Models\PPanjarHeader|null $ppanjar_header
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader newQuery()
 * @method static \Illuminate\Database\Query\Builder|PanjarHeader onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader query()
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereAppSdm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereAppSdmOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereAppSdmTgl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereAtasan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereAtasanJab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereDari($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereDitanggungOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereEselon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereGol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereJenisDinas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereJumPanjar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereKendaraan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereKtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereMenyetujui($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereMenyetujuiJab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereMenyetujuiKeu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereNoPanjar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereNoUmk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereNopek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader wherePangkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader wherePersonalia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader wherePersonaliaJab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereSampai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereTglPanjar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PanjarHeader whereTujuan($value)
 * @method static \Illuminate\Database\Query\Builder|PanjarHeader withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PanjarHeader withoutTrashed()
 */
	class PanjarHeader extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PayAard
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PayAard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayAard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayAard query()
 */
	class PayAard extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PayDanaPensiun
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PayDanaPensiun newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayDanaPensiun newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayDanaPensiun query()
 */
	class PayDanaPensiun extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PayGapokBulanan
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PayGapokBulanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayGapokBulanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayGapokBulanan query()
 */
	class PayGapokBulanan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PayHonor
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PayHonor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayHonor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayHonor query()
 */
	class PayHonor extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PayKoreksi
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PayKoreksi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayKoreksi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayKoreksi query()
 */
	class PayKoreksi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PayLembur
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PayLembur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayLembur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayLembur query()
 */
	class PayLembur extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PayMtrPkpp
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PayMtrPkpp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayMtrPkpp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayMtrPkpp query()
 */
	class PayMtrPkpp extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PayPotongan
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PayPotongan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayPotongan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayPotongan query()
 */
	class PayPotongan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PayPotonganInsentif
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PayPotonganInsentif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayPotonganInsentif newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayPotonganInsentif query()
 */
	class PayPotonganInsentif extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PayPotonganRevo
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PayPotonganRevo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayPotonganRevo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayPotonganRevo query()
 */
	class PayPotonganRevo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PayTabungan
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PayTabungan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayTabungan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayTabungan query()
 */
	class PayTabungan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PayTunjangan
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PayTunjangan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayTunjangan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayTunjangan query()
 */
	class PayTunjangan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pekerja
 *
 * @property string $nopeg
 * @property string|null $nama
 * @property string|null $status
 * @property string|null $tgllahir
 * @property string|null $tempatlhr
 * @property string|null $proplhr
 * @property string|null $agama
 * @property string|null $goldarah
 * @property string|null $notlp
 * @property string|null $kodekeluarga
 * @property string|null $noydp
 * @property string|null $noastek
 * @property string|null $tglaktifdns
 * @property string|null $alamat1
 * @property string|null $alamat2
 * @property string|null $alamat3
 * @property string|null $gelar1
 * @property string|null $gelar2
 * @property string|null $gelar3
 * @property string|null $nohp
 * @property string|null $gender
 * @property string|null $npwp
 * @property string|null $photo
 * @property string|null $userid
 * @property string|null $tglentry
 * @property string|null $fasilitas
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $noktp
 * @property string|null $noabsen
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Jabatan[] $jabatan
 * @property-read int|null $jabatan_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Jabatan[] $jabatan_latest
 * @property-read int|null $jabatan_latest_count
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja newQuery()
 * @method static \Illuminate\Database\Query\Builder|Pekerja onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereAgama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereAlamat1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereAlamat2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereAlamat3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereFasilitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereGelar1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereGelar2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereGelar3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereGoldarah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereKodekeluarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereNoabsen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereNoastek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereNohp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereNoktp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereNopeg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereNotlp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereNoydp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereNpwp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereProplhr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereTempatlhr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereTglaktifdns($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereTglentry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereTgllahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pekerja whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|Pekerja withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Pekerja withoutTrashed()
 */
	class Pekerja extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pendidikan
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Pendidikan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pendidikan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pendidikan query()
 */
	class Pendidikan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PerguruanTinggi
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PerguruanTinggi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PerguruanTinggi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PerguruanTinggi query()
 */
	class PerguruanTinggi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Provinsi
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Provinsi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Provinsi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Provinsi query()
 */
	class Provinsi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Umk
 *
 * @property string|null $tgl_panjar
 * @property string|null $app_sdm
 * @property string|null $app_sdm_oleh
 * @property string|null $app_sdm_tgl
 * @property string|null $app_pbd_oleh
 * @property string|null $app_pbd_tgl
 * @property string|null $no_kas
 * @property string|null $bulan_buku
 * @property string|null $keterangan
 * @property string|null $ci
 * @property string|null $app_pbd
 * @property string|null $rate
 * @property string|null $jenis_um
 * @property string $no_umk
 * @property string|null $jumlah
 * @property string|null $kepada
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DetailUmk[] $detailumk
 * @property-read int|null $detailumk_count
 * @method static \Illuminate\Database\Eloquent\Builder|Umk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Umk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Umk query()
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereAppPbd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereAppPbdOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereAppPbdTgl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereAppSdm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereAppSdmOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereAppSdmTgl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereBulanBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereCi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereJenisUm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereKepada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereNoKas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereNoUmk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Umk whereTglPanjar($value)
 */
	class Umk extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UmkDetail
 *
 * @property string|null $tgl_panjar
 * @property string|null $app_sdm
 * @property string|null $app_sdm_oleh
 * @property string|null $app_sdm_tgl
 * @property string|null $app_pbd_oleh
 * @property string|null $app_pbd_tgl
 * @property string|null $no_kas
 * @property string|null $bulan_buku
 * @property string|null $keterangan
 * @property string|null $ci
 * @property string|null $app_pbd
 * @property string|null $rate
 * @property string|null $jenis_um
 * @property string $no_umk
 * @property string|null $jumlah
 * @property string|null $kepada
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereAppPbd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereAppPbdOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereAppPbdTgl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereAppSdm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereAppSdmOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereAppSdmTgl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereBulanBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereCi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereJenisUm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereKepada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereNoKas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereNoUmk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkDetail whereTglPanjar($value)
 */
	class UmkDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UmkHeader
 *
 * @property string|null $tgl_panjar
 * @property string|null $app_sdm
 * @property string|null $app_sdm_oleh
 * @property string|null $app_sdm_tgl
 * @property string|null $app_pbd_oleh
 * @property string|null $app_pbd_tgl
 * @property string|null $no_kas
 * @property string|null $bulan_buku
 * @property string|null $keterangan
 * @property string|null $ci
 * @property string|null $app_pbd
 * @property string|null $rate
 * @property string|null $jenis_um
 * @property string $no_umk
 * @property string|null $jumlah
 * @property string|null $kepada
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader query()
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereAppPbd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereAppPbdOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereAppPbdTgl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereAppSdm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereAppSdmOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereAppSdmTgl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereBulanBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereCi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereJenisUm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereKepada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereNoKas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereNoUmk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UmkHeader whereTglPanjar($value)
 */
	class UmkHeader extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property string|null $username
 * @property string|null $password
 * @property string|null $empid
 * @property string|null $roleid
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmpid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserLog
 *
 * @property string|null $userid
 * @property string|null $usernm
 * @property string|null $login
 * @property string|null $logout
 * @property string|null $terminal
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog whereLogout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog whereTerminal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog whereUsernm($value)
 */
	class UserLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserLogin
 *
 * @property string|null $userid
 * @property string|null $usernm
 * @property string|null $login
 * @property string|null $terminal
 * @method static \Illuminate\Database\Eloquent\Builder|UserLogin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLogin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLogin query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLogin whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLogin whereTerminal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLogin whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLogin whereUsernm($value)
 */
	class UserLogin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserMenu
 *
 * @property string|null $userid
 * @property string|null $menuid
 * @property string|null $ability
 * @property string|null $tambah
 * @property string|null $rubah
 * @property string|null $hapus
 * @property string|null $cetak
 * @property string|null $lihat
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserMenu onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereAbility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereCetak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereHapus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereLihat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereMenuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereRubah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereTambah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMenu whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|UserMenu withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserMenu withoutTrashed()
 */
	class UserMenu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserPdv
 *
 * @property string|null $userid
 * @property string|null $usernm
 * @property string|null $userlv
 * @property string|null $userap
 * @property string|null $userpw
 * @property string|null $tglupd
 * @property string|null $usrupd
 * @property string|null $kode
 * @property string|null $passexp
 * @property string|null $host
 * @property string|null $nopeg
 * @property int|null $gcg_fungsi_id
 * @property int|null $gcg_jabatan_id
 * @property string|null $deleted_at
 * @property string|null $file
 * @property-read \App\Models\GcgFungsi|null $fungsi
 * @property-read \App\Models\GcgJabatan|null $fungsi_jabatan
 * @property-read \App\Models\Pekerja|null $pekerja
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv whereGcgFungsiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv whereGcgJabatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv whereNopeg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv wherePassexp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv whereTglupd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv whereUserap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv whereUserlv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv whereUsernm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv whereUserpw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPdv whereUsrupd($value)
 */
	class UserPdv extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Vendor
 *
 * @property int $vendorid
 * @property string $nama
 * @property string $alamat
 * @property string $telpon
 * @property string|null $norek
 * @property string|null $nama_bank
 * @property string|null $cabang_bank
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereCabangBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereNamaBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereNorek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereTelpon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereVendorid($value)
 */
	class Vendor extends \Eloquent {}
}

