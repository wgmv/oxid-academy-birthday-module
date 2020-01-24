<?php


namespace OxidAcademy\Birthday\Model;

use OxidEsales\Eshop\Application\Model\VoucherSerie;
use OxidEsales\Eshop\Core\Registry;

if(false) {
    class_alias(\OxidEsales\Eshop\Application\Model\User::class, 'OxidAcademy\Birthday\Model\User_parent');
}

class User extends User_parent
{
    /**
     * @throws \Exception
     */
    public function hasBirthday() : bool
    {
        $birthdayObj = new \DateTimeImmutable($this->getFieldData('oxbirthdate'));

        return $birthdayObj->format('m-d') == (new \DateTimeImmutable())->format('m-d');
    }

    public function getBirthdayVoucherCode()
    {
//        $logger = Registry::getLogger();
//        $logger->info('yo1');
        if($this->hasBirthday()) {
            return oxNew(VoucherSerie::class)->getBirthdayVoucherCode($this);
        }
    }
}