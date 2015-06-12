<?php

namespace JamylBot;

use Illuminate\Database\Eloquent\Model;

class Alliance extends Model {
	protected $fillable = ['id', 'name', 'ticker', 'executor_corp_id', 'members', 'start_date'];
	protected $primaryKey='id';
	public function corporations() {
		return $this->belongsTo ( 'JamylBot\Corp' );
	}
	public function updateAlliance($allianceInfo)
	{
		if ($this->alliance_id != $allianceInfo->allianceID) {
			$this->alliance_id = $allianceInfo->allianceID;
			$this->alliance_name = $allianceInfo->allianceName;
		}
		if ($this->ceo_id != $allianceInfo->ceoID) {
			$this->ceo_id = $allianceInfo->ceoID;
			$this->ceo_name = $allianceInfo->ceoName;
		}
		//$this->next_check = $corpInfo['cachedUntil'];
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

}
