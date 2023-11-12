<?php

namespace App\Models;

use App\Model;
use App\Models\Events\CreateUpdateEvents;

/**
 * Class Employees
 *
 * @package App\Models
 * @property string $name
 * @property string $jobTitle
 * @property string $department
 * @property string $fullOrPartTime
 * @property string $salaryOrHourly
 * @property int $typicalHours
 * @property float $annualSalary
 * @property float $hourlyRate
 */

class Employee extends Model
{
    use CreateUpdateEvents;
    // Обычно добавление полей created_at, updated_at является хорошей практикой,
    // но в датасете они не предусмотрены, так что оставим без них
    // Поле id по умолчанию создается в бд, смысла объявлять его в модели не вижу
    
    // public int $id;
    public string $name;
	public string $jobTitle;
	public string $department;
	public string $fullOrPartTime;
	public string $salaryOrHourly;
	public ?int $typicalHours = null;
	public ?float $annualSalary = null;
	public ?float $hourlyRate = null;
    // public string  $created_at;
	// public ?string $updated_at = null;

}