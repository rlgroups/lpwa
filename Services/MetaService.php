<?php


namespace LaravelMPWA\Services;


class MetaService
{
    public function render($name = '')
    {
        $config = (new \LaravelMPWA\Services\ManifestService)->generate($name);

        return "<?php \ echo $__env->make('laravelmultipwa::meta' , ['config' => \$config])->render(); \ ?>";
    }

}
