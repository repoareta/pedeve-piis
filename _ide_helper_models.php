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
 * @property-read \App\Models\Jabatan|null $jabatan_latest_one
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

