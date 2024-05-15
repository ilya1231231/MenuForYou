<?php

use App\Validator\Infrastructure\IValidator;
use App\Validator\Infrastructure\SPI\IValidatorFactory;

class UserValidatorBuilder
{
    private IValidatorFactory $validatorFactory;

    public function __construct(IValidatorFactory $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;
    }

    public function registerUserValidator(array $data): IValidator
    {
        $rules = [
            'is_demo_exam_held' => 'required|boolean',
            'global_rus_organizations_demo_exam_median_value_result' =>
                'required_if:is_demo_exam_held,true|numeric|between:0,999.99',
            'organization_demo_exam_median_value_result' => 'required_if:is_demo_exam_held,true|numeric|between:0,999.99',
            'prog_id' => 'required|gt:0',
        ];

        $locLabels = [
            'global_rus_organizations_demo_exam_median_value_result' =>
                'Медианное значение результата демонстрационного экзамена в образовательных организациях Российской Федерации, 
                реализующих ОП СПО за последние 12 месяцев.',
            'organization_demo_exam_median_value_result' =>
                'Медианное значение результата демонстрационного экзамена в конкретной образовательной организации, 
                учитывающее результаты хронологически последней аттестации (как промежуточной, так и итоговой), 
                проведенной по конкретной ОП СПО.',
            'is_demo_exam_held' => 'По образовательной программе проводился демонстрационный экзамен',

            'prog_id' => 'Идентификатор образовательной программы',
        ];
        return $this->validatorFactory->createValidator($data, $rules, [], $locLabels);
    }
}