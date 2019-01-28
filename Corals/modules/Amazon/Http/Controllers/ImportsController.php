<?php

namespace Corals\Modules\Amazon\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Amazon\DataTables\ImportsDataTable;
use Corals\Modules\Amazon\Http\Requests\ImportRequest;
use Corals\Modules\Amazon\Models\Import;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;
use Corals\Modules\Ecommerce\Models\Brand;
use Corals\Modules\Ecommerce\Models\Category;
use Corals\Modules\Ecommerce\Models\Product;
use Corals\Modules\Ecommerce\Models\SKU;
use Spatie\MediaLibrary\Filesystem\Filesystem;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class ImportsController extends BaseController
{
    protected $excludedRequestParams = ['categories'];

    public function __construct()
    {
        $this->resource_url = config('amazon.models.import.resource_url');
        $this->title = 'Amazon::module.import.title';
        $this->title_singular = 'Amazon::module.import.title_singular';

        parent::__construct();
    }

    /**
     * @param ImportRequest $request
     * @param ImportsDataTable $dataTable
     * @return mixed
     */
    public function index(ImportRequest $request, ImportsDataTable $dataTable)
    {
        return $dataTable->render('Amazon::imports.index');
    }

    /**
     * @param ImportRequest $request
     * @return $this
     */
    public function create(ImportRequest $request)
    {
        $import = new Import();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Amazon::imports.create_edit')->with(compact('import'));
    }

    /**
     * @param ImportRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ImportRequest $request)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $import = Import::create($data);
            $import->categories()->sync($request->get('categories', []));

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Import::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param ImportRequest $request
     * @param Import $import
     * @return Import
     */
    public function show(ImportRequest $request, Import $import)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $import->title])]);

        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $import->hashed_id . '/edit']);

        return view('Amazon::imports.show')->with(compact('import'));
    }

    /**
     * @param ImportRequest $request
     * @param Import $import
     * @return $this
     */
    public function edit(ImportRequest $request, Import $import)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $import->title])]);

        return view('Amazon::imports.create_edit')->with(compact('import'));
    }

    /**
     * @param ImportRequest $request
     * @param Import $import
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ImportRequest $request, Import $import)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $import->update($data);
            $import->categories()->sync($request->get('categories', []));

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Import::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param ImportRequest $request
     * @param Import $import
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ImportRequest $request, Import $import)
    {
        try {
            $import->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Import::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

}