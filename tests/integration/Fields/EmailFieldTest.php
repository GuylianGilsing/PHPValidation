<?php

declare(strict_types=1);

namespace PHPValidation\Tests\Integration\Fields;

use PHPUnit\Framework\TestCase;
use PHPValidation\Builders\ValidatorBuilder;

use function PHPValidation\Functions\email;

final class EmailFieldTest extends TestCase
{
    public function testIfMatchingEmailAddressesAreValid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [email()],
        ]);

        $validator = $builder->build();

        $validAddresses = [
            'email@example.com',
            'firstname.lastname@example.com',
            'email@subdomain.example.com',
            'firstname+lastname@example.com',
            'email@123.123.123.123',
            '"email"@example.com',
            '1234567890@example.com',
            'email@example-one.com',
            '_______@example.com',
            'email@example.name',
            'email@example.museum',
            'email@example.co.jp',
            'firstname-lastname@example.com',
            'email@example.web',
            'email@111.222.333.44444',
        ];

        $errorMessages = [];

        foreach ($validAddresses as $validAddress)
        {
            // Act
            $isValid = $validator->isValid([
                'field' => $validAddress,
            ]);

            // Assert
            array_merge($errorMessages, $validator->getErrorMessages());

            $this->assertTrue($isValid, 'Email: '.$validAddress.' is not valid.');
        }

        $this->assertEmpty($errorMessages);
    }

    public function testIfInvalidEmailAddressesAreInvalid(): void
    {
        // Arrange
        $builder = new ValidatorBuilder();

        $builder->setValidators([
            'field' => [email()],
        ]);

        $validator = $builder->build();

        $invalidAddresses = [
            'plainaddress',
            '#@%^%#$@#$@#.com',
            'email@[123.123.123.123]',
            'very.unusual.”@”.unusual.com@example.com',
            'very.”(),:;<>[]”.VERY.”very@\\ "very”.unusual@strange.example.com',
            '@example.com',
            'Joe Smith <email@example.com>',
            'email.example.com',
            'email@example@example.com',
            '.email@example.com',
            'email.@example.com',
            'email..email@example.com',
            'あいうえお@example.com',
            'email@example.com (Joe Smith)',
            'email@example',
            'email@-example.com',
            'email@example..com',
            'Abc..123@example.com',
            '”(),:;<>[\]@example.com',
            'just”not”right@example.com',
            'this\ is"really"not\allowed@example.com',
        ];

        foreach ($invalidAddresses as $invalidAddress)
        {
            // Act
            $isValid = $validator->isValid([
                'field' => $invalidAddress,
            ]);

            // Assert
            $errorMessages = $validator->getErrorMessages();

            $this->assertFalse($isValid, 'Email: '.$invalidAddress.' is valid.');
            $this->assertNotEmpty($errorMessages);

            $expectedErrorStructure = [
                'field' => [
                    email()->getKey() => email()->getErrorMessage(),
                ]
            ];

            $this->assertEquals($expectedErrorStructure, $errorMessages);
        }
    }
}
