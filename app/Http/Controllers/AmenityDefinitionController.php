<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreAmenityDefinitionRequest;
use App\Http\Requests\UpdateAmenityDefinitionRequest;
use App\Models\AmenityDefinition;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AmenityDefinitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('AmenityDefinition/Index', [
            'definitions' => AmenityDefinition::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('AmenityDefinition/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAmenityDefinitionRequest $request): void
    {
        AmenityDefinition::createOrRestore([
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(AmenityDefinition $amenityDefinition): \Inertia\Response
    {
        return Inertia::render('AmenityDefinition/Show', compact('amenityDefinition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AmenityDefinition $amenityDefinition): \Inertia\Response
    {
        return Inertia::render('AmenityDefinition/Edit', compact('amenityDefinition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAmenityDefinitionRequest $request, AmenityDefinition $amenityDefinition): void
    {
        $amenityDefinition->fill($request->validated())->save();
    }

    /**
     * Mark the specified resource as deleted.
     */
    public function destroy(AmenityDefinition $amenityDefinition): void
    {
        $amenityDefinition->delete();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function forceDestroy(AmenityDefinition $amenityDefinition): void
    {
        $amenityDefinition->forceDelete();
    }
}
