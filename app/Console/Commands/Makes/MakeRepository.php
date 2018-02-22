<?php

namespace App\Console\Commands\Makes;

use Illuminate\Console\GeneratorCommand;

class MakeRepository extends GeneratorCommand
{
    /** @var string */
    protected $name = 'app:make:repository';
    /** @var string */
    protected $description = 'リポジトリーファイルを生成';
    protected $type = 'Repository';
    public function handle()
    {
        $name = $this->qualifyClass($this->getNameInput());
        $paths = $this->getPaths();
        foreach ($paths as $key => $path) {
            if ($this->alreadyRepositoryExists($key, $this->getNameInput())) {
                $this->error($this->type . ' ' . ucfirst($key) . ' already exists!');
                continue;
            }
            $this->makeDirectory($path);
            /** @noinspection PhpUnhandledExceptionInspection */
            $this->files->put($path, $this->buildRepository($key, $name));
            $this->info($this->type . ' ' . ucfirst($key) . ' created successfully.');
        }
    }
    /**
     * @return string|void
     */
    protected function getStub()
    {
        // 親クラスのabstract method
    }
    /**
     * @return array
     */
    protected function getStubs()
    {
        return [
            'interface' => __DIR__ . '/stubs/repository.stub',
            'eloquent'  => __DIR__ . '/stubs/eloquent_repository.stub',
        ];
    }
    /**
     * @return array
     */
    protected function getPaths()
    {
        $name = str_replace(
            ['\\', '/'], '', $this->getNameInput()
        );
        return [
            'interface' => app_path() . "/Repositories/{$name}.php",
            'eloquent'  => app_path() . "/Infrastructure/Repositories/Eloquent{$name}.php",
        ];
    }
    /**
     * @param $type
     * @param $name
     * @return mixed|string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildRepository($type, $name)
    {
        $stubs = $this->getStubs();
        /** @noinspection PhpUnhandledExceptionInspection */
        $stub = $this->files->get($stubs[$type]);
        $stub = $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
        $stub = $this->replaceModel($stub, $name);
        $stub = $this->replaceVariable($stub, $name);
        return $stub;
    }
    /**
     * @param $stub
     * @param $name
     * @return mixed
     */
    protected function replaceModel($stub, $name)
    {
        $model = str_replace([$this->getNamespace($name) . '\\', 'Repository'], '', $name);
        return str_replace('DummyModel', $model, $stub);
    }
    /**
     * @param $stub
     * @param $name
     * @return mixed
     */
    protected function replaceVariable($stub, $name)
    {
        $model = str_replace([$this->getNamespace($name) . '\\', 'Repository'], '', $name);
        $variable = strtolower($model);
        return str_replace('DummyVariable', $variable, $stub);
    }
    /**
     * @param $type
     * @param $input_name
     * @return bool
     */
    protected function alreadyRepositoryExists($type, $input_name)
    {
        if ($type === 'interface') {
            $class_name = '/Repositories/' . $input_name;
        } else {
            if ($type === 'eloquent') {
                $class_name = "/Infrastructure/Repositories/Eloquent{$input_name}";
            } else {
                throw new \InvalidArgumentException('type is not valid.');
            }
        }
        return $this->files->exists($this->getPath($this->qualifyClass($class_name)));
    }
}
