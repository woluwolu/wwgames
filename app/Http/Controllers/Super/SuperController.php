<?php
namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\ImageNews;
use App\Models\News;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Player;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TransferPlayer;

class SuperController extends Controller {

    public function index() {
        $superUser = auth()->user();
        return ApiResponse::send(200, $superUser);
    }

    public function addTeam(Request $request) {
        $rules = [
            'TeamName' => 'required|string',
            'Location' => 'required|string',
            'DescriptionTeam' => 'sometimes|required|string',
            'LogoTeam' => 'sometimes|required|string',
            'EstablishedSince' => 'sometimes|required|date',
            'Owner' => 'sometimes|required|string',
            'SocialMediaTeam' => 'sometimes|required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiResponse::send(422, $validator->fails());
        }

        $team = new Team();
        $team->TeamName = $request->TeamName;
        $team->Location = $request->Location;
        $team->DescriptionTeam = $request->DescriptionTeam;
        $team->LogoTeam = $request->LogoTeam;
        $team->EstablishedSince = $request->EstablishedSince;
        $team->Owner = $request->Owner;
        $team->SocialMediaTeam = $request->SocialMediaTeam;
        $team->save();

        return ApiResponse::send(204);
    } 

    public function createNews(Request $request) 
    {
        $user = auth()->user();

        $rules = [
            'ImageNews' => 'sometimes|required|string',
            'TitleNews' => 'required|string',
            'NewsContent' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return ApiResponse::send(422, $validator->fails());
        }

        $news = new News();
        $news->TitleNews = $request->TitleNews;
        $news->NewsContent = $request->NewsContent;
        $news->CreatedBy = $user->Username;
        $news->save();

        $imageNews = new ImageNews();
        $imageNews->NewsID = $news->id;
        $imageNews->ImageNews = $request->ImageNews;
        $imageNews->save();

        return ApiResponse::send(204);
    }

    public function deleteNews($id) {
        $news = News::where('id', $id)->first();
        $news->delete();

        $imageNews = ImageNews::where('id', $id)->get();
        foreach ($imageNews as $image) {
            $image->delete();
        }

        return ApiResponse::send(204);
    }

    public function updateNews() {

    }

    public function addPlayer(Request $request) 
    {
        $rules = [
            'PlayerGameName' => 'required|string',
            'PlayerName' => 'required|string',
            'Country' => 'sometimes|required|string',
            'Birthdate' => 'sometimes|required|date',
            'AvatarPlayer' => 'sometimes|required|string',
            'InGameRole' => 'sometimes|required|string',
            'Team' => 'required|string',
            'GameType' => 'required|string',
            'StatusPlayer' => 'required|string',
            'SocialMediaPlayer' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiResponse::send(422, $validator->fails());
        }

        $player = new Player();
        $player->PlayerGameName = $request->PlayerGameName;
        $player->PlayerName = $request->PlayerName;
        $player->Country = $request->Country;
        $player->Birthdate = $request->Birthdate;
        $player->AvatarPlayer = $request->AvatarPlayer;
        $player->InGameRole = $request->InGameRole;
        $player->Team = $request->Team;
        $player->GameType = $request->GameType;
        $player->StatusPlayer = $request->StatusPlayer;
        $player->SocialMediaPlayer = $request->SocialMediaPlayer;
        $player->save();

        return ApiResponse::send(204);
    }

    public function deletePlayer($id) {
        $player = Player::where('id', $id)->first();
        $player->delete();

        return ApiResponse::send(204);
    }

    public function updatePlayer(Request $request,$playerId) {

        $rules = [
            'PlayerGameName' => 'sometimes|required|string',
            'PlayerName' => 'sometimes|required|string',
            'Country' => 'sometimes|required|string',
            'Birthdate' => 'sometimes|required|date',
            'AvatarPlayer' => 'sometimes|required|string',
            'InGameRole' => 'sometimes|required|string',
            'Team' => 'sometimes|required|string',
            'GameType' => 'sometimes|required|string',
            'StatusPlayer' => 'sometimes|required|string',
            'SocialMediaPlayer' => 'sometimes|required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiResponse::send(422, $validator->fails());
        }

        $player = Player::where('id', $playerId)->first();

        if ($request->has('PlayerGameName')) {
            $player->PlayerGameName = $request->PlayerGameName;
        }

        if ($request->has('PlayerName')) {
            $player->PlayerName = $request->PlayerName;
        }

        if ($request->has('Country')) {
            $player->Country = $request->Country;
        }

        if ($request->has('Birthdate')) {
            $player->Birthdate = $request->Birthdate;
        }

        if ($request->has('AvatarPlayer')) {
            $player->AvatarPlayer = $request->AvatarPlayer;
        }

        if ($request->has('InGameRole')) {
            $player->InGameRole = $request->InGameRole;
        }

        if ($request->has('Team')) {
            $player->Team = $request->Team;
        }

        if ($request->has('GameType')) {
            $player->GameType = $request->GameType;
        }

        if ($request->has('StatusPlayer')) {
            $player->StatusPlayer = $request->StatusPlayer;
        }

        if ($request->has('SocialMediaPlayer')) {
            $player->SocialMediaPlayer = $request->SocialMediaPlayer;
        }
        
        $player->save();

        return ApiResponse::send(204);
    }

    public function addTournament(Request $request) {
        $rules = [
            'GameID' => 'required|integer',
            'TournamentName' => 'required|string',
            'DescriptionTournament' => 'required|string',
            'TotalPrice' => 'required|string',
            'TournamentImage' => 'required|string',
            'StandingID' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return ApiResponse::send(422, $validator->fails());
        }

        $tournament = new Tournament;
        $tournament->GameID = $request->GameID;
        $tournament->TournamentName = $request->TournamentName;
        $tournament->DescriptionTournament = $request->DescriptionTournament;
        $tournament->TotalPrice = $request->TotalPrice;
        $tournament->TournamentImage = $request->TournamentImage;
        $tournament->StandingID = $request->StandingID;
        $tournament->save();

        return ApiResponse::send(204);
    }

    public function exchangePlayer(Request $request) {
        $rules = [
            'PlayerID' => 'required|integer',
            'GameID' => 'required|integer',
            'OldTeam' => 'required|integer',
            'NewTeam' => 'required|integer',
            'TransferDate' => 'required|integer'
        ];

        $validator = Validator::make($request->all, $rules);
        if ($validator->fails()){
            return ApiResponse::send(422, $validator->fails());
        }

        $transferPlayer = new TransferPlayer;
        $transferPlayer->PlayerID = $request->PlayerID;
        $transferPlayer->GameID = $request->GameID;
        $transferPlayer->OldTeam = $request->OldTeam;
        $transferPlayer->NewTeam = $request->NewTeam;
        $transferPlayer->TransferDate = $request->TransferDate;
        $transferPlayer->save();

        Player::where('id', $request->PlayerID)->update([
            'Team' => $request->NewTeam
        ]);

        return ApiResponse::send(204);
    }
}