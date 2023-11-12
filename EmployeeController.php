<?php

namespace App\Modules\Api\V1\Controllers;

use App\Enums\ErrorCodes;
use App\Models\Employees;
use App\Modules\Api\V1\Controller;
use Exception;

class EmployeeController extends Controller {

	/**
	 * @OA\Get(
	 *     path="/Employee/getEmployeeInfo",
	 *     summary="Получение информации о работнике по имени",
	 *     description="",
	 *     tags={"Employee"},
	 *     @OA\Response(
	 *          response="200",
	 *          description="Success",
	 *          @OA\JsonContent(
	 *              ref="#/components/schemas/EmployeeListResponse"
	 *          )
	 *     ),
	 *      @OA\Response(
	 *          response="404",
	 *          description="Работники, удовлетворяющие параметрам запроса, не найдены.",
	 *     ),
	 *     deprecated=false
	 *
	 * )
	 * @throws Exception
	 */
	public function getEmployeeInfoAction() {
		if ($this->request->isPost()) {
			$requestData = $this->request->getJsonRawBody();

			if (!empty($requestData->name)) {
				$employee = Employees::findFirst([
					'conditions' => 'name = :name:',
					'bind' => ['name' => $requestData->name]
				]);

				if ($employee) {
					$this->response->setJsonContent($employee);
					return $this->response;
				}
			}
		}

		$this->errorJsonDie(ErrorCodes::BAD_REQUEST);
	}
}