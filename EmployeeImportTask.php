<?php

namespace App\Cli\Tasks;

use App\Cli\Task;
use App\Models\Employees;

class EmployeeImportTask extends Task {
	public function importAction(): void {
		$csvFile = 'data.csv';

		$handle = fopen($csvFile, "r");

		if ($handle !== false) {
			$header = fgetcsv($handle);

			$importGenerator = function () use ($handle) {
				while (($data = fgetcsv($handle, 1000, ",")) !== false) {
					yield $data;
				}
				fclose($handle);
			};

			foreach ($importGenerator() as $data) {
				$employee = new Employees();
				foreach ($header as $key => $column) {
					$columnName = strtolower(str_replace(' ', '', $column));
					if ($columnName === 'name') {
						$employee->name = $data[$key];
					} elseif ($columnName === 'jobtitles') {
						$employee->jobTitle = $data[$key];
					} elseif ($columnName === 'department') {
						$employee->department = $data[$key];
					} elseif ($columnName === 'fullorpart-time') {
						$employee->fullOrPartTime = $data[$key];
					} elseif ($columnName === 'salaryorhourly') {
						$employee->salaryOrHourly = $data[$key];
					} elseif ($columnName === 'typicalhours') {
						$employee->typicalHours = !empty($data[$key]) ? (int)$data[$key] : null;
					} elseif ($columnName === 'annualsalary') {
						$employee->annualSalary = !empty($data[$key]) ? (float)$data[$key] : null;
					} elseif ($columnName === 'hourlyrate') {
						$employee->hourlyRate = !empty($data[$key]) ? (float)$data[$key] : null;
					}
				}

				if ($employee->save() === false) {
					foreach ($employee->getMessages() as $message) {
						echo "Error: ", $message, "\n";
					}
				}
			}
		} else {
			echo "Unable to open file.";
		}
	}
}
