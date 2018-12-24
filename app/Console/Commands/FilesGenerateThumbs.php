<?php

namespace App\Console\Commands;

use App\Repositories\FileRepository;
use Illuminate\Console\Command;
use ReflectionClass;

class FilesGenerateThumbs extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'files:generate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate file thumbs by type and size';
	/**
	 * @var FileRepository
	 */
	private $fileRepository;

	/**
	 * Create a new command instance.
	 *
	 * @param FileRepository $fileRepository
	 */
	public function __construct(FileRepository $fileRepository)
	{
		parent::__construct();
		$this->fileRepository = $fileRepository;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		//get all file types from config
		$types = config('files.dir');
		ksort($types); //sort by type key 1,2,3 etc.

		$flippedTypes = array_flip($types);

		$typeSelected = $this->choice('What type of image would you like to regenerate?', $flippedTypes);

		$type = $flippedTypes[$typeSelected]; //get key from file type name

		$sizesOfSelectedType = [];
		try {
			$sizesOfSelectedType = FileRepository::getSizes($type);

		} catch(\Exception $e) {
			$this->error('No sizes for this type of file');
		}

		if($sizesOfSelectedType) { //if appropriate file type was chosen
			$sizesToShow = [];
			$sizeKeys = array_keys($sizesOfSelectedType);

			//generate table with information about image sizes
			foreach($sizesOfSelectedType as $key=>$val) {
				$sizesToShow[] = [
					'size' => $key,
					'type' => $val['type'],
					'width' => isset($val['width']) ? $val['width'] : 'auto',
					'height' => isset($val['height']) ? $val['height'] : 'auto',
					'format' => isset($val['format']) ? $val['format'] : 'auto',
					'quality' => isset($val['quality']) ? $val['quality'] : 'auto'
				];
			}

			//show info table
			$this->table(['Size', 'Type', 'Width', 'Height', 'Format', 'Quality'], $sizesToShow);

			$size = $this->choice('What size would you like to generate?', $sizeKeys);

			//get active(without trash) images
			$files = $this->fileRepository->getActiveImages($type, ['id', 'type', 'token', 'ext', 'isImage']);

			//confirm script executing
			$proceedGenerating = $this->confirm('There are ' . count($files) . ' files. Would you like to proceed?', true);

			if(! $proceedGenerating) {
				$this->info('Operation was cancelled!');
				return;
			}

			//show progress bar with status information
			$bar = $this->output->createProgressBar(count($files));

			foreach($files as $file) {
				$this->fileRepository->regenerateFileThumbs($file, $size);
				$bar->advance();
			}

			$bar->finish();

			$this->info(PHP_EOL . 'List of files which where regenerated:');

			//show summary report
			$this->table(['ID','File type', 'Token', 'Extension', 'Is Image', ], $files->toArray());
		}
	}
}
