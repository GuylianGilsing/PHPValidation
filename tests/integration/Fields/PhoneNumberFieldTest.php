<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;

use function PHPValidation\Functions\phoneNumber;

final class PhoneNumberFieldTest extends TestCase
{
    public function testIfMatchingFormatIsValid(): void
    {
        // Arrange
        $matchingPhoneNumbers = [
            '+31612345678',
            '+43720884749',
            '+498941207250',
            '+498941209783',
            '+4578755306',
            '+498941207269',
            '+358942720607',
            '+33974592518',
            '+498941207295',
            '+498941207269',
            '+353768887790',
            '+390694804537',
            '+31850012614',
            '+498912089270',
            '+48222639537',
            '+351308805968',
            '+74996481520',
            '+34944580370',
            '+46108886652',
            '+498941209780',
            '+908503902867',
            '+441233225114',
        ];

        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [phoneNumber()],
        ]);

        $validator = $builder->build();

        foreach ($matchingPhoneNumbers as $matchingPhoneNumber)
        {
            // Act
            $isValid = $validator->isValid(['field' => $matchingPhoneNumber]);

            // Assert
            $errorMessages = $validator->getErrorMessages();

            $this->assertTrue($isValid, $matchingPhoneNumber.' does not match.');
            $this->assertEmpty($errorMessages);
        }
    }

    public function testIfNonMatchingFormatIsValid(): void
    {
        // Arrange
        $nonMatchingPhoneNumbers = [
            '+55114560-7834',
        ];

        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [phoneNumber()],
        ]);

        $validator = $builder->build();

        foreach ($nonMatchingPhoneNumbers as $nonMatchingPhoneNumber)
        {
            // Act
            $isValid = $validator->isValid(['field' => $nonMatchingPhoneNumber]);

            // Assert
            $errorMessages = $validator->getErrorMessages();

            $this->assertFalse($isValid);
            $this->assertNotEmpty($errorMessages);

            $expectedErrorStructure = [
                'field' => [
                    phoneNumber()->getKey() => phoneNumber()->getErrorMessage()
                ]
            ];

            $this->assertEquals($expectedErrorStructure, $errorMessages);
        }
    }
}
