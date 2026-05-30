<?php

namespace App\Controllers;

use App\Models\PendudukDesaModel;
use App\Models\KelahiranModel;
use App\Models\KematianModel;
use App\Models\LansiaModel;

class SoapRekapController extends BaseController
{
    protected $pendudukModel;
    protected $kelahiranModel;
    protected $kematianModel;
    protected $lansiaModel;

    public function __construct()
    {
        $this->pendudukModel  = new PendudukDesaModel();
        $this->kelahiranModel = new KelahiranModel();
        $this->kematianModel  = new KematianModel();
        $this->lansiaModel    = new LansiaModel();
    }

    public function index()
    {
        if ($this->request->getMethod(true) === 'GET' && $this->request->getGet('wsdl') !== null) {
            return $this->wsdl();
        }

        if ($this->request->getMethod(true) === 'GET') {
            return $this->info();
        }

        return $this->handleSoapRequest();
    }

    private function info()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<soap_service>';
        $xml .= '<nama>Sistem Informasi Data PKK Desa</nama>';
        $xml .= '<jenis>SOAP Web Service Rekap dan Laporan Data Desa</jenis>';
        $xml .= '<wsdl>' . site_url('soap/rekap-desa?wsdl') . '</wsdl>';
        $xml .= '<endpoint>' . site_url('soap/rekap-desa') . '</endpoint>';
        $xml .= '<method>';
        $xml .= '<item>getRekapDesa</item>';
        $xml .= '<item>getRekapPenduduk</item>';
        $xml .= '<item>getRekapKelahiran</item>';
        $xml .= '<item>getRekapKematian</item>';
        $xml .= '<item>getRekapLansia</item>';
        $xml .= '<item>getLaporanBulanan</item>';
        $xml .= '</method>';
        $xml .= '</soap_service>';

        return $this->response
            ->setStatusCode(200)
            ->setContentType('application/xml')
            ->setBody($xml);
    }

    private function wsdl()
    {
        $endpoint = site_url('soap/rekap-desa');

        $wsdl = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<definitions
    name="RekapDesaService"
    targetNamespace="http://localhost/soap/rekap-desa"
    xmlns:tns="http://localhost/soap/rekap-desa"
    xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns="http://schemas.xmlsoap.org/wsdl/">

    <types>
        <xsd:schema targetNamespace="http://localhost/soap/rekap-desa">

            <xsd:element name="getRekapDesa">
                <xsd:complexType>
                    <xsd:sequence>
                        <xsd:element name="id_desa" type="xsd:string"/>
                    </xsd:sequence>
                </xsd:complexType>
            </xsd:element>

            <xsd:element name="getRekapPenduduk">
                <xsd:complexType>
                    <xsd:sequence>
                        <xsd:element name="id_desa" type="xsd:string"/>
                    </xsd:sequence>
                </xsd:complexType>
            </xsd:element>

            <xsd:element name="getRekapKelahiran">
                <xsd:complexType>
                    <xsd:sequence>
                        <xsd:element name="id_desa" type="xsd:string"/>
                    </xsd:sequence>
                </xsd:complexType>
            </xsd:element>

            <xsd:element name="getRekapKematian">
                <xsd:complexType>
                    <xsd:sequence>
                        <xsd:element name="id_desa" type="xsd:string"/>
                    </xsd:sequence>
                </xsd:complexType>
            </xsd:element>

            <xsd:element name="getRekapLansia">
                <xsd:complexType>
                    <xsd:sequence>
                        <xsd:element name="id_desa" type="xsd:string"/>
                    </xsd:sequence>
                </xsd:complexType>
            </xsd:element>

            <xsd:element name="getLaporanBulanan">
                <xsd:complexType>
                    <xsd:sequence>
                        <xsd:element name="id_desa" type="xsd:string"/>
                        <xsd:element name="bulan" type="xsd:int"/>
                        <xsd:element name="tahun" type="xsd:int"/>
                        <xsd:element name="rt" type="xsd:string" minOccurs="0"/>
                    </xsd:sequence>
                </xsd:complexType>
            </xsd:element>

            <xsd:element name="RekapResponse" type="xsd:string"/>

        </xsd:schema>
    </types>

    <message name="getRekapDesaRequest">
        <part name="parameters" element="tns:getRekapDesa"/>
    </message>
    <message name="getRekapDesaResponse">
        <part name="parameters" element="tns:RekapResponse"/>
    </message>

    <message name="getRekapPendudukRequest">
        <part name="parameters" element="tns:getRekapPenduduk"/>
    </message>
    <message name="getRekapPendudukResponse">
        <part name="parameters" element="tns:RekapResponse"/>
    </message>

    <message name="getRekapKelahiranRequest">
        <part name="parameters" element="tns:getRekapKelahiran"/>
    </message>
    <message name="getRekapKelahiranResponse">
        <part name="parameters" element="tns:RekapResponse"/>
    </message>

    <message name="getRekapKematianRequest">
        <part name="parameters" element="tns:getRekapKematian"/>
    </message>
    <message name="getRekapKematianResponse">
        <part name="parameters" element="tns:RekapResponse"/>
    </message>

    <message name="getRekapLansiaRequest">
        <part name="parameters" element="tns:getRekapLansia"/>
    </message>
    <message name="getRekapLansiaResponse">
        <part name="parameters" element="tns:RekapResponse"/>
    </message>

    <message name="getLaporanBulananRequest">
        <part name="parameters" element="tns:getLaporanBulanan"/>
    </message>
    <message name="getLaporanBulananResponse">
        <part name="parameters" element="tns:RekapResponse"/>
    </message>

    <portType name="RekapDesaPortType">
        <operation name="getRekapDesa">
            <input message="tns:getRekapDesaRequest"/>
            <output message="tns:getRekapDesaResponse"/>
        </operation>

        <operation name="getRekapPenduduk">
            <input message="tns:getRekapPendudukRequest"/>
            <output message="tns:getRekapPendudukResponse"/>
        </operation>

        <operation name="getRekapKelahiran">
            <input message="tns:getRekapKelahiranRequest"/>
            <output message="tns:getRekapKelahiranResponse"/>
        </operation>

        <operation name="getRekapKematian">
            <input message="tns:getRekapKematianRequest"/>
            <output message="tns:getRekapKematianResponse"/>
        </operation>

        <operation name="getRekapLansia">
            <input message="tns:getRekapLansiaRequest"/>
            <output message="tns:getRekapLansiaResponse"/>
        </operation>

        <operation name="getLaporanBulanan">
            <input message="tns:getLaporanBulananRequest"/>
            <output message="tns:getLaporanBulananResponse"/>
        </operation>
    </portType>

    <binding name="RekapDesaBinding" type="tns:RekapDesaPortType">
        <soap:binding style="document" transport="http://schemas.xmlsoap.org/soap/http"/>

        <operation name="getRekapDesa">
            <soap:operation soapAction="getRekapDesa"/>
            <input><soap:body use="literal"/></input>
            <output><soap:body use="literal"/></output>
        </operation>

        <operation name="getRekapPenduduk">
            <soap:operation soapAction="getRekapPenduduk"/>
            <input><soap:body use="literal"/></input>
            <output><soap:body use="literal"/></output>
        </operation>

        <operation name="getRekapKelahiran">
            <soap:operation soapAction="getRekapKelahiran"/>
            <input><soap:body use="literal"/></input>
            <output><soap:body use="literal"/></output>
        </operation>

        <operation name="getRekapKematian">
            <soap:operation soapAction="getRekapKematian"/>
            <input><soap:body use="literal"/></input>
            <output><soap:body use="literal"/></output>
        </operation>

        <operation name="getRekapLansia">
            <soap:operation soapAction="getRekapLansia"/>
            <input><soap:body use="literal"/></input>
            <output><soap:body use="literal"/></output>
        </operation>

        <operation name="getLaporanBulanan">
            <soap:operation soapAction="getLaporanBulanan"/>
            <input><soap:body use="literal"/></input>
            <output><soap:body use="literal"/></output>
        </operation>
    </binding>

    <service name="RekapDesaService">
        <documentation>SOAP Web Service untuk rekap dan laporan data PKK desa.</documentation>
        <port name="RekapDesaPort" binding="tns:RekapDesaBinding">
            <soap:address location="$endpoint"/>
        </port>
    </service>
</definitions>
XML;

        return $this->response
            ->setStatusCode(200)
            ->setContentType('text/xml')
            ->setBody($wsdl);
    }

    private function handleSoapRequest()
    {
        $rawXml = trim((string) $this->request->getBody());

        if ($rawXml === '') {
            return $this->soapFault('Client', 'SOAP request body tidak boleh kosong.');
        }

        $parsed = $this->parseSoapRequest($rawXml);

        if (!$parsed['status']) {
            return $this->soapFault('Client', $parsed['message']);
        }

        $method = $parsed['method'];
        $params = $parsed['params'];
        $idDesa = trim((string) ($params['id_desa'] ?? ''));

        if ($idDesa === '') {
            return $this->soapFault('Client', 'id_desa wajib dikirim pada SOAP request.');
        }

        switch ($method) {
            case 'getRekapDesa':
                $data = $this->getRekapDesa($idDesa);
                break;

            case 'getRekapPenduduk':
                $data = $this->getRekapPenduduk($idDesa);
                break;

            case 'getRekapKelahiran':
                $data = $this->getRekapKelahiran($idDesa);
                break;

            case 'getRekapKematian':
                $data = $this->getRekapKematian($idDesa);
                break;

            case 'getRekapLansia':
                $data = $this->getRekapLansia($idDesa);
                break;

            case 'getLaporanBulanan':
                $bulan = (int) ($params['bulan'] ?? date('m'));
                $tahun = (int) ($params['tahun'] ?? date('Y'));
                $rt = trim((string) ($params['rt'] ?? ''));

                if ($bulan < 1 || $bulan > 12) {
                    return $this->soapFault('Client', 'bulan harus bernilai 1 sampai 12.');
                }

                if ($tahun < 2000 || $tahun > 2100) {
                    return $this->soapFault('Client', 'tahun tidak valid.');
                }

                $data = $this->getLaporanBulanan($idDesa, $bulan, $tahun, $rt);
                break;

            default:
                return $this->soapFault('Client', 'Method SOAP tidak dikenal: ' . $method);
        }

        return $this->soapSuccess($method, $data);
    }

    private function parseSoapRequest(string $rawXml): array
    {
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();

        if (!$dom->loadXML($rawXml)) {
            return [
                'status'  => false,
                'message' => 'Format XML SOAP tidak valid.',
            ];
        }

        $body = null;
        $bodies = $dom->getElementsByTagNameNS('http://schemas.xmlsoap.org/soap/envelope/', 'Body');

        if ($bodies->length > 0) {
            $body = $bodies->item(0);
        }

        if (!$body) {
            $allElements = $dom->getElementsByTagName('*');

            foreach ($allElements as $element) {
                if ($element->localName === 'Body') {
                    $body = $element;
                    break;
                }
            }
        }

        if (!$body) {
            return [
                'status'  => false,
                'message' => 'Elemen SOAP Body tidak ditemukan.',
            ];
        }

        $operation = null;

        foreach ($body->childNodes as $child) {
            if ($child instanceof \DOMElement) {
                $operation = $child;
                break;
            }
        }

        if (!$operation) {
            return [
                'status'  => false,
                'message' => 'Method SOAP tidak ditemukan pada Body.',
            ];
        }

        $params = [];

        foreach ($operation->childNodes as $child) {
            if ($child instanceof \DOMElement) {
                $params[$child->localName] = trim($child->textContent);
            }
        }

        return [
            'status' => true,
            'method' => $operation->localName,
            'params' => $params,
        ];
    }

    private function getRekapDesa(string $idDesa): array
    {
        return [
            'id_desa'   => $idDesa,
            'nama_desa' => $this->getNamaDesaAktif($idDesa),
            'penduduk'  => $this->getRekapPenduduk($idDesa),
            'kelahiran' => $this->getRekapKelahiran($idDesa),
            'kematian'  => $this->getRekapKematian($idDesa),
            'lansia'    => $this->getRekapLansia($idDesa),
        ];
    }

    private function getRekapPenduduk(string $idDesa): array
    {
        $total = $this->pendudukModel
            ->where('id_desa', $idDesa)
            ->countAllResults();

        $lakiLaki = $this->pendudukModel
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'L')
            ->countAllResults();

        $perempuan = $this->pendudukModel
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'P')
            ->countAllResults();

        $perRt = $this->pendudukModel
            ->select('RT, COUNT(*) AS jumlah')
            ->where('id_desa', $idDesa)
            ->groupBy('RT')
            ->orderBy('RT', 'ASC')
            ->findAll();

        $perPendidikan = $this->pendudukModel
            ->select('pendidikan, COUNT(*) AS jumlah')
            ->where('id_desa', $idDesa)
            ->groupBy('pendidikan')
            ->orderBy('pendidikan', 'ASC')
            ->findAll();

        return [
            'total_penduduk'  => $total,
            'total_laki_laki' => $lakiLaki,
            'total_perempuan' => $perempuan,
            'penduduk_per_rt' => $perRt,
            'pendidikan'      => $perPendidikan,
        ];
    }

    private function getRekapKelahiran(string $idDesa): array
    {
        $total = $this->kelahiranModel
            ->where('id_desa', $idDesa)
            ->countAllResults();

        $lakiLaki = $this->kelahiranModel
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'L')
            ->countAllResults();

        $perempuan = $this->kelahiranModel
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'P')
            ->countAllResults();

        return [
            'total_kelahiran' => $total,
            'total_laki_laki' => $lakiLaki,
            'total_perempuan' => $perempuan,
        ];
    }

    private function getRekapKematian(string $idDesa): array
    {
        $total = $this->kematianModel
            ->where('id_desa', $idDesa)
            ->countAllResults();

        return [
            'total_kematian' => $total,
        ];
    }

    private function getRekapLansia(string $idDesa): array
    {
        $data = $this->lansiaModel
            ->where('id_desa', $idDesa)
            ->findAll();

        $total = count($data);
        $produktif = 0;
        $nonProduktif = 0;

        foreach ($data as $row) {
            $value = strtolower(trim((string) ($row['produktifitas'] ?? '')));
            $value = str_replace(['_', ' '], '-', $value);

            if ($value === 'produktif') {
                $produktif++;
            } elseif ($value === 'non-produktif' || $value === 'nonproduktif') {
                $nonProduktif++;
            }
        }

        return [
            'total_lansia'              => $total,
            'total_lansia_produktif'    => $produktif,
            'total_lansia_nonproduktif' => $nonProduktif,
        ];
    }

    private function getLaporanBulanan(string $idDesa, int $bulan, int $tahun, string $rt = ''): array
    {
        $lansia = $this->getLansiaData($idDesa, $rt);

        return [
            'desa' => [
                'id_desa'   => $idDesa,
                'nama_desa' => $this->getNamaDesaAktif($idDesa),
            ],
            'periode' => [
                'bulan'      => $bulan,
                'nama_bulan' => $this->getNamaBulan($bulan),
                'tahun'      => $tahun,
                'rt'         => $rt !== '' ? $rt : 'Semua RT',
            ],
            'ringkasan' => [
                'total_penduduk'     => $this->countPenduduk($idDesa, $rt),
                'total_laki_laki'    => $this->countPenduduk($idDesa, $rt, 'L'),
                'total_perempuan'    => $this->countPenduduk($idDesa, $rt, 'P'),
                'total_kelahiran'    => $this->countKelahiran($idDesa, $bulan, $tahun, $rt),
                'total_kematian'     => $this->countKematian($idDesa, $bulan, $tahun, $rt),
                'total_lansia'       => count($lansia),
                'lansia_produktif'   => $this->countStatusLansia($lansia, 'produktif'),
                'lansia_nonproduktif'=> $this->countStatusLansia($lansia, 'non-produktif'),
            ],
            'rekap_rt'  => $this->getRekapRt($idDesa, $rt),
            'kelahiran' => $this->getDataKelahiran($idDesa, $bulan, $tahun, $rt),
            'kematian'  => $this->getDataKematian($idDesa, $bulan, $tahun, $rt),
            'lansia'    => $lansia,
        ];
    }

    private function countPenduduk(string $idDesa, string $rt = '', ?string $jenisKelamin = null): int
    {
        $query = $this->pendudukModel->where('id_desa', $idDesa);

        if ($rt !== '') {
            $query->where('RT', $rt);
        }

        if ($jenisKelamin !== null) {
            $query->where('jenis_kelamin', $jenisKelamin);
        }

        return $query->countAllResults();
    }

    private function countKelahiran(string $idDesa, int $bulan, int $tahun, string $rt = ''): int
    {
        $query = $this->kelahiranModel
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Kelahiran.nik_ibu AND PendudukDesa.id_desa = Kelahiran.id_desa',
                'left'
            )
            ->where('Kelahiran.id_desa', $idDesa)
            ->where('MONTH(Kelahiran.tgl_lahir)', $bulan, false)
            ->where('YEAR(Kelahiran.tgl_lahir)', $tahun, false);

        if ($rt !== '') {
            $query->where('PendudukDesa.RT', $rt);
        }

        return $query->countAllResults();
    }

    private function countKematian(string $idDesa, int $bulan, int $tahun, string $rt = ''): int
    {
        $query = $this->kematianModel
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Kematian.nik AND PendudukDesa.id_desa = Kematian.id_desa',
                'left'
            )
            ->where('Kematian.id_desa', $idDesa)
            ->where('MONTH(Kematian.tgl_kematian)', $bulan, false)
            ->where('YEAR(Kematian.tgl_kematian)', $tahun, false);

        if ($rt !== '') {
            $query->where('PendudukDesa.RT', $rt);
        }

        return $query->countAllResults();
    }

    private function getDataKelahiran(string $idDesa, int $bulan, int $tahun, string $rt = ''): array
    {
        $query = $this->kelahiranModel
            ->select('Kelahiran.*, PendudukDesa.nama AS nama_ibu, PendudukDesa.RT')
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Kelahiran.nik_ibu AND PendudukDesa.id_desa = Kelahiran.id_desa',
                'left'
            )
            ->where('Kelahiran.id_desa', $idDesa)
            ->where('MONTH(Kelahiran.tgl_lahir)', $bulan, false)
            ->where('YEAR(Kelahiran.tgl_lahir)', $tahun, false);

        if ($rt !== '') {
            $query->where('PendudukDesa.RT', $rt);
        }

        return $query
            ->orderBy('Kelahiran.tgl_lahir', 'ASC')
            ->findAll();
    }

    private function getDataKematian(string $idDesa, int $bulan, int $tahun, string $rt = ''): array
    {
        $query = $this->kematianModel
            ->select('Kematian.*, PendudukDesa.RT')
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Kematian.nik AND PendudukDesa.id_desa = Kematian.id_desa',
                'left'
            )
            ->where('Kematian.id_desa', $idDesa)
            ->where('MONTH(Kematian.tgl_kematian)', $bulan, false)
            ->where('YEAR(Kematian.tgl_kematian)', $tahun, false);

        if ($rt !== '') {
            $query->where('PendudukDesa.RT', $rt);
        }

        return $query
            ->orderBy('Kematian.tgl_kematian', 'ASC')
            ->findAll();
    }

    private function getLansiaData(string $idDesa, string $rt = ''): array
    {
        $query = $this->lansiaModel
            ->select('Lansia.*, PendudukDesa.RT')
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Lansia.nik AND PendudukDesa.id_desa = Lansia.id_desa',
                'left'
            )
            ->where('Lansia.id_desa', $idDesa);

        if ($rt !== '') {
            $query->where('PendudukDesa.RT', $rt);
        }

        return $query
            ->orderBy('Lansia.nama_lansia', 'ASC')
            ->findAll();
    }

    private function getRekapRt(string $idDesa, string $rt = ''): array
    {
        $query = $this->pendudukModel
            ->select("
                RT,
                SUM(CASE WHEN jenis_kelamin = 'L' THEN 1 ELSE 0 END) AS laki_laki,
                SUM(CASE WHEN jenis_kelamin = 'P' THEN 1 ELSE 0 END) AS perempuan,
                COUNT(*) AS total
            ", false)
            ->where('id_desa', $idDesa);

        if ($rt !== '') {
            $query->where('RT', $rt);
        }

        return $query
            ->groupBy('RT')
            ->orderBy('RT', 'ASC')
            ->findAll();
    }

    private function countStatusLansia(array $data, string $target): int
    {
        $count = 0;

        foreach ($data as $row) {
            $status = strtolower(trim((string) ($row['produktifitas'] ?? '')));
            $status = str_replace(['_', ' '], '-', $status);

            if ($target === 'produktif' && $status === 'produktif') {
                $count++;
            }

            if ($target === 'non-produktif' && ($status === 'non-produktif' || $status === 'nonproduktif')) {
                $count++;
            }
        }

        return $count;
    }

    private function getNamaBulan(int $bulan): string
    {
        $list = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $list[$bulan] ?? '-';
    }

    private function getNamaDesaAktif(?string $idDesa = null): string
    {
        try {
            $db = \Config\Database::connect();

            $nameColumns = [
                'wilayah',
                'nama_wilayah',
                'nama_desa',
                'desa',
                'nama_kelurahan',
                'kelurahan',
                'desa_kelurahan',
                'domisili',
                'domisili_desa',
                'nama_domisili',
            ];

            foreach ($db->listTables() as $table) {
                if (!$db->fieldExists('id_desa', $table)) {
                    continue;
                }

                $row = $db->table($table)
                    ->where('id_desa', $idDesa)
                    ->get()
                    ->getRowArray();

                if (!$row) {
                    continue;
                }

                foreach ($nameColumns as $column) {
                    if (!array_key_exists($column, $row)) {
                        continue;
                    }

                    $value = $this->bersihkanNamaDesa((string) $row[$column]);

                    if ($this->isNamaDesaValid($value)) {
                        return $value;
                    }
                }
            }
        } catch (\Throwable $e) {
            // Biarkan kosong jika gagal membaca nama desa.
        }

        return '';
    }

    private function bersihkanNamaDesa(string $value): string
    {
        $value = trim($value);

        $value = preg_replace('/ID\s*Desa\s*:.*$/i', '', $value);
        $value = preg_replace('/\bDESA[0-9]+\b/i', '', $value);
        $value = preg_replace('/^desa\s+/i', '', $value);

        return trim((string) $value);
    }

    private function isNamaDesaValid(string $value): bool
    {
        if ($value === '') {
            return false;
        }

        if (preg_match('/^DESA[0-9]+$/i', $value)) {
            return false;
        }

        if (preg_match('/^[0-9]+$/', $value)) {
            return false;
        }

        return true;
    }

    private function soapSuccess(string $method, array $data)
    {
        $responseName = $method . 'Response';

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">';
        $xml .= '<soapenv:Body>';
        $xml .= '<' . $responseName . '>';
        $xml .= '<status>true</status>';
        $xml .= '<message>Data SOAP berhasil diambil.</message>';
        $xml .= '<data>';
        $xml .= $this->arrayToXml($data);
        $xml .= '</data>';
        $xml .= '</' . $responseName . '>';
        $xml .= '</soapenv:Body>';
        $xml .= '</soapenv:Envelope>';

        return $this->response
            ->setStatusCode(200)
            ->setContentType('text/xml')
            ->setBody($xml);
    }

    private function soapFault(string $code, string $message)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">';
        $xml .= '<soapenv:Body>';
        $xml .= '<soapenv:Fault>';
        $xml .= '<faultcode>' . $this->escapeXml($code) . '</faultcode>';
        $xml .= '<faultstring>' . $this->escapeXml($message) . '</faultstring>';
        $xml .= '</soapenv:Fault>';
        $xml .= '</soapenv:Body>';
        $xml .= '</soapenv:Envelope>';

        return $this->response
            ->setStatusCode(400)
            ->setContentType('text/xml')
            ->setBody($xml);
    }

    private function arrayToXml($data): string
    {
        $xml = '';

        foreach ($data as $key => $value) {
            $tag = is_numeric($key) ? 'item' : $this->safeTagName((string) $key);

            if (is_array($value)) {
                $xml .= '<' . $tag . '>';
                $xml .= $this->arrayToXml($value);
                $xml .= '</' . $tag . '>';
            } else {
                $xml .= '<' . $tag . '>';
                $xml .= $this->escapeXml((string) $value);
                $xml .= '</' . $tag . '>';
            }
        }

        return $xml;
    }

    private function safeTagName(string $tag): string
    {
        $tag = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $tag);

        if ($tag === '' || is_numeric(substr($tag, 0, 1))) {
            $tag = 'field_' . $tag;
        }

        return $tag;
    }

    private function escapeXml(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }
}