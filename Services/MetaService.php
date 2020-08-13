<?php


namespace LaravelMPWA\Services;


class MetaService
{
    public function render($name = 'app')
    {
        return "<?php \$config = (new \LaravelMPWA\Services\ManifestService)->generate('$name'); echo \$__env->make( 'laravelmultipwa::meta' , ['config' => \$config, 'name' => '$name'])->render(); ?>";
    }

}
