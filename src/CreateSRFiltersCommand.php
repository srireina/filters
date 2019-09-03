<?php

namespace Srireina\Filters;

use Illuminate\Console\Command;

class CreateSRFiltersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:srfilters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Default Creation of Folder structure for filters';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		if (!file_exists('app/filters')) {
			mkdir('app/Filters', 0755, true);
		}
		
		$qfData = '<?php
namespace App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
class QueryFilters
{
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->filters() as $name => $value) {
            if ( ! method_exists($this, $name)) {
                continue;
            }
            if (strlen($value)) {
                $this->$name($value);
            } else {
                $this->$name();
            }
        }
        return $this->builder;
    }

    public function filters()
    {
        return $this->request->all();
    }
}
';

		$traitData = '<?php
namespace App\Filters;
use Illuminate\Database\Eloquent\Builder;
trait Filterable
{
    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}
';
		
        file_put_contents("app/Filters/QueryFilters.php",$qfData);
		file_put_contents("app/Filters/Filterable.php",$traitData);
    }
}
