<?php

namespace Modules\Core\Traits;

use Modules\Core\Support\Helper;
use Illuminate\Support\Facades\File;

trait LoadDataTrait
{
  protected function loadHelpers(): static
    {
        Helper::autoload($this->getPath('Helpers'));
        
        return $this;
    }

     protected function loadAndPublishConfigurations(array|string $fileNames): static
    {
        if (!is_array($fileNames)) {
            $fileNames = [$fileNames];
        }

        foreach ($fileNames as $fileName) {
            $configFilePath = $this->getConfigFilePath($fileName);
 
            if (File::exists($configFilePath)) {
       
                $this->mergeConfigFrom($configFilePath, $this->getDottedNamespace() . '.' . $fileName);

                if ($this->app->runningInConsole()) {

                    $this->publishes([
                        $configFilePath => config_path($this->getDashedNamespace() . '/' . $fileName . '.php'),
                    ], 'stodio-config');
                }
            }
        }

        return $this;
    }

    protected function publishAssets(?string $path = null): static
    {
        $assetsPath = $this->getAssetsPath();

        if(is_dir($assetsPath)){
            if (empty($path)) {
                 $path = 'vendor/core/' . strtolower($this->getDashedNamespace());
               }

           $this->publishes([$assetsPath => public_path($path)], 'stodio-assets');
        }
        return $this;
    }

     protected function getAssetsPath(): string
     {
        return $this->getPath('public');
     }

    protected function getPath(?string $path = null): string
    {
        $modulePath = base_path('Modules/' . $this->getModuleName());

        return $modulePath . ($path ? '/' . ltrim($path, '/') : '');
    }

    /**
     * Extracts StudlyCase module name from the namespace.
     */
    protected function getModuleName(): string
    {
        $parts = explode('\\', static::class);
        return $parts[1] ?? '';
    }
    protected function getConfigFilePath(string $fileName): string
    {
        return $this->getPath('Config/' . $fileName . '.php');
    }

    /**
     * Returns a lowercase dotted namespace.
     */
    protected function getDottedNamespace(): string
    {
        return strtolower($this->getModuleName());
    }
    protected function getDashedNamespace(): string
    {
        return $this->getModuleName();
    }

}