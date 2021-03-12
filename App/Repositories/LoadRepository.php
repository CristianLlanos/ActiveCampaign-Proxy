<?php

namespace App\Repositories;

class LoadRepository
{
	public function get()
	{
		return require $this->file();
	}

	public function save(array $hosts)
	{
		$data = var_export($hosts, true);

		$content = <<<PHP
<?php return $data;
PHP;


		file_put_contents($this->file(), $content);
	}

	private function file(): string
	{
		return __DIR__ . DIRECTORY_SEPARATOR . '..'
			. DIRECTORY_SEPARATOR . '..'
			. DIRECTORY_SEPARATOR . 'database'
			. DIRECTORY_SEPARATOR . 'load.php';
	}
}