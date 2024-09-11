<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StorePolicyDefinitionRequest;
use App\Http\Requests\UpdatePolicyDefinitionRequest;
use App\Models\PolicyDefinition;
use Inertia\Inertia;

class PolicyDefinitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('PolicyDefinition/Index', [
            'definitions' => PolicyDefinition::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('PolicyDefinition/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePolicyDefinitionRequest $request): void
    {
        PolicyDefinition::createOrRestore([
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PolicyDefinition $policyDefinition): \Inertia\Response
    {
        return Inertia::render('PolicyDefinition/Show', compact('policyDefinition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PolicyDefinition $policyDefinition): \Inertia\Response
    {
        return Inertia::render('PolicyDefinition/Edit', compact('policyDefinition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePolicyDefinitionRequest $request, PolicyDefinition $policyDefinition): void
    {
        $policyDefinition->fill($request->validated())->save();
    }

    /**
     * Mark the specified resource as deleted.
     */
    public function destroy(PolicyDefinition $policyDefinition): void
    {
        $policyDefinition->delete();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function forceDestroy(PolicyDefinition $policyDefinition): void
    {
        $policyDefinition->delete();
    }
}
