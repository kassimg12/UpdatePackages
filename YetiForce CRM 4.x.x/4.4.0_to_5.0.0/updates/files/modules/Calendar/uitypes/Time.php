<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Calendar_Time_UIType extends Vtiger_Time_UIType
{
	/**
	 * {@inheritdoc}
	 */
	public function getEditViewDisplayValue($value, $recordModel = false)
	{
		if (!empty($value)) {
			return parent::getEditViewDisplayValue($value, $recordModel);
		}
		$specialTimeFields = ['time_start', 'time_end'];
		$fieldName = $this->get('field')->getFieldName();
		if (!in_array($fieldName, $specialTimeFields)) {
			return parent::getEditViewDisplayValue($value, $recordModel);
		} else {
			return $this->getDisplayTimeDifferenceValue($fieldName, $value);
		}
	}

	/**
	 * Function to get the calendar event call duration value in hour format.
	 *
	 * @param type $fieldName
	 * @param type $value
	 *
	 * @return <Vtiger_Time_UIType> - getTimeValue
	 */
	public function getDisplayTimeDifferenceValue($fieldName, $value)
	{
		$userModel = Users_Privileges_Model::getCurrentUserModel();
		$date = new DateTime($value);

		if ($fieldName === 'time_end' && empty($value)) {
			$defaultCallDuration = $userModel->get('callduration');
			$date->modify("+{$defaultCallDuration} minutes");
		}

		$dateTimeField = new DateTimeField($date->format('Y-m-d H:i:s'));
		return $dateTimeField->getDisplayTime();
	}
}