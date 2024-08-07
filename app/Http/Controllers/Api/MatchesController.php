<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MatcheService;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    private $matcheService;
    public function __construct(MatcheService $matcheService)
    {
        $this->matcheService = $matcheService;
    }

    public function index(Request $request)
    {
        return $this->matcheService->index();
    }

    public function show(Request $request, $id)
    {
        return $this->matcheService->show($id);
    }

    public function store(Request $request)
    {
        return $this->matcheService->store($request->all());
    }

    public function update(Request $request, $id)
    {
        return $this->matcheService->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->matcheService->destroy($id);
    }
}
