<?php

/**
 * Edit view class
 * @package YetiForce.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Settings_PBX_EditModal_View extends Settings_Vtiger_BasicModal_View
{

	/**
	 * Process
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		parent::preProcess($request);
		$qualifiedModuleName = $request->getModule(false);
		$recordId = $request->getInteger('record');
		if ($recordId) {
			$recordModel = Settings_PBX_Record_Model::getInstanceById($recordId);
		} else {
			$recordModel = Settings_PBX_Record_Model::getCleanInstance();
		}
		if ($request->getBoolean('connectorConfig')) {
			$recordModel->set('type', $request->get('type'));
		}
		$viewer = $this->getViewer($request);
		$viewer->assign('RECORD_ID', $recordId);
		$viewer->assign('RECORD_MODEL', $recordModel);
		$viewer->assign('MODULE_MODEL', $recordModel->getModule());
		$viewer->assign('CONNECTOR_CONFIG', $request->getBoolean('connectorConfig'));
		$viewer->view('EditModal.tpl', $qualifiedModuleName);
		parent::postProcess($request);
	}
}
