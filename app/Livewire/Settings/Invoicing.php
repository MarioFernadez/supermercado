<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Sale;
use App\Services\SifenService;

class Invoicing extends Component
{
    use WithFileUploads;

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
    public $sifen_emisor_ciudad_desc;
    public $sifen_emisor_telefono;
    public $sifen_emisor_email;
    public $sifen_emisor_actividad_codigo;
    public $sifen_emisor_actividad_desc;

    public $sifen_id_csc;
    public $sifen_csc;

    // Certificado
    public $certFile;
    public $certPasswordInput = '';
    public $certInfo = null;

    public $isMasterEnabled = true;

    public function mount()
    {
        abort_unless(
            auth()->user()->isAdmin() || 
            auth()->user()->isManager() || 
            auth()->user()->isDeveloper(), 
            403
        );

        $this->isMasterEnabled = SifenService::isMasterEnabled();
        $this->loadCurrentSettings();
    }

    public function loadCurrentSettings()
    {
        $settings = SifenService::getSettings();
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
        $this->sifen_emisor_ciudad_desc        = $settings['sifen_emisor_ciudad_desc'];
        $this->sifen_emisor_telefono           = $settings['sifen_emisor_telefono'];
        $this->sifen_emisor_email              = $settings['sifen_emisor_email'];
        $this->sifen_emisor_actividad_codigo   = $settings['sifen_emisor_actividad_codigo'];
        $this->sifen_emisor_actividad_desc     = $settings['sifen_emisor_actividad_desc'];
        $this->sifen_id_csc                    = $settings['sifen_id_csc'];
        $this->sifen_csc                       = $settings['sifen_csc'];

        $this->certInfo = SifenService::getCertificateInfo();
    }

    public function toggleSifen()
    {
        $this->sifen_enabled = !$this->sifen_enabled;
        SifenService::saveSettings(['sifen_enabled' => $this->sifen_enabled ? '1' : '0']);
        session()->flash('message', 'Facturación Electrónica ' . ($this->sifen_enabled ? 'ACTIVADA' : 'DESACTIVADA') . ' en el POS.');
    }

    public function setEnvironment(string $env)
    {
        $this->sifen_environment = $env;
        SifenService::saveSettings(['sifen_environment' => $env]);
        session()->flash('message', 'Modo cambiado a: ' . ($env === 'production' ? 'PRODUCCIÓN OFICIAL' : 'PRUEBAS (TEST)'));
    }

    public function loadTestData()
    {
        SifenService::loadDefaultTestData();
        $this->loadCurrentSettings();
        session()->flash('message', '¡Datos oficiales de prueba DNIT cargados exitosamente! Ya puedes emitir tickets de prueba.');
    }

    public function clearTestData()
    {
        SifenService::clearTestData();
        $this->loadCurrentSettings();
        session()->flash('message', 'Formulario limpiado. Ya puedes ingresar los datos oficiales de tu empresa.');
    }

    public function uploadCertificate()
    {
        $this->validate([
            'certFile'          => 'required|file|max:10240',
            'certPasswordInput' => 'required|string',
        ], [
            'certFile.required'          => 'Debes seleccionar el archivo .p12 o .pfx de tu certificado digital.',
            'certPasswordInput.required' => 'Ingresa la contraseña del certificado para instalarlo.',
        ]);

        $realPath = $this->certFile->getRealPath();
        $result = SifenService::installCertificate($realPath, $this->certPasswordInput);

        if (!$result['success']) {
            $this->addError('certPasswordInput', $result['error']);
            return;
        }

        $this->certFile = null;
        $this->certPasswordInput = '';
        $this->certInfo = SifenService::getCertificateInfo();
        session()->flash('message', '¡Certificado Digital instalado y verificado exitosamente!');
    }

    public function deleteCertificate()
    {
        SifenService::removeCertificate();
        $this->certInfo = null;
        session()->flash('message', 'Certificado Digital eliminado.');
    }

    public function saveSettings()
    {
        $this->validate([
            'sifen_timbrado'            => 'required|string',
            'sifen_establecimiento'     => 'required|string|size:3',
            'sifen_punto_expedicion'    => 'required|string|size:3',
            'sifen_emisor_ruc'          => 'required|string',
            'sifen_emisor_dv'           => 'required|string|size:1',
            'sifen_emisor_razon_social' => 'required|string',
        ], [
            'sifen_timbrado.required'            => 'El número de Timbrado es obligatorio.',
            'sifen_establecimiento.required'     => 'El código de Establecimiento debe tener 3 dígitos (ej: 001).',
            'sifen_punto_expedicion.required'    => 'El Punto de Expedición debe tener 3 dígitos (ej: 001).',
            'sifen_emisor_ruc.required'          => 'El RUC del emisor es obligatorio.',
            'sifen_emisor_dv.required'           => 'El Dígito Verificador (DV) es obligatorio.',
            'sifen_emisor_razon_social.required' => 'La Razón Social es obligatoria.',
        ]);

        SifenService::saveSettings([
            'sifen_enabled'                  => $this->sifen_enabled ? '1' : '0',
            'sifen_environment'              => $this->sifen_environment,
            'sifen_timbrado'                 => $this->sifen_timbrado,
            'sifen_timbrado_fecha_inicio'    => $this->sifen_timbrado_fecha_inicio,
            'sifen_establecimiento'          => $this->sifen_establecimiento,
            'sifen_punto_expedicion'         => $this->sifen_punto_expedicion,
            'sifen_serie'                    => strtoupper($this->sifen_serie ?: 'AA'),
            'sifen_emisor_ruc'               => $this->sifen_emisor_ruc,
            'sifen_emisor_dv'                => $this->sifen_emisor_dv,
            'sifen_emisor_tipo_contribuyente'=> $this->sifen_emisor_tipo_contribuyente,
            'sifen_emisor_razon_social'      => $this->sifen_emisor_razon_social,
            'sifen_emisor_nombre_fantasia'   => $this->sifen_emisor_nombre_fantasia,
            'sifen_emisor_direccion'         => $this->sifen_emisor_direccion,
            'sifen_emisor_ciudad_desc'       => $this->sifen_emisor_ciudad_desc,
            'sifen_emisor_telefono'          => $this->sifen_emisor_telefono,
            'sifen_emisor_email'             => $this->sifen_emisor_email,
            'sifen_emisor_actividad_codigo'  => $this->sifen_emisor_actividad_codigo ?: '47111',
            'sifen_emisor_actividad_desc'    => $this->sifen_emisor_actividad_desc ?: 'Comercio al por menor',
            'sifen_id_csc'                   => $this->sifen_id_csc ?: '0001',
            'sifen_csc'                      => $this->sifen_csc,
        ]);

        $this->loadCurrentSettings();
        session()->flash('message', '¡Datos guardados correctamente!');
    }

    public function render()
    {
        return view('livewire.settings.invoicing')->layout('layouts.app');
    }
}
