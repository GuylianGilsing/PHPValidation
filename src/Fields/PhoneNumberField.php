<?php

declare(strict_types=1);

namespace PHPValidation\Fields;

final class PhoneNumberField implements FieldValidatorInterface
{
    public function fieldNeedsToExist(): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return 'phoneNumber';
    }

    /**
     * @param array<mixed> $givenData
     */
    public function isValid(bool $fieldExists, mixed $fieldData, array $givenData): bool
    {
        if (!is_string($fieldData))
        {
            return false;
        }

        $regex = '';

        // International phone number validation regex:
        // https://stackoverflow.com/questions/2113908/what-regular-expression-will-match-valid-international-phone-numbers
        // Modified the original regex to accept leading 0s for the following format: +31 06 12345678
        $regex .= '(\+|00)(297|93|244|1264|358|355|376|971|54|374|1684|1268|61|43|994|257|32|229|226|880|359|973|1242|';
        $regex .= '387|590|375|501|1441|591|55|1246|673|975|267|236|1|61|41|56|86|225|237|243|242|682|57|269|238|506|5';
        $regex .= '3|5999|61|1345|357|420|49|253|1767|45|1809|1829|1849|213|593|20|291|212|34|372|251|358|679|500|33|2';
        $regex .= '98|691|241|44|995|44|233|350|224|590|220|245|240|30|1473|299|502|594|1671|592|852|504|385|509|36|62';
        $regex .= '|44|91|246|353|98|964|354|972|39|1876|44|962|81|76|77|254|996|855|686|1869|82|383|965|856|961|231|2';
        $regex .= '18|1758|423|94|266|370|352|371|853|590|212|377|373|261|960|52|692|389|223|356|95|382|976|1670|258|2';
        $regex .= '22|1664|596|230|265|60|262|264|687|227|672|234|505|683|31|47|977|674|64|968|92|507|64|51|63|680|675';
        $regex .= '|48|1787|1939|850|351|595|970|689|974|262|40|7|250|966|249|221|65|500|4779|677|232|503|378|252|508|';
        $regex .= '381|211|239|597|421|386|46|268|1721|248|963|1649|235|228|66|992|690|993|670|676|1868|216|90|688|886';
        $regex .= '|255|256|380|598|1|998|3906698|379|1784|58|1284|1340|84|678|681|685|967|27|260|263)(9[976]\d|(?:0)?';
        $regex .= '8[987530]\d|(?:0)?6[987]\d|(?:0)?5[90]\d|42\d|(?:0)?3[875]\d|(?:0)?2[98654321]\d|(?:0)?9[8543210]|(';
        $regex .= '?:0)?8[6421]|(?:0)?6[6543210]|(?:0)?5[87654321]|(?:0)?4[987654310]|(?:0)?3[9643210]|(?:0)?2[70]|(?:';
        $regex .= '0)?7|(?:0)?1)\d{4,20}$';

        preg_match('~'.$regex.'~', $fieldData, $matches);

        $totalMatches = count($matches);

        if ($totalMatches < 1)
        {
            return false;
        }

        return $matches[0] === $fieldData;
    }

    public function getErrorMessage(): string
    {
        return 'This field must contain a valid international phone number';
    }
}
