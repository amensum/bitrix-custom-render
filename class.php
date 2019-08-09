<?

use \Bitrix\Main\Loader;

/**
 * Class Render
 */
class Render extends CBitrixComponent {
	
	public function executeComponent() {
		
		if (!Loader::includeModule("iblock")) die();
		
		$db_list = \CIBlockElement::GetList(
			$this->arParams["ORDER"],
			$this->arParams["FILTER"],
			false,
			false,
			$this->arParams["FIELDS"]
		);
		while ($db_el = $db_list->GetNext()) {
			$db_el["PREVIEW_PICTURE"] = CFile::ResizeImageGet(
				$db_el["PREVIEW_PICTURE"],
				[
					"width" => $this->arParams["PICTURES_WIDTH"],
					"height" => $this->arParams["PICTURES_HEIGHT"]
				],
				BX_RESIZE_IMAGE_PROPORTIONAL
			);
			$db_el["DETAIL_PICTURE"] = CFile::ResizeImageGet(
				$db_el["DETAIL_PICTURE"],
				[
					"width" => $this->arParams["PICTURES_WIDTH"],
					"height" => $this->arParams["PICTURES_HEIGHT"]
				],
				BX_RESIZE_IMAGE_PROPORTIONAL
			);
			$this->arResult[] = $db_el;
		}
		unset($db_list);
		
		$this->IncludeComponentTemplate();
	}
}