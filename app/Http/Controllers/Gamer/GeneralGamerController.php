<?php

use App\Http\Controllers\Controller;
use App\Models\Pubgm;
use App\Models\StatisticPubgm;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GeneralGamerController extends Controller {

    public function profile() {
        $gamer = auth()->user();
        return ApiResponse::send(200, $gamer);
    }

    public function addPubgm(Request $request) {
        $rules = [
            'GamerID' => 'required|integer',
            'InGameName' => 'sometimes|required|string',
            'PubgmID' => 'sometimes|required|string',
            'BestGameplay' => 'sometimes|required|string'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiResponse::send(422, $validator->errors());
        }

        $pubgm = new Pubgm();
        $pubgm->GamerID = auth()->user()->ID;
        $pubgm->InGameName = ($request->has('InGameName')) ? $request->InGameName : null;
        $pubgm->PubgmID = ($request->has('PubgmID')) ? $request->PubgmID : null;
        $pubgm->BestGameplay = ($request->has('BestGameplay')) ? $request->BestGameplay : null;

        $pubgm->save();
    }

    public function addStatistic(Request $request) {
        $rules = [
            'Type' => 'required|string',
            'Mode' => 'required|string',
            'Season' => 'required|integer',
            'Server' => 'required|string',
            'FileOverview' => 'required|string',
            'FileStatistic' => 'required|string',
            'RatioKD' => 'required|float',
            'MatchesPlayed' => 'required|integer',
            'Kills' => 'required|integer'
        ];  

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiResponse::send(422, $validator->errors());
        }
        
        $statisticPubgmGamer = StatisticPubgm::where('ID', auth()->user()->ID)->get();

        foreach ($statisticPubgmGamer as $statistc) {
            if ($request->Season === $statistc->Season) {
                return ApiResponse::message(ApiResponse::SEASON_CREATED);
            }
        }

        $statisticPubgm = new StatisticPubgm();
        $statisticPubgm->ID = auth()->user()->ID;
        $statisticPubgm->Type = $request->Type;
        $statisticPubgm->Mode = $request->Mode;
        $statisticPubgm->Season = $request->Season;
        $statisticPubgm->Server = $request->Server;
        $statisticPubgm->FileOverview = $request->FileOverview;
        $statisticPubgm->FileStatistic = $request->FileStatistic;
        $statisticPubgm->RatioKD = $request->RatioKD;
        $statisticPubgm->MatchesPlayed = $request->MatchesPlayed;
        $statisticPubgm->Kills = $request->Kills;

        $statisticPubgm->save();

        return ApiResponse::send(204);
    }
}