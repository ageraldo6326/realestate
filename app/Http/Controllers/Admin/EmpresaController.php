<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEmpresaRequest;
use App\Http\Requests\Admin\UpdateEmpresaRequest;
use App\Models\Inmobiliaria;
use App\Services\Branding\CompanyBrandingService;
use App\Services\Branding\LogoPaletteExtractor;
use App\Services\InmobiliariaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EmpresaController extends Controller
{
    private CompanyBrandingService $brandingService;

    private LogoPaletteExtractor $logoPaletteExtractor;

    public function __construct(CompanyBrandingService $brandingService, LogoPaletteExtractor $logoPaletteExtractor)
    {
        $this->middleware('auth');
        $this->brandingService = $brandingService;
        $this->logoPaletteExtractor = $logoPaletteExtractor;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inmobiliaria = InmobiliariaService::get();

        if ($inmobiliaria) {
            return view("admin.empresa.edit", compact("inmobiliaria"));
        }

        return view("admin.empresa.create");
    }

    public function edit($id)
    {
        $inmobiliaria = Inmobiliaria::where('id', $id)->first();

        if (!$inmobiliaria) {
            return redirect()->route('inmobiliaria.create');
        }

        return view("admin.empresa.edit", compact("inmobiliaria"));
    }

    public function create()
    {
        $inmobiliaria = InmobiliariaService::get();

        if ($inmobiliaria) {
            return redirect()->route('inmobiliaria.edit', $inmobiliaria->id);
        }

        return view("admin.empresa.create");
    }

    public function store(StoreEmpresaRequest $request): RedirectResponse
    {
        try {
            $inmobiliaria = DB::transaction(function () use ($request): Inmobiliaria {
                $company = InmobiliariaService::get() ?? new Inmobiliaria();

                $this->persistCompany($company, $request->validated(), $request->file('logo'), $request->file('favicon'));
                $company->save();

                return $company;
            });
        } catch (\Throwable $exception) {
            Log::error('No se pudo guardar la configuracion de empresa.', [
                'exception' => $exception,
            ]);

            return back()->withInput()->with('error', 'No fue posible guardar la configuracion de empresa.');
        }

        InmobiliariaService::forget();

        return redirect()->route('inmobiliaria.edit', $inmobiliaria->id)->with('status', 'La configuracion de empresa se guardo correctamente.');
    }

    public function update(UpdateEmpresaRequest $request, $id): RedirectResponse
    {
        $inmobiliaria = Inmobiliaria::where('id', $id)->first();

        if (!$inmobiliaria) {
            return redirect()->route('inmobiliaria.create');
        }

        try {
            DB::transaction(function () use ($inmobiliaria, $request): void {
                $this->persistCompany($inmobiliaria, $request->validated(), $request->file('logo'), $request->file('favicon'));
                $inmobiliaria->save();
            });
        } catch (\Throwable $exception) {
            Log::error('No se pudo actualizar la configuracion de empresa.', [
                'empresa_id' => $id,
                'exception' => $exception,
            ]);

            return back()->withInput()->with('error', 'No fue posible actualizar la configuracion de empresa.');
        }

        InmobiliariaService::forget();

        return redirect()->route('inmobiliaria.edit', $inmobiliaria->id)->with('status', 'La configuracion de empresa se actualizo correctamente.');
    }

    public function restoreDefaultTheme($id): RedirectResponse
    {
        $inmobiliaria = Inmobiliaria::where('id', $id)->first();

        if (!$inmobiliaria) {
            return redirect()->route('inmobiliaria.create');
        }

        try {
            DB::transaction(function () use ($inmobiliaria): void {
                $this->brandingService->restoreDefaultTheme($inmobiliaria);
                $inmobiliaria->save();
            });
        } catch (\Throwable $exception) {
            Log::error('No se pudo restaurar la paleta default de empresa.', [
                'empresa_id' => $id,
                'exception' => $exception,
            ]);

            return redirect()->route('inmobiliaria.edit', $inmobiliaria->id)->with('error', 'No fue posible restaurar la paleta default.');
        }

        InmobiliariaService::forget();

        return redirect()->route('inmobiliaria.edit', $inmobiliaria->id)->with('status', 'Se restauro la paleta default del sistema.');
    }

    public function restorePreviousTheme($id): RedirectResponse
    {
        $inmobiliaria = Inmobiliaria::where('id', $id)->first();

        if (!$inmobiliaria) {
            return redirect()->route('inmobiliaria.create');
        }

        if (!$this->brandingService->hasPreviousTheme($inmobiliaria)) {
            return redirect()->route('inmobiliaria.edit', $inmobiliaria->id)->with('error', 'Aun no existe una version anterior disponible para restaurar.');
        }

        try {
            DB::transaction(function () use ($inmobiliaria): void {
                $this->brandingService->restorePreviousTheme($inmobiliaria);
                $inmobiliaria->save();
            });
        } catch (\Throwable $exception) {
            Log::error('No se pudo restaurar la version anterior del tema de empresa.', [
                'empresa_id' => $id,
                'exception' => $exception,
            ]);

            return redirect()->route('inmobiliaria.edit', $inmobiliaria->id)->with('error', 'No fue posible restaurar la version anterior del tema.');
        }

        InmobiliariaService::forget();

        return redirect()->route('inmobiliaria.edit', $inmobiliaria->id)->with('status', 'Se restauro la version anterior del tema.');
    }

    private function persistCompany(Inmobiliaria $company, array $data, ?UploadedFile $logoFile, ?UploadedFile $faviconFile): void
    {
        $company->nombre = $data['nombre'];
        $company->correo = $data['correo'];
        $company->direccion = $data['direccion'];
        $company->telefono = $data['telefono'];
        $company->titulo = $data['titulo'] ?? null;
        $company->metadescription = $data['metadescription'] ?? null;
        $company->facebook = $data['facebook'] ?? null;
        $company->instagram = $data['instagram'] ?? null;
        $company->tiktok = $data['tiktok'] ?? null;
        $company->whatsapp = $data['whatsapp'] ?? null;
        $company->quienessomos = $data['quienessomos'] ?? null;
        $company->aprobacion = array_key_exists('aprobacion', $data)
            ? (bool) $data['aprobacion']
            : (bool) ($company->exists ? $company->aprobacion : true);

        $this->brandingService->ensureThemeInitialized($company);

        $suggestedPalette = [];

        if ($logoFile) {
            $suggestedPalette = $this->logoPaletteExtractor->extractFromUploadedFile($logoFile);
            $this->brandingService->storeLogoPalette($company, $suggestedPalette);
            $company->theme_last_logo_hash = hash_file('sha256', $logoFile->getRealPath()) ?: null;
            $company->logo = $this->storePublicImage($logoFile, 'logo');
        }

        if ($faviconFile) {
            $company->favicon = $this->storePublicImage($faviconFile, 'favicon');
        }

        $manualTheme = $this->brandingService->getManualThemeInput($data);
        $currentTheme = $this->brandingService->resolveTheme($company);

        if ($manualTheme && $this->brandingService->themeDiffers($manualTheme, $currentTheme)) {
            $this->brandingService->applyTheme($company, $manualTheme, CompanyBrandingService::SOURCE_MANUAL);

            return;
        }

        if ($suggestedPalette !== [] && $this->shouldApplyLogoPalette($data, $company, $manualTheme)) {
            $this->brandingService->applyTheme(
                $company,
                $this->brandingService->buildThemeFromPalette($suggestedPalette),
                CompanyBrandingService::SOURCE_LOGO
            );
        }
    }

    private function shouldApplyLogoPalette(array $data, Inmobiliaria $company, ?array $manualTheme): bool
    {
        if ($manualTheme !== null) {
            return false;
        }

        $behavior = $data['theme_logo_behavior'] ?? 'keep_current';

        if (!$company->exists) {
            return $behavior !== 'keep_current';
        }

        return $behavior === 'apply_logo_palette';
    }

    private function storePublicImage(UploadedFile $file, string $baseName): string
    {
        $directory = public_path('img');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        foreach ([$baseName . '.*', $baseName . '-*.*'] as $pattern) {
            foreach (glob($directory . DIRECTORY_SEPARATOR . $pattern) ?: [] as $existingFile) {
                @unlink($existingFile);
            }
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'png');
        $hash = hash_file('sha256', $file->getRealPath()) ?: (string) microtime(true);
        $filename = $baseName . '-' . substr($hash, 0, 12) . '.' . $extension;
        $path = $directory . DIRECTORY_SEPARATOR . $filename;

        copy($file->getRealPath(), $path);

        return '/img/' . $filename;
    }
}
