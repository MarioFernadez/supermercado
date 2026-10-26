<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Sale;
use App\Services\SifenService;

class SifenManager extends Component
{
    use WithFileUploads;

    public $sifen_master_enabled;
    public $sifen_enabled;
    public $sifen_environment;
    public $sifen_timbrado;
    public $sifen_timbrado_fecha_inicio;
    public $sifen_establecimiento;
    public $sifen_punto_expedicion;
    public $sifen_serie;
    public $sifen_ultimo_numero;

    public $sifen_emisor_ruc;
    public $sifen_emisor_dv;
    public $sifen_emisor_tipo_contribuyente;
    public $sifen_emisor_razon_social;
    public $sifen_emisor_nombre_fantasia;
    public $sifen_emisor_direccion;
    public $sifen_emisor_numero_casa;
    public $sifen_emisor_departamento;
    public $sifen_emisor_departamento_desc;
    public $sifen_emisor_distrito;
    public $sifen_emisor_distrito_desc;
    public $sifen_emisor_ciudad;
    public $sifen_emisor_ciudad_desc;
    public $sifen_emisor_telefono;
    public $sifen_emisor_email;
    public $sifen_emisor_actividad_codigo;
    public $sifen_emisor_actividad_desc;

    public $sifen_id_csc;
    public $sifen_csc;
    public $sifen_auto_print_kude;

    // Gestión de Certificado Digital y Producción
    public $certFile;
    public $certPasswordInput = '';
    public $certInfo = null;
    public $productionReadiness = [];

    public $activeTab = 'status';
    public $connectionTestResult = null;
    public $testDocument = null;
    public $showXmlModal = false;
    public $selectedSaleXml = null;

    public function mount()
    {
        abort_unless(auth()->user()->isDeveloper(), 403);
        $this->loadCurrentSettings();
        $this->testDocument = SifenService::generateTestDocument();
    }

    public function loadCurrentSettings()
    {
        $settings = SifenService::getSettings();
        $this->sifen_master_enabled            = SifenService::isMasterEnabled();
        $this->sifen_enabled                   = $settings['sifen_enabled'];
        $this->sifen_environment               = $settings['sifen_environment'];
        $this->sifen_timbrado                  = $settings['sifen_timbrado'];
        $this->sifen_timbrado_fecha_inicio     = $settings['sifen_timbrado_fecha_inicio'];
        $this->sifen_establecimiento           = $settings['sifen_establecimiento'];
        $this->sifen_punto_expedicion          = $settings['sifen_punto_expedicion'];
        $this->sifen_serie                     = $settings['sifen_serie'];
        $this->sifen_ultimo_numero             = $settings['sifen_ultimo_numero'];
        $this->sifen_emisor_ruc                = $settings['sifen_emisor_ruc'];
        $this->sifen_emisor_dv                 = $settings['sifen_emisor_dv'];
        $this->sifen_emisor_tipo_contribuyente = $settings['sifen_emisor_tipo_contribuyente'];
        $this->sifen_emisor_razon_social       = $settings['sifen_emisor_razon_social'];
        $this->sifen_emisor_nombre_fantasia    = $settings['sifen_emisor_nombre_fantasia'];
        $this->sifen_emisor_direccion          = $settings['sifen_emisor_direccion'];
        $this->sifen_emisor_numero_casa        = $settings['sifen_emisor_numero_casa'];
        $this->sifen_emisor_departamento       = $settings['sifen_emisor_departamento'];
        $this->sifen_emisor_departamento_desc  = $settings['sifen_emisor_departamento_desc'];
        $this->sifen_emisor_distrito           = $settings['sifen_emisor_distrito'];
        $this->sifen_emisor_distrito_desc      = $settings['sifen_emisor_distrito_desc'];
        $this->sifen_emisor_ciudad             = $settings['sifen_emisor_ciudad'];
        $this->sifen_emisor_ciudad_desc        = $settings['sifen_emisor_ciudad_desc'];
        $this->sifen_emisor_telefono           = $settings['sifen_emisor_telefono'];
        $this->sifen_emisor_email              = $settings['sifen_emisor_email'];
        $this->sifen_emisor_actividad_codigo   = $settings['sifen_emisor_actividad_codigo'];
        $this->sifen_emisor_actividad_desc     = $settings['sifen_emisor_actividad_desc'];
        $this->sifen_id_csc                    = $settings['sifen_id_csc'];
        $this->sifen_csc                       = $settings['sifen_csc'];
        $this->sifen_auto_print_kude           = $settings['sifen_auto_print_kude'];

        $this->certInfo = SifenService::getCertificateInfo();
        $this->productionReadiness = SifenService::getProductionReadiness();
    }

    public function toggleMasterLicense()
    {
        abort_unless(auth()->user()->isDeveloper(), 403);
        $this->sifen_master_enabled = !$this->sifen_master_enabled;
        SifenService::saveSettings(['sifen_master_enabled' => $this->sifen_master_enabled ? '1' : '0']);
        session()->flash('message', 'Módulo de Facturación Electrónica para Clientes ' . ($this->sifen_master_enabled ? 'ACTIVADO / AUTORIZADO' : 'DESACTIVADO / BLOQUEADO') . ' por Master.');
    }

    public function toggleSifen()
    {
        abort_unless(auth()->user()->isDeveloper(), 403);
        $this->sifen_enabled = !$this->sifen_enabled;
        SifenService::saveSettings(['sifen_enabled' => $this->sifen_enabled ? '1' : '0']);
        $this->productionReadiness = SifenService::getProductionReadiness();
        session()->flash('message', 'Facturación Electrónica en POS ' . ($this->sifen_enabled ? 'ACTIVADA' : 'DESACTIVADA') . ' exitosamente.');
    }

    public function setEnvironment(string $env)
    {
        abort_unless(auth()->user()->isDeveloper(), 403);
        $this->sifen_environment = $env;
        SifenService::saveSettings(['sifen_environment' => $env]);
        $this->productionReadiness = SifenService::getProductionReadiness();
        session()->flash('message', 'Ambiente SIFEN actualizado a: ' . strtoupper($env));
    }

    public function loadTestData()
    {
        abort_unless(auth()->user()->isDeveloper(), 403);
        SifenService::loadDefaultTestData();
        $this->loadCurrentSettings();
        $this->testDocument = SifenService::generateTestDocument();
        session()->flash('message', '¡Datos oficiales de prueba DNIT (MT v150) cargados exitosamente!');
    }

    public function clearTestData()
    {
        abort_unless(auth()->user()->isDeveloper(), 403);
        SifenService::clearTestData();
        $this->loadCurrentSettings();
        $this->testDocument = null;
        session()->flash('message', 'Datos de prueba limpiados. Campos en blanco listos para registrar los datos reales del cliente.');
    }

    public function testConnection()
    {
        abort_unless(auth()->user()->isDeveloper(), 403);
        $this->connectionTestResult = SifenService::testConnection();
    }

    public function generateNewTestDoc()
    {
        abort_unless(auth()->user()->isDeveloper(), 403);
        $this->testDocument = SifenService::generateTestDocument();
        session()->flash('test_message', 'Comprobante y Código QR de prueba regenerados con éxito.');
    }

    /**
     * Sube y valida el certificado digital PKCS#12 (.p12/.pfx) ingresado por el usuario.
     */
    public function uploadCertificate()
    {
        abort_unless(auth()->user()->isDeveloper(), 403);

        $this->validate([
            'certFile'          => 'required|file|max:10240', // max 10MB
            'certPasswordInput' => 'required|string',
        ], [
            'certFile.required'          => 'Debes seleccionar el archivo .p12 o .pfx de tu certificado.',
            'certFile.max'               => 'El archivo de certificado no debe pesar más de 10MB.',
            'certPasswordInput.required' => 'Ingresa la contraseña del certificado digital para su desencriptación.',
        ]);

        $realPath = $this->certFile->getRealPath();
        $result = SifenService::installCertificate($realPath, $this->certPasswordInput);

        if (!$result['success']) {
            $this->addError('certPasswordInput', $result['error']);
            return;
        }

        $this->certFile = null;
        $this->certPasswordInput = '';
        $this->loadCurrentSettings();

        session()->flash('message', '¡Certificado Digital instalado y verificado exitosamente!');
    }

    /**
     * Elimina el certificado digital instalado.
     */
    public function deleteCertificate()
    {
        abort_unless(auth()->user()->isDeveloper(), 403);
        SifenService::removeCertificate();
        $this->loadCurrentSettings();
        session()->flash('message', 'Certificado Digital eliminado del sistema.');
    }

    /**
     * Cambia de ambiente a Producción tras confirmar requisitos.
     */
    public function enableProductionMode()
    {
        abort_unless(auth()->user()->isDeveloper(), 403);

        $this->sifen_environment = 'production';
        SifenService::saveSettings(['sifen_environment' => 'production']);
        $this->loadCurrentSettings();
        session()->flash('message', '¡MODO PRODUCCIÓN ACTIVADO! Los comprobantes generados tendrán validez fiscal ante la DNIT.');
    }

    public function viewXml(string $xmlContent)
    {
        $this->selectedSaleXml = $xmlContent;
        $this->showXmlModal = true;
    }

    public function closeXmlModal()
    {
        $this->showXmlModal = false;
        $this->selectedSaleXml = null;
    }

    public function saveSettings()
    {
        abort_unless(auth()->user()->isDeveloper(), 403);

        $this->validate([
            'sifen_timbrado'              => 'required|digits_between:6,8',
            'sifen_timbrado_fecha_inicio' => 'required|date',
            'sifen_establecimiento'       => 'required|digits:3',
            'sifen_punto_expedicion'      => 'required|digits:3',
            'sifen_serie'                 => 'required|string|size:2',
            'sifen_emisor_ruc'            => 'required|string|max:10',
            'sifen_emisor_dv'             => 'required|digits:1',
            'sifen_emisor_razon_social'   => 'required|string|max:255',
            'sifen_id_csc'                => 'required|digits:4',
            'sifen_csc'                   => 'required|string|size:32',
        ]);

        SifenService::saveSettings([
            'sifen_enabled'                  => $this->sifen_enabled ? '1' : '0',
            'sifen_environment'              => $this->sifen_environment,
            'sifen_timbrado'                 => $this->sifen_timbrado,
            'sifen_timbrado_fecha_inicio'    => $this->sifen_timbrado_fecha_inicio,
            'sifen_establecimiento'          => $this->sifen_establecimiento,
            'sifen_punto_expedicion'         => $this->sifen_punto_expedicion,
            'sifen_serie'                    => strtoupper($this->sifen_serie),
            'sifen_ultimo_numero'            => (int) $this->sifen_ultimo_numero,
            'sifen_emisor_ruc'               => $this->sifen_emisor_ruc,
            'sifen_emisor_dv'                => $this->sifen_emisor_dv,
            'sifen_emisor_tipo_contribuyente'=> $this->sifen_emisor_tipo_contribuyente,
            'sifen_emisor_razon_social'      => $this->sifen_emisor_razon_social,
            'sifen_emisor_nombre_fantasia'   => $this->sifen_emisor_nombre_fantasia,
            'sifen_emisor_direccion'         => $this->sifen_emisor_direccion,
            'sifen_emisor_numero_casa'       => $this->sifen_emisor_numero_casa,
            'sifen_emisor_departamento'      => $this->sifen_emisor_departamento,
            'sifen_emisor_departamento_desc' => $this->sifen_emisor_departamento_desc,
            'sifen_emisor_distrito'          => $this->sifen_emisor_distrito,
            'sifen_emisor_distrito_desc'     => $this->sifen_emisor_distrito_desc,
            'sifen_emisor_ciudad'            => $this->sifen_emisor_ciudad,
            'sifen_emisor_ciudad_desc'       => $this->sifen_emisor_ciudad_desc,
            'sifen_emisor_telefono'          => $this->sifen_emisor_telefono,
            'sifen_emisor_email'             => $this->sifen_emisor_email,
            'sifen_emisor_actividad_codigo'  => $this->sifen_emisor_actividad_codigo,
            'sifen_emisor_actividad_desc'    => $this->sifen_emisor_actividad_desc,
            'sifen_id_csc'                   => $this->sifen_id_csc,
            'sifen_csc'                      => $this->sifen_csc,
            'sifen_auto_print_kude'          => $this->sifen_auto_print_kude ? '1' : '0',
        ]);

        $this->loadCurrentSettings();
        $this->testDocument = SifenService::generateTestDocument();
        session()->flash('message', 'Parámetros de Facturación Electrónica guardados correctamente.');
    }

    public function render()
    {
        $electronicSales = Sale::whereNotNull('sifen_cdc')
            ->with(['customer', 'user', 'items'])
            ->latest()
            ->paginate(15);

        $totalElectronicCount = Sale::whereNotNull('sifen_cdc')->count();
        $totalTestCount = Sale::where('sifen_estado', 'aprobado_test')->count();

        return view('livewire.admin.sifen-manager', [
            'electronicSales'      => $electronicSales,
            'totalElectronicCount' => $totalElectronicCount,
            'totalTestCount'       => $totalTestCount,
        ])->layout('layouts.app');
    }
}
