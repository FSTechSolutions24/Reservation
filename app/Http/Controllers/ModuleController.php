<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Facades\Module as ModuleFacade;

class ModuleController extends Controller
{
    public function index()
    {
        return response()->json(Module::all());
    }

    public function install($moduleName)
    {

        $module = Module::uninstalledByName($moduleName)->firstOrFail();

        Artisan::call("module:enable", ['module' => $moduleName]);    
            
        $module->update(['enabled' => 1]);
            
        return response()->json(['message' => "Module '{$moduleName}' has been installed successfully."]);                            
        
    }

    public function migrate($moduleName)
    {

        Module::installedByName($moduleName)->firstOrFail();

        Artisan::call("module:migrate", ['module' => $moduleName]);   

        return response()->json(['message' => "Module '{$moduleName}' has been migrated successfully."]);
        
    }

    public function uninstall($moduleName)
    {

        $module = Module::installedByName($moduleName)->firstOrFail();

        Artisan::call("module:disable", ['module' => $moduleName]);
            
        $module->update(['enabled' => 0]);
            
        return response()->json(['message' => "Module '{$moduleName}' has been uninstalled successfully."]); 

    }

    public function scanAndRegisterModules()
    {

        // Get all installed modules
        $modules = ModuleFacade::all();

        foreach ($modules as $moduleName => $module) {
            Module::updateOrCreate(
                ['name' => $moduleName], 
                ['enabled' => $module->isEnabled()]
            );
        }

        return response()->json(['message' => 'All modules have been scanned and registered successfully.']);

    }

}
