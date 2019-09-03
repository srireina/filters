<?php

namespace Srireina\Filters;

use Illuminate\Console\Command;

class NewFiltersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filter {filterName : The name of the filter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Filters Config File';

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
        $dummyContent = '<?php
namespace App\Filters;

use Illuminate\Http\Request;

class '.$this->argument('filterName').' extends QueryFilters {
  protected $request;
  public function __construct(Request $request)
  {
      $this->request = $request;
      parent::__construct($request);
  }
  public function sort($column)
  {
    $parts = explode("-",$column);
    //if($parts[0]==\'franchisee\')
    //  $parts[0] = \'franchisee_id\';  
    if(in_array($parts[0],[\'id\']) && in_array($parts[1],[\'asc\',\'desc\']))
      return $this->builder->orderBy($parts[0],$parts[1]);
    else
      return $this->builder->orderBy(\'id\');
  }
  /*public function franchisee($data)
  {
    $frs = \App\Franchisee::where(\'name\',\'like\',\'%\'.$data.\'%\')->pluck(\'id\');
    return $this->builder->whereIn(\'franchisee_id\',$frs);
  }*/
}
  ';
  file_put_contents("app/Filters/".$this->argument('filterName').".php",$dummyContent);
    }
	 
}
