<?php

namespace App\Repositories;

class WorkerRepository
{
	public function get(): string
	{
		return require $this->file();
	}

	public function save(string $worker)
	{		$data = var_export($worker, true);

		$content = <<<PHP
<?php return $data;
PHP;

		file_put_contents($this->file(), $content);
	}

	private function file(): string
	{
		return __DIR__
			. DIRECTORY_SEPARATOR . '..'
			. DIRECTORY_SEPARATOR . '..'
			. DIRECTORY_SEPARATOR . 'database'
			. DIRECTORY_SEPARATOR . 'worker.php';
	}
}