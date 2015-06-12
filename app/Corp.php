<?php

namespace JamylBot;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Corp extends Model {
	protected $fillable = ['id', 'name', 'alliance_id', 'alliance_name', 'ticker', 'ceo_id', 'ceo_name'];
	protected $primaryKey='id';
	
	public function members() {
		return $this->belongsTo ( 'JamylBot\User' );
	}
	public function alliance() {
		return $this->belongsTo ( 'JamylBot\Alliance' );
	}
	public function updateCorporations($corpInfo)
	{
		if ($this->name != $corpInfo["corporationName"]) {
			$this->name = $corpInfo["corporationName"];
		}
		if ($this->alliance_id != $corpInfo["allianceID"]) {
			$this->alliance_id = $corpInfo["allianceID"];
		}
		if ($this->ticker != $corpInfo["ticker"]) {
			$this->ticker = $corpInfo["ticker"];
		}
		if ($this->ceo_id != $corpInfo["ceoID"]) {
			$this->ceo_id = $corpInfo["ceoID"];
		}
		if ($this->ceo_name != $corpInfo["ceoID"]) {
			$this->ceo_name = $corpInfo["ceoName"];
		}
		$this->next_check = $corpInfo['cachedUntil'];
		$this->save();
	}
	/**
	 * @return array
	 */
	public function getDates()
	{
		return ['created_at', 'updated_at', 'next_check'];
	}
	
	/**
	 * @return bool
	 */
	public function needsUpdate()
	{
		return $this->next_check === null || $this->next_check->lte(Carbon::now());
	}
	/**
	 * @param int $limit
	 *
	 * @return array
	 */
	public static function listNeedUpdateIds($limit)
	{
		$allCorps = Corp::all();
		$corps = [];
		foreach ($allCorps as $corp) {
			if ($corp->needsUpdate()) {
				$corps[] = $corp->id;
				if (count($corps) >= $limit)
					return $corps;
			}
		}
		return $corps;
	}

}
