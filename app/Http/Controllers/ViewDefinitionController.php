<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreViewDefinitionRequest;
use App\Http\Requests\UpdateViewDefinitionRequest;
use App\Models\ViewDefinition;
use Inertia\Inertia;

class ViewDefinitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('ViewDefinition/Index', [
            'definitions' => ViewDefinition::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('ViewDefinition/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreViewDefinitionRequest $request): void
    {
        ViewDefinition::createOrRestore([
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ViewDefinition $viewDefinition): \Inertia\Response
    {
        return Inertia::render('ViewDefinition/Show', compact('viewDefinition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ViewDefinition $viewDefinition): \Inertia\Response
    {
        return Inertia::render('ViewDefinition/Edit', compact('viewDefinition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateViewDefinitionRequest $request, ViewDefinition $viewDefinition): void
    {
        $viewDefinition->fill($request->validated())->save();
    }

    /**
     * Mark the specified resource from storage.
     */
    public function destroy(ViewDefinition $viewDefinition): void
    {
        $viewDefinition->delete();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function forceDestroy(ViewDefinition $viewDefinition): void
    {
        $viewDefinition->delete();
    }
}
