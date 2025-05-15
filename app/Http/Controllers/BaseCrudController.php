<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

abstract class BaseCrudController extends Controller
{
    protected string $model;
    protected ?string $translationRelation = null;
    protected array $mainFields = [];
    protected array $translationFields = [];
    

    abstract protected function validationRules(Request $request, $id = null): array;

    public function index(): JsonResponse
    {
        $query = ($this->model)::query();
        if ($this->translationRelation) {
            $query->with($this->translationRelation);
        }

        return response()->json($query->get());
    }

    public function show($id): JsonResponse
    {
        $query = ($this->model)::query();
        if ($this->translationRelation) {
            $query->with($this->translationRelation);
        }

        $record = $query->findOrFail($id);
        return response()->json($record);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), $this->validationRules($request));

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }
    
        $validated = $validator->validated(); // Get the validated data

        $modelClass = $this->model;
        $record = null;

        DB::transaction(function () use ($validated, &$record, $modelClass) {
            $mainData = array_intersect_key($validated, array_flip($this->mainFields));
            $record = $modelClass::create($mainData);

            if ($this->translationRelation && $this->hasTranslationData($validated)) {
                $translationData = array_intersect_key($validated, array_flip($this->translationFields));
                $record->{$this->translationRelation}()->create($translationData);
            }
        });

        if ($this->translationRelation) {
            $record->load($this->translationRelation);
        }

        return response()->json($record, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), $this->validationRules($request,$id));

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }
    
        $validated = $validator->validated(); // Get the validated data

        $modelClass = $this->model;
        $record = $modelClass::findOrFail($id); // This is working as a required validation on the rules (check if the id exists or not)

        DB::transaction(function () use ($validated, &$record) {
            $mainData = array_intersect_key($validated, array_flip($this->mainFields));
            $record->update($mainData);

            if ($this->translationRelation && $this->hasTranslationData($validated)) {
                $translationData = array_intersect_key($validated, array_flip($this->translationFields));

                $existingTranslation = $record->{$this->translationRelation}()
                    ->where('locale', $translationData['locale'] ?? null)
                    ->first();

                if ($existingTranslation) {
                    $existingTranslation->update($translationData);
                } else {
                    $record->{$this->translationRelation}()->create($translationData);
                }
            }
        });

        if ($this->translationRelation) {
            $record->load($this->translationRelation);
        }

        return response()->json($record);
    }

    public function destroy($id): JsonResponse
    {
        $modelClass = $this->model;
        $record = $modelClass::findOrFail($id);
        $record->delete();

        return response()->json(['message' => 'Deleted successfully.']);
    }

    protected function hasTranslationData(array $data): bool
    {
        return !empty($this->translationFields) && count(array_intersect(array_keys($data), $this->translationFields)) > 0;
    }
}
